<?php
		require_once(realpath('../operations.php'));
		require_once '../GCM.php';	
		
		//dichiarazione invariabili
		$idCentro=8;
		$idSportello=1;

 if (isset($_GET['operation'])){
 	
	switch ($_GET['operation']) {
		
		
		//funzione displaya numero sportello
		
		case 'getNumber':
			printf($idSportello);
			break;
			
			
		//funzione displaya operazione	
			case 'getOper':
			
			$db = db_connect();
		
			if ($db){
					$query = "SELECT CONCAT(operazioni.CodiceLettera,' - ',operazioni.Descrizione) as Descrizione,operazioni.Id
							  FROM operazioni,sportelli	 WHERE sportelli.id_operazione_ext=operazioni.Id 
							  AND sportelli.Id=$idSportello";
					$result = $db->query($query);
					$record = $result->fetch_array(MYSQLI_ASSOC);
					echo json_encode($record);
			}
			db_disconnect($db);
			break;
			
			//funzione displaya cliente attuale	
			case 'getCliente':
			
			$db = db_connect();
		
			if ($db){
			$query = "SELECT operazioni.CodiceLettera,ticket.Numero FROM ticket,operazioni,sportelli 
					  WHERE ticket.Id_operazione_ext=operazioni.Id AND sportelli.Id=$idSportello 
					  AND sportelli.Id_ticketCurr_ext=ticket.Id";
			$result = $db->query($query);
			$record = $result->fetch_array(MYSQLI_ASSOC);
			printf("%s %s",$record['CodiceLettera'],$record['Numero']);
			
			if($record==NULL){
				
				printf("--");
			}
			
		}
			break;
			
			
			//funzione prendi le operazioni da mettere nella combobox
		
		case 'getOperazioni':
		
		$db = db_connect();
		
		if ($db){
		
			$query="SELECT operazioni.Id,CONCAT(operazioni.CodiceLettera,' ',operazioni.Descrizione) as Descrizione
					FROM sportelli,operazioni
					WHERE sportelli.Id_Centro_ext=$idCentro AND sportelli.Id_operazione_ext=operazioni.id
					GROUP BY operazioni.id";
			
			$result=$db->query($query);
			
			while ($row = mysqli_fetch_assoc($result)) {
						printf("<option value='%s'>%s</option>",$row['Id'],$row['Descrizione']);
			}
			
			// codifica dei risultati			
			
		} else{ echo('connessione fallita');}
		
		break;
		
		
		
		//cambia l'operazione
		
		case 'changeOperazione':
			$db = db_connect();
		
			if ($db){
				$newOper=$_GET['NuovaOperazione'];
				$query="UPDATE sportelli 
						SET sportelli.Id_operazione_ext=$newOper 
						WHERE sportelli.Id=$idSportello AND Id_Centro_ext=$idCentro";
			
			$result = $db->query($query);
			if ($result){echo('SUCCESS');}
			
			
		} else{ echo('connessione fallita');}
			
			
			
			break;
			
			//chiama il prossimo numero
			
		case 'avantiNumero':
			$ora = date('H:i:s');
			$data = date('d/m/y');
			
			$db = db_connect();
			if ($db){
		
		    //controllo se lo sportello non sta servendo 
		    
			$query="SELECT sportelli.Id_ticketCurr_ext,sportelli.Id_operazione_ext FROM sportelli WHERE sportelli.Id=$idSportello";
			$result = $db->query($query);
			$record = $result->fetch_array(MYSQLI_ASSOC);
			$idServito = $record['Id_ticketCurr_ext'];
			$idOperazione = $record['Id_operazione_ext'];
			//echo("id servito:".$idServito);
			//se lo sportello stava servendo 
			
			if($idServito!=NULL){
				
				// Cerco se il ticket appena servito aveva ququ7 
				// in caso affermativo cancello il record da utenti attivi e gli mando una notifica
				// azzerando window.ticket nel telefono 
				
				$query = "SELECT regid FROM utentiattivi WHERE utentiattivi.Id_Ticket_ext =".$idServito;
				echo($query);
				$result= $db->query($query);
				$record = $result->fetch_array(MYSQLI_ASSOC);
				if ($record['regid']<>'')
				{
						
					//echo("<br> sono dentro messaggio");
					$gcm = new GCM();
					$reg_ids = array($record['regid']);
					//echo($reg_ids);
					$message = array( 'message' => "Turno terminato");
					$gcm->send_notification($reg_ids,$message);
					$query = "DELETE FROM utentiattivi WHERE Id_Ticket_ext=$idServito";
					$result= $db->query($query);
				}
				
		// ------------ Aggiornamento del tempo di attesa degli utenti
			$query = "SELECT utentiattivi.regid,ticket.Id FROM utentiattivi,ticket WHERE ticket.id=utentiattivi.Id_Ticket_ext AND ticket.Id_operazione_ext=".$idOperazione;
			$result= $db->query($query);	
			while ($row = mysqli_fetch_assoc($result)) {
					CalcolaNuovaStima($row['regid'],$row['Id'],$idOperazione,$db);
						
			}
		//--------------------------------------------------------------------------------------------
				
	     		$query="UPDATE ticket SET ticket.OraFine='$ora' WHERE ticket.Id=$idServito";
				$result= $db->query($query);
				
			}
			
			// --------------------------- CHIAMATA NUMERO SUCCESSIVO ---------------
			//controllo se ci sono prossimi numeri da chiamare
			
			$query= "SELECT MIN(ticket.Id) as Id_ticket
					 FROM ticket
					 WHERE ticket.Id_operazione_ext=(SELECT sportelli.Id_operazione_ext FROM sportelli WHERE sportelli.Id =$idSportello) 
					 AND ticket.OraChiamata='00:00:00' AND ticket.Data='$data'";
			                                   
			$result=$db->query($query);
			$prossimo = $result->fetch_array(MYSQLI_ASSOC);
			
			//chiama il prossimo numero
		
			if($prossimo['Id_ticket']!=0){
				
		    $query="UPDATE ticket SET ticket.OraChiamata='$ora' 
			         WHERE ticket.Id=".$prossimo['Id_ticket'];
					 
			$result = $db->query($query);
			$query="UPDATE sportelli SET sportelli.Id_ticketCurr_ext=".$prossimo['Id_ticket']." WHERE sportelli.Id=$idSportello";
			$result = $db->query($query);
			
			}else{
					$query="UPDATE sportelli SET sportelli.Id_ticketCurr_ext=NULL WHERE sportelli.Id=$idSportello";
			        $result = $db->query($query);
					
				    echo ('nessun numero da servire, cambiare operazione per continuare a lavorare');
				   
				  }
			
			
		} else{ echo('connessione fallita');}
		
			
			break;
		
		
		
 }
 
 }

function CalcolaNuovaStima($regid,$ticket_id,$idOperazione,$db){
			// GUARDO GUANTE PERSONE SONO DAVANTI ALL'UTENTE
			$query = "SELECT ticket.Numero,ticket.Data FROM ticket WHERE ticket.id=".$ticket_id;
			$result= $db->query($query);
			$LuckyNumber = $result->fetch_array(MYSQLI_ASSOC);
			$query = "SELECT COUNT(ticket.id) as Totale FROM ticket WHERE Orafine ='00:00:00' AND ticket.Data='".$LuckyNumber['Data']."' and ticket.Numero<".$LuckyNumber['Numero']." and Id_operazione_ext =".$idOperazione;
			$result= $db->query($query);
			// PeopleWaiting = numero di persone davanti all'user
			$PeopleWaiting = $result->fetch_array(MYSQLI_ASSOC);
			//echo("Persone davanti:".$PeopleWaiting['Totale']."<br>");

			$query = "SELECT ticket.id_centro_ext FROM ticket WHERE ticket.id=".$ticket_id;
			$result= $db->query($query);
			// Id del centro
			$id_centro = $result->fetch_array(MYSQLI_ASSOC);

			$query = "SELECT AVG(MINUTE(TIMEDIFF(ticket.OraFine,ticket.OraChiamata))) as ServingTime
 				      FROM ticket WHERE id_operazione_ext =".$idOperazione." and ticket.Id_centro_ext=".$id_centro['id_centro_ext']." AND(ticket.OraChiamata<>'00:00:00')";
		    $result= $db->query($query);
			// Tempo medio di servizio
			$ServingTime = $result->fetch_array(MYSQLI_ASSOC);
			//echo("Tempo medio servizio:".$ServingTime['ServingTime']."<br>");

			// Numero di sportelli attivi per quell'operazione
			$query = "SELECT COUNT(sportelli.Id) as NumeroSportelli
					  FROM sportelli
					  WHERE sportelli.Id_Centro_ext =".$id_centro['id_centro_ext']." AND sportelli.Id_operazione_ext=".$idOperazione;
			$result= $db->query($query);
			$N = $result->fetch_array(MYSQLI_ASSOC);
			//echo("Numero Sportelli:".$N['NumeroSportelli']."<br>");

			$waitingTime = ($ServingTime['ServingTime'] * $PeopleWaiting['Totale'])/ $N['NumeroSportelli'];
			//echo("tempo di attesa:".$waitingTime);
			echo("nuova stima".$waitingTime);
			$gcm = new GCM();
			$reg_ids = array($regid);
					//echo($reg_ids);
			$message = array( 'updateTime' => "Tempo aggiornato",'waitingTime' =>$waitingTime);
			$gcm->send_notification($reg_ids,$message);
			
	
}

?>
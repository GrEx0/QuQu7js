<?php
		require_once(realpath('../operations.php'));	
		
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
		    
			$query="SELECT sportelli.Id_ticketCurr_ext FROM sportelli WHERE sportelli.Id=$idSportello";
			$result = $db->query($query);
			$record = $result->fetch_array(MYSQLI_ASSOC);
			
			//se lo sportello stava servendo 
			
			if($record['Id_ticketCurr_ext']!=NULL){
				
				$record = $result->fetch_array(MYSQLI_ASSOC);
				$idServito = $record['Id_ticketCurr_ext'];
	     		$query="UPDATE ticket SET ticket.OraFine='$ora' WHERE ticket.Id=$idServito";
				$result= $db->query($query);
			}
			
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

?>
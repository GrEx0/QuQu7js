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
					$query = "SELECT operazioni.Descrizione FROM operazioni,sportelli	 WHERE sportelli.id_operazione_ext=operazioni.Id AND sportelli.Id=$idSportello";
					$result = $db->query($query);
					$record = $result->fetch_array(MYSQLI_ASSOC);
					printf($record['Descrizione']);
					
			}
			db_disconnect($db);
			break;
			
			//funzione displaya cliente attuale	
			case 'getCliente':
			
			$db = db_connect();
		
			if ($db){
			$query = "SELECT operazioni.CodiceLettera,ticket.Numero FROM ticket,operazioni,sportelli 
					  WHERE ticket.Id_operazione_ext=operazioni.Id AND sportelli.Id=$idSportello AND sportelli.Id_ticketCurr_ext=ticket.Id";
			$result = $db->query($query);
			while ($record = $result->fetch_array(MYSQLI_ASSOC)) {
				printf("<li><a>%s %s</a></li>",$record['CodiceLettera'],$record['Numero']);
			}
		}
			break;
			
			
			//funzione prendi le operazioni da mettere nella combobox
		
		case 'getOperazioni':
		
		$db = db_connect();
		
		if ($db){
		
			$query="SELECT operazioni.Id,operazioni.Descrizione FROM operazioni WHERE 1";
			
			$result=$db->query($query); 
			
			
			while ($row = mysqli_fetch_assoc($result)) {
						$record= $row;
			}
			// codifica dei risultati
            echo json_encode($record);
			
			
		} else{ echo('connessione fallita');}
		
		break;
		
		
		
		//cambia l'operazione
		
		case 'changeOperazione':
			
			
			$db = db_connect();
		
		if ($db){
		
		$newOper=$_GET['NuovaOperazione'];
			
			$query="UPDATE sportelli SET sportelli.Id_operazione_ext=$newOper WHERE sportelli.Id=$idSportello AND Id_Centro_ext=$idCentro";
			
			$result = $db->query($query);
			
			
		} else{ echo('connessione fallita');}
			
			
			
			break;
			
			//chiama il prossimo numero
			
		case 'avantiNumero':
			$ora = date('H:i:s')
			$data = date('d/m/y');
			
			$db = db_connect();
			
			if ($db){
		
		    //controllo se lo sportello non sta servendo 
		    
			$query="SELECT sportelli.ClienteAttuale FROM sportelli WHERE sportelli.Id=$idSportello";
			
			$result = $db->query($query);
			
			//se lo sportello stava servendo 
			
			if($result!='NULL'){
	     			$query="UPDATE ticket SET ticket.OraFine=$ora 
			                            WHERE ticket.Id IN (SELECT MIN(ticket.Id) 
			                            FROM `ticket` WHERE ticket.OraFine='00:00:00') ";
			
			$result= $db->query($query);
			}
			
			//controllo se ci sono prossimi numeri da chiamare
			
			$query= "SELECT MIN(ticket.Id) 
			                             FROM ticket,sportelli 
			                             WHERE ticket.Id_operazione_ext=sportelli.Id_operazione_ext 
			                                   AND ticket.Id_centro_ext=sportelli.Id_centro_ext 
			                                   AND sportelli.Id=$idSportello 
			                                   AND ticket.Id_centro_ext=$idCentro 
			                                   AND ticket.OraChiamata='00:00:00'";
			                                   
			$prossimo=$db->query($query);
			
			
			//chiama il prossimo numero 
			
			if(mysqli_num_rows($prossimo) != 0){
			
			$query="UPDATE ticket SET ticket.OraChiamata=$ora 
			         WHERE ticket.Id IN (SELECT MIN(ticket.Id) 
			                             FROM ticket,sportelli 
			                             WHERE ticket.Id_operazione_ext=sportelli.Id_operazione_ext 
			                                   AND ticket.Id_centro_ext=sportelli.Id_centro_ext 
			                                   AND sportelli.Id=$idSportello 
			                                   AND ticket.Id_centro_ext=$idCentro 
			                                   AND ticket.OraChiamata='00:00:00')";
			
			$result3 = $db->query($query);
			
			$query="UPDATE sportelli SET sportelli.ClienteAttuale=$prossimo
			         WHERE sportelli.Id=$idSportello";
			
			$result4 = $db->query($query);
			
			}else{echo ('nessun numero da servire');}
			
			
		} else{ echo('connessione fallita');}
		
			
			break;
		
		
		
 }
 
 }

?>
<?php
		
		require_once(realpath('../operations.php'));	
		
		//dichiarazione invariabili
		$idCentro=8;
		$idSportello=1;
<<<<<<< HEAD
	
=======

>>>>>>> 5cbdeddac47db5b5dff59f946ba374efbb69029a
 if (isset($_GET['operation'])){
 	
	switch ($_GET['operation']) {
		
		
		//funzione displaya numero sportello FUNZIONA
		
		case 'getNumber':
<<<<<<< HEAD
			
			$db = db_connect();
		
		if ($db){
			printf("<li> %s </li>",$idSportello);
			
		}
		break;
=======
			printf($idSportello);
			break;
>>>>>>> 5cbdeddac47db5b5dff59f946ba374efbb69029a
			
			
		//funzione displaya operazione FUNZIONA
			case 'getOper':
			
			$db = db_connect();
		
			if ($db){
<<<<<<< HEAD
			$query = "SELECT operazioni.Descrizione FROM operazioni,sportelli WHERE sportelli.id_operazione_ext=operazioni.Id AND sportelli.Id=$idSportello";
			$result = $db->query($query);
			while ($record = $result->fetch_array(MYSQLI_ASSOC)) {
				printf("<li><a>%s</a></li>",$record['Descrizione']);
			}
		}
		break;
=======
					$query = "SELECT operazioni.Descrizione FROM operazioni,sportelli	 WHERE sportelli.id_operazione_ext=operazioni.Id AND sportelli.Id=$idSportello";
					$result = $db->query($query);
					$record = $result->fetch_array(MYSQLI_ASSOC);
					printf($record['Descrizione']);
					
			}
			db_disconnect($db);
			break;
>>>>>>> 5cbdeddac47db5b5dff59f946ba374efbb69029a
			
			
		//funzione displaya cliente attuale	FUNZIONA
			case 'getCliente':
			
			$db = db_connect();
		
			if ($db){
<<<<<<< HEAD
			$query = "SELECT operazioni.CodiceLettera,ticket.Numero 
			          FROM ticket,operazioni,sportelli 
			          WHERE ticket.Id_operazione_ext=operazioni.Id 
			                AND sportelli.Id=$idSportello 
			                AND sportelli.Id_ticketCurr_ext=ticket.Id";
=======
			$query = "SELECT operazioni.CodiceLettera,ticket.Numero FROM ticket,operazioni,sportelli 
					  WHERE ticket.Id_operazione_ext=operazioni.Id AND sportelli.Id=$idSportello AND sportelli.Id_ticketCurr_ext=ticket.Id";
>>>>>>> 5cbdeddac47db5b5dff59f946ba374efbb69029a
			$result = $db->query($query);
			while ($record = $result->fetch_array(MYSQLI_ASSOC)) {
				printf("<li><a>%s %s</a></li>",$record['CodiceLettera'],$record['Numero']);
			}
		}
		break;
			
			
		//funzione prendi le operazioni da mettere nella combobox FUNZIONA MA VA MIGLIORATA LA QUERY
		    case 'getOperazioni':
		
			$db = db_connect();
		
			if ($db){
		
			$query="SELECT operazioni.Id,operazioni.Descrizione FROM operazioni WHERE 1";
			$result=$db->query($query); 
			
			while ($row = mysqli_fetch_assoc($result)) {
<<<<<<< HEAD
            $record[] = $row;
            }
			      
=======
						$record= $row;
			}
			// codifica dei risultati
>>>>>>> 5cbdeddac47db5b5dff59f946ba374efbb69029a
            echo json_encode($record);
			
			
		} else{ echo('connessione fallita');}
		
		break;
		
		
		
		//cambia l'operazione FUNZIONA
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
<<<<<<< HEAD
		
		    $a=time();
			$ora=date('G:i:s,$a');
			$data=date('d/M/y,$a');
=======
			$ora = date('H:i:s')
			$data = date('d/m/y');
			
>>>>>>> 5cbdeddac47db5b5dff59f946ba374efbb69029a
			$db = db_connect();
			if ($db){
		
		    //controllo se lo sportello non sta servendo 
		    
<<<<<<< HEAD
			$query="SELECT sportelli.Id_ticketCurr_ext FROM sportelli WHERE sportelli.Id=$idSportello";
=======
			$query="SELECT sportelli.ClienteAttuale FROM sportelli WHERE sportelli.Id=$idSportello";
			
>>>>>>> 5cbdeddac47db5b5dff59f946ba374efbb69029a
			$result = $db->query($query);
			
            //se lo sportello stava servendo bisogna anche chiudere il turno prima 
			
<<<<<<< HEAD
					while ($row = mysqli_fetch_assoc($result)) {
                    $record[] = $row;
}
          
			            //se non è vero che il ticket_curr==null , allora il ticket_curr è non null , allora lo sportello era già attivo
			if(is_null($record['Id_ticketCurr_ext'])==FALSE){ 
				echo("sportello precedentemente attivo");
/*questa query funziona*/$query="UPDATE ticket 
	     			             SET ticket.OraFine=$ora 
	     			             WHERE ticket.Id IN (SELECT ticket.Id 
	     			                            FROM sportelli 
	     			                            WHERE sportelli.Id=$idSportello 
	     			                            	  AND sportelli.Id_ticketCurr_ext=ticket.Id 
	     			                            	  AND ticket.OraFine='00:00:00' 
	     			                            	  AND ticket.Orachiamata!='00:00:00') ";
			
			$result = $db->query($query);
			}else{echo("sportello da avviare all'attività");}
=======
			if($result!='NULL'){
	     			$query="UPDATE ticket SET ticket.OraFine=$ora 
			                            WHERE ticket.Id IN (SELECT MIN(ticket.Id) 
			                            FROM `ticket` WHERE ticket.OraFine='00:00:00') ";
			
			$result= $db->query($query);
			}
>>>>>>> 5cbdeddac47db5b5dff59f946ba374efbb69029a
			
			//controllo se ci sono prossimi numeri da chiamare
			
			                 //seleziona il ticket che è stato emesso prima per una certa operazione
/*questa query funziona*/$query= "SELECT MIN(ticket.Id) 
			                             FROM ticket,sportelli 
			                             WHERE ticket.Id_operazione_ext=sportelli.Id_operazione_ext 
			                                   AND ticket.Id_centro_ext=sportelli.Id_Centro_ext 
			                                   AND sportelli.Id=$idSportello 
			                                   AND ticket.Id_centro_ext=$idCentro 
			                                   AND ticket.OraChiamata='00:00:00'";
			                                   
			$prossimo=$db->query($query);
			

			//chiama il prossimo numero se c'è
			
			if(mysqli_num_rows($prossimo) != 0){
								
			echo ("avanti il prossimo");
			
			    //aggiorna l'ora di chiamata del ticket
/*questa query non funziona*/			$query="UPDATE ticket SET ticket.OraChiamata=$ora 
			               WHERE ticket.Id IN (SELECT MIN(ticket.Id) 
			                             FROM ticket,sportelli 
			                             WHERE ticket.Id_operazione_ext=sportelli.Id_operazione_ext 
			                                   AND ticket.Id_centro_ext=sportelli.Id_Centro_ext 
			                                   AND sportelli.Id=$idSportello 
			                                   AND ticket.Id_centro_ext=$idCentro 
			                                   AND ticket.OraChiamata='00:00:00')";
			
			$result = $db->query($query);
			
			$prossimo= mysqli_fetch_assoc($prossimo);
	
			$prossimo=$prossimo['MIN(ticket.Id)'];
		
			
			  //aggiorna l'occupazione dello sportello
/*questa query funziona*/$query="UPDATE sportelli SET sportelli.Id_ticketCurr_ext=$prossimo
			                     WHERE sportelli.Id=$idSportello";
			
			$result= $db->query($query);
			
			
			
			}else{echo ('nessun numero da servire');}
			
			
		} else{ echo('connessione fallita');}
		
			
			break;
		
		
		
 }
 
 }

?>
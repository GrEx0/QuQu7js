<?php
		
		require_once(realpath('../operations.php'));	
		
		//dichiarazione invariabili
		$idCentro=8;
		$idSportello=1;
		
		
		
		
 if (isset($_GET['operation'])){
 	
	switch ($_GET['operation']) {
		
		
		//funzione displaya numero sportello
		
		case 'getNumber':
			
			$db = db_connect();
		
		if ($db){
			
			
			printf("<li> %s </li>",$idSportello);
			
		}
			break;
			
			
		//funzione displaya operazione	
			case 'getOper':
			
			$db = db_connect();
		
			if ($db){
			$query = "SELECT operazioni.Descrizione FROM operazioni,sportelli	 WHERE sportelli.id_operazione_ext=operazioni.Id AND sportelli.Id=$idSportello";
			$result = $db->query($query);
			while ($record = $result->fetch_array(MYSQLI_ASSOC)) {
				printf("<li><a>%s</a></li>",$record['Descrizione']);
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
    $record[] = $row;
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
		
		    $a=time();
			$ora=date('G i s,$a');
			$data=date('d M y,$a');
			
			if ($db){
		
		
			
			$query1="UPDATE ticket SET ticket.OraFine=$ora WHERE ticket.Id IN (SELECT MIN(ticket.Id) FROM `ticket` WHERE ticket.OraFine='00:00:00') ";
			
			$result1 = $db->query($query1);
			
			$query2="SELECT MIN(ticket.Id) FROM ticket,sportelli WHERE ticket.Id_operazione_ext=sportelli.Id_operazione_ext AND ticket.OraChiamata='00:00:00' AND sportelli.Id='1' AND ticket.Id_centro_ext=sportelli.Id_centro_ext";
			
			$result2 = $db->query($query2);
			
			
		} else{ echo('connessione fallita');}
			
			
			
			
			
			break;
		
		
		
 }
 
 }

?>
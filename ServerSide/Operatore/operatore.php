<?php
		
		require_once(realpath('../operations.php'));	
		
		//dichiarazione invariabili
		$idCentro=8;
		$idSportello=1;
		$foo="bella";
		
		
		
 if (isset($_GET['operation'])){
 	
	switch ($_GET['operation']) {
		
		
		//funzione displaya 
		
		case 'getNumber':
			
			$db = db_connect();
		
		if ($db){
			
			
			printf("<li> %s </li>",$idSportello);
			
		}
			break;
			
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
		
		
		case 'changeOperazione':
			
			break;
			
		case 'avantiNumero':
			
			break;
		
		
		
 }
 
 }

?>
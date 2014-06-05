<?php
		
		require_once '../operations.php';
		$db = db_connect();
		
		if ($db){
			
			$result = array();
			$query = "SELECT operazioni.Descrizione FROM operazioni";
			$result= query($query);
			
			
			
			
			// codifica dei risultati
            echo json_encode($result);
			
			
		}

?>
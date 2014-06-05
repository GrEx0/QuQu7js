<?php
		
		require_once '../operations.php';
		$db = db_connect();
		
		if ($db){
			$query = "SELECT operazioni.Descrizione FROM operazioni";
			$result = $db->query($query);
			$record = $result->fetch_all(MYSQLI_ASSOC);
			// codifica dei risultati
            echo json_encode($record);
			
			
		}

?>
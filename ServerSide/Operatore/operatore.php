<?php
		
		
		
		require_once 'operations.php';
		
		
		
		$db = db_connect();
		
		if ($db){
			
			echo("figa");
			
			$query = "SELECT operazioni.Descrizione FROM operazioni";
			$result= $db->query($query);
			$record=$result->fetch_all(MYSQLI_ASSOC);
			
			echo("figa");
			
			
			// codifica dei risultati
            echo json_encode($record);
			
			
		}

?>
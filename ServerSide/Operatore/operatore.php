<?php
		//echo('se vedi  questo echo e non gli altri non carica require');
		//echo(realpath('../operations.php'));
		require_once(realpath('../operations.php'));	
		$db = db_connect();
		echo('ho fatto db_connect');
		if ($db){
			echo('sono dentro if');
			$operations = showOperations($db);
			// codifica dei risultati
            echo json_encode($operations);
			echo('end if \n');
			
		} else{ echo('ha saltato if');}

?>
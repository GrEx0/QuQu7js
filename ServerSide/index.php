<?php

	if (isset($_GET["id"]) && isset($_GET['regid']))
	{
		require_once 'operations.php';
		require_once 'GCM.php';
			
			$db = db_connect();
				
			if ($db){
					 	$answer = CheckUser($_GET['id'],$db);
					 	if ($answer){
					 				InsertUser($_GET["id"],$_GET["regid"],$db);
									echo(json_encode($answer));
									$gcm = new GCM();
									$gcm->send_notification($_GET["regid"], "Notifica push - Utente inserito nel server");
					 			 	}
				    } 	
					else { echo("errore");}
				
		db_disconnect($db);
	}
	else {die("ID non definito");}


 ?> 
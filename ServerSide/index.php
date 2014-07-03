<?php

	if (isset($_GET["id"]) && isset($_GET['regid']))
	{
		require_once 'operations.php';
		require_once 'GCM.php';
			
			$db = db_connect();
				
			if ($db){
					 	$answer = CheckUser($_GET['id'],$db);
					 	if ($answer){
					 				InsertUser($_GET["id"],$_GET["regid"],$db);				// Inserisco l'utente in utenti attivi
									echo(json_encode($answer));
									$gcm = new GCM();
									$reg_ids = array($_GET["regid"]);
									$message = array( 'message' => "Utente inserito nel server",'soundname'=>'beep.wav');
									$gcm->send_notification($reg_ids,$message);
					 			 	}
				    } 	
					else { echo("errore");}
				
		db_disconnect($db);
	}
	else {die("ID non definito");}


 ?> 
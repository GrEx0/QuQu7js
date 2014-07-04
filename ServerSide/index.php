<?php
	
	if (isset($_GET["id"]) && isset($_GET['regid']))			// Verifico che sono settati i parametri 
	{
		require_once 'operations.php';
		require_once 'GCM.php';
			
			$db = db_connect();

// Se c'è la connessione al db entra
			if ($db){								
					 	$answer = CheckUser($_GET['id'],$_GET["regid"],$db);				// verifico esistenza del ticket
					 	if ($answer){
					 				InsertUser($_GET["id"],$_GET["regid"],$db);				// Inserisco l'utente in utenti attivi
									echo(json_encode($answer));
									$gcm = new GCM();										// Mando la notifica al cellulare
									$reg_ids = array($_GET["regid"]);
									$message = array( 'message' => "Utente inserito nel server");
									$gcm->send_notification($reg_ids,$message);
					 			 	}
				    } 	
					else { echo("errore");}
				
		db_disconnect($db);
	}
	else {die("ID non definito");}


 ?> 
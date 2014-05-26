<?php

	if (isset($_GET["id"]))
	{
			// connessione a MySQL con l'estensione MySQLi
				$mysqli = new mysqli("localhost", "root", "", "QuQu7DB");

			// verifica dell'avvenuta connessione
				if (mysqli_connect_errno()) 
				{
					// notifica in caso di errore
						echo nl2br("Errore in connessione al DBMS: ".mysqli_connect_error());
					// interruzione delle esecuzioni i caso di errore
						exit();
 
				}
				
				else 
				{
						// notifica in caso di connessione attiva
						echo nl2br("Connessione avvenuta con successo \n");
		
						$query = "SELECT * FROM Ticket WHERE id=". $_GET["id"];
						echo nl2br("Query = ". $query . "\n");
						$result = $mysqli->query($query);
						if ($result->num_rows >0) 
						{
							$record = $result->fetch_array(MYSQLI_ASSOC);
							echo nl2br("Ticket Emesso, Utente attivato \n");
							echo nl2br("Ora emissione:".$record['OraEmissione']."\n");
						
						$query = "SELECT * FROM UtentiAttivi WHERE id_ticket_ext=". $_GET["id"];
						$result = $mysqli->query($query);
						if ($result->num_rows>0) {die("Utente gia attivo <br>");}
						
							// Inserisco il record trovato nella tabella dinamica UtentiAttivi
						$query = "INSERT INTO UtentiAttivi VALUES ('','".$_GET['DeviceToken']."','".$_GET['Posizione']."','".$_GET['id']."')";
						echo nl2br($query."\n");
						
						$result = $mysqli->query($query);
						if ($result) 
						{
								echo nl2br("Insert avvenuta con successo \n");
						} else echo("ERRORE INSERT");
						} 
						else { echo("Ticket non trovato");}
				}
				$mysqli->close();
	}
		 else {die("ID non definito");}


 ?> 
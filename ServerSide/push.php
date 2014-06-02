<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

/**
 * Constructs the SSE data format and flushes that data to the client.
 *
 * @param string $waitingTime is the time the client has to wait
 */
function sendMsg($waitingTime) {
  echo "waitingTime: $waitingTime" . PHP_EOL;
  echo PHP_EOL;
  ob_flush();
  flush();
}

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
					$query = "SELECT * FROM Ticket WHERE id=". $_GET["id"];
					echo nl2br("Query = ". $query . "\n");
				}


sendMsg();


 ?>
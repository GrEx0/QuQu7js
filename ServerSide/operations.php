<?php
require_once 'config.php';
require_once 'GCM.php';

function db_connect(){
				// connessione a MySQL con l'estensione MySQLi
				$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
			// verifica dell'avvenuta connessione
				if (mysqli_connect_errno()) 
				{
					// notifica in caso di errore
						echo nl2br("Errore in connessione al DBMS: ".mysqli_connect_error());
					// interruzione delle esecuzioni i caso di errore
						exit();
 
				}
				else 
				{return $mysqli;}
}

function db_disconnect($db){
	$db->close();
}

// CheckUser: Verifica che l'id ricevuto sia un ticket effettivamente emesso 

function CheckUser($id,$regid,$db){
	
	$query = "SELECT ticket.Id,ticket.Data,ticket.Numero,operazioni.CodiceLettera,operazioni.Id as id_operazione,centri.Nome, CONCAT( centri.Via,'+',centri.Citta) as centerPosition 
			  FROM ticket,operazioni,centri
			  WHERE ticket.id=".$id." AND ticket.Id_operazione_ext=operazioni.Id ";
	$result = $db->query($query);
	
	// se il ticket esiste nella tabella ticket
	if ($result->num_rows >0) 
						{
							$record = $result->fetch_array(MYSQLI_ASSOC);
						//	echo nl2br(json_encode($record)."\n");
							$query = "SELECT * FROM utentiattivi WHERE id_Ticket_ext=". $id;
							$result = $db->query($query);
						
						// verifico che non sia già attivo in utenti attivi, se è attivo mando una notifica push	
						if ($result->num_rows>0) {
							
							$gcm = new GCM();
							$reg_ids = array($regid);
							//echo($reg_ids);
							$message = array( 'message' => "Ticket già attivo");
							$gcm->send_notification($reg_ids,$message);
							return false;
						} 
						// Se invece il numero del ticket è diverso ( l'utente sta acquisendo un altro ticket senza aver terminato
						// il primo ticket)
						// Cancello il vecchio ticket e metto quello nuovo
							else {
								$query = "SELECT * FROM utentiattivi WHERE regid='".$regid."'";
								$result = $db->query($query);
								if ($result->num_rows>0) {
									
									$row = mysqli_fetch_assoc($result);
									$query = "DELETE FROM utentiattivi WHERE Id_Ticket_ext=".$row['Id_Ticket_ext'];
									$result= $db->query($query);
									
								}
								return $record;
							}	
						}

}

function InsertUser($id,$regid,$db){
		// Inserisco il record trovato nella tabella dinamica UtentiAttivi
		$query = "INSERT INTO utentiattivi (regid,Id_Ticket_ext) VALUES ('".$regid."','".$id."')";
		$result = $db->query($query);
		return $result;

}


?>
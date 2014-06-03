<?php
require_once 'config.php';

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

function CheckUser($id,$db){
	
	$query = "SELECT Ticket.id,Ticket.Data,Ticket.Numero,Operazioni.CodiceLettera,Operazioni.Id as id_operazione,centri.Nome, CONCAT( centri.Via,'+',citta.Nome) as centerPosition 
			  FROM Ticket,Operazioni,Centri,Citta
			  WHERE Ticket.id=".$id." AND ticket.Id_operazione_ext=Operazioni.id AND Ticket.Id_centro_ext = Centri.Id ";
	$result = $db->query($query);
	if ($result->num_rows >0) 
						{
							$record = $result->fetch_array(MYSQLI_ASSOC);
						//	echo nl2br(json_encode($record)."\n");
							$query = "SELECT * FROM UtentiAttivi WHERE id_ticket_ext=". $id;
							$result = $db->query($query);
						if ($result->num_rows>0) {return false;} else {return $record;}
						}

}

function InsertUser($id,$regid,$db){
		// Inserisco il record trovato nella tabella dinamica UtentiAttivi
		$query = "INSERT INTO UtentiAttivi (regid,Id_Ticket_ext) VALUES ('".$regid."','".$id."')";
		$result = $db->query($query);
		return $result;

}


?>
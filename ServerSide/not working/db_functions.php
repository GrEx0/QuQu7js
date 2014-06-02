<?php

class DB_functions {
	
	private $db;
	
	function __costruct(){
		include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
	}
	public function CheckTicket($id){
		$this->private->connect();	
				                // CheckTicket returns TRUE if User ticket exists in
		$query = "SELECT * FROM Ticket WHERE id=". $id;					// ticket and not in Utenti attivi, otherwise it returns FALSE
		$result = mysqli_query($query);
		$answer = false;
		if ($result->num_rows >0) 
						{
							$record = $result->fetch_array(MYSQLI_ASSOC);
							echo nl2br("Ticket Emesso \n");
							echo nl2br("Ora emissione:".$record['OraEmissione']."\n");
							echo nl2br(json_encode($record)."\n");
							
						// Check if User already exist in UtentiAttivi	
							$query = "SELECT * FROM UtentiAttivi WHERE id_ticket_ext=". $id;
							$result = $db->query($query);
							if ($result->num_rows>0) {
									echo("Utente gia attivo <br>");
							} 
							else {$answer =  true;}
							
						} 
						else {
							 echo("Ticket non trovato");
							}
						return $answer; 
	}
	
	public function InsertUser($id,$regid){
			$answer = false;
			// Inserisco il record trovato nella tabella dinamica UtentiAttivi
			$query = "INSERT INTO UtentiAttivi (regid,Id_Ticket_ext) VALUES ('".$regid."','".$id."')";
			//echo nl2br($query."\n");
			$result = $db->query($query);
			if ($result) 
						{
								echo nl2br("Insert avvenuta con successo,Utente Attivo \n");
								$answer = true;
						} 
						else {
								echo("ERRORE INSERT");
							 }
						return $answer;
	}
	
}

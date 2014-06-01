<?php

class DB_Connect{
	    // constructor
    function __construct() {
  
    }
  
    // destructor
    function __destruct() {
        // $this->close();
    }

	public function connect() {
        require_once 'config.php';
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
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
					return &$conn;
				}
	}
	public function close() {
		mysqli_close();
	}

	
}
?>
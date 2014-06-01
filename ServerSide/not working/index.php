<?php

	if ( isset($_GET["id"]) && isset($_GET['regid']) )
	{
	  require_once("db_functions.php");
	  $db = new DB_functions();
		if ($db ->CheckTicket($_GET["id"])) {
			
			$db ->InsertUser( $_GET["id"] , $_GET["regid"] );
			
		}
				
	} else {echo("Not Allowed");}


 ?> 
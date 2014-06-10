<?php

	if (isset($_GET["id"]) && isset($_GET["id_operazione"]))
	{	
		$id_operazione = $_GET["id_operazione"];
		$id = $_GET["id"];
		require_once 'operations.php';
		$db = db_connect();
		if ($db){

			// GUARDO GUANTE PERSONE SONO DAVANTI ALL'UTENTE
			$query = "SELECT ticket.Numero,ticket.Data FROM ticket WHERE ticket.id=".$id;
			$result= $db->query($query);
			$LuckyNumber = $result->fetch_array(MYSQLI_ASSOC);
			$query = "SELECT COUNT(ticket.id) as Totale FROM ticket WHERE Orafine ='00:00:00' AND ticket.Data='".$LuckyNumber['Data']."' and ticket.Numero<".$LuckyNumber['Numero']." and Id_operazione_ext =".$id_operazione;
			$result= $db->query($query);
			// PeopleWaiting = numero di persone davanti all'user
			$PeopleWaiting = $result->fetch_array(MYSQLI_ASSOC);
			//echo("Persone davanti:".$PeopleWaiting['Totale']."<br>");

			$query = "SELECT Ticket.id_centro_ext FROM ticket WHERE ticket.id=".$id;
			$result= $db->query($query);
			// Id del centro
			$id_centro = $result->fetch_array(MYSQLI_ASSOC);

			$query = "SELECT AVG(MINUTE(TIMEDIFF(ticket.OraFine,ticket.OraChiamata))) as ServingTime
 				      FROM ticket WHERE id_operazione_ext =".$id_operazione." and ticket.Id_centro_ext=".$id_centro['id_centro_ext']." AND(ticket.OraChiamata<>'00:00:00')";
		    $result= $db->query($query);
			// Tempo medio di servizio
			$ServingTime = $result->fetch_array(MYSQLI_ASSOC);
			//echo("Tempo medio servizio:".$ServingTime['ServingTime']."<br>");

			// Numero di sportelli attivi per quell'operazione
			$query = "SELECT COUNT(sportelli.Id) as NumeroSportelli
					  FROM Sportelli
					  WHERE sportelli.Id_Centro_ext =".$id_centro['id_centro_ext']." AND sportelli.Id_operazione_ext=".$id_operazione;
			$result= $db->query($query);
			$N = $result->fetch_array(MYSQLI_ASSOC);
			//echo("Numero Sportelli:".$N['NumeroSportelli']."<br>");

			$waitingTime = ($ServingTime['ServingTime'] * $PeopleWaiting['Totale'])/ $N['NumeroSportelli'];
			//echo("tempo di attesa:".$waitingTime);
			$answer = array('waitingTime'=>$waitingTime);
			echo(json_encode($answer));
		
		db_disconnect($db);

		}
	}
?>
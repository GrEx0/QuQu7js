<?php
require_once '../operations.php';
$idCentro=8;
 if (isset($_GET['operation'])){

 	switch ($_GET['operation']) {
 		
		case 'showOperations':
			$db = db_connect();
		
		if ($db){
			$query = "SELECT operazioni.id,operazioni.CodiceLettera,operazioni.Descrizione 
					  FROM operazioni,sportelli
					  WHERE sportelli.Id_Centro_ext=".$idCentro." and sportelli.Id_operazione_ext = operazioni.Id 
					  GROUP BY CodiceLettera";
			$result = $db->query($query);
			while ($record = $result->fetch_array(MYSQLI_ASSOC)) {
				printf("<li><a href='centerOperations.php?&operation=printTicket&id_operation=%s&CodiceLettera=%s'>%s</a></li>",$record['id'],$record['CodiceLettera'],$record['CodiceLettera']." - ".$record['Descrizione']);
			}
		}
			break;
		
		case 'printTicket':
			$db = db_connect();
			$id_op = $_GET['id_operation'];
			$Lettera = $_GET['CodiceLettera'];
			$query = "SELECT ticket.Numero  FROM ticket
					  WHERE ticket.id_operazione_ext =".$id_op." AND ticket.Numero =(select max(ticket.Numero) FROM ticket)";
			$result = $db->query($query);
			$MaxNum = $result->fetch_array(MYSQLI_ASSOC);
			$currNum = $MaxNum['Numero']+1;
			$query = "INSERT INTO Ticket (Numero,OraEmissione,Data,Id_centro_ext,Id_operazione_ext) VALUES ('".$currNum."','".date('H:i:s')."','".date('d/m/y')."','".$idCentro."','".$id_op."')";
			//echo($query);
			$result = $db->query($query);
			if ($result) {
					echo("<table>");
					printf("<tr><td>Numero ticket: %s %s</td></tr>",$Lettera,$currNum);
					printf("<tr><td><img src='%s' alt='QRCode' height='150' width='150'></td></tr>","http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=http://localhost/index.php?&id=".$currNum);
					echo("</table>");
					} else echo("errore insert");
			
			
			break;
		default: echo('operazione non supportata');	
	}
}
?>
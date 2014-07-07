L'app è strutturata secondo questa organizzazione:

 ->config.xml : contiene tutte le librerie phonegap necessarie per utilizzare funzionalità "native" dello smartphone.

 -> js: contiene tutti gli script utilizzati (ha le sottocartelle inerenti al Model View e Controller).
			 il file main.js è quello che viene richiamato dall'index.html (è il Controller).

 ->img: contiene le immagini utilizzate.
 
 ->css: contiene gli stili per la grafica ( in questo caso è stato usato uno style preimpostato -> Ratchet)
 
 ->Templates: Contiene il markup delle diverse views. i templates sono degli "scheletri" con dei parametri che vengono
 			  cambiati in fase di render.
			 
 -> ServerSide: Contiene tutti gli script PHP lato Server.
 	
 	-> Operatore: contiene le pagine inerenti l'operatore.
 	-> TicketKiosk: contiene le pagine inerenti il dispenser.
 	
 	->index.php: è il primo script che viene chiamato, restituisce i valori del ticket allo smartphone e inserisce
 				 l'utente in <utentiattivi>
 				 
 	->GCM.php: classe php per mandare le notifiche push.
 	
 	->operations.php: script php contenente le funzioni di connessione al db e altre funzionalità di supporto.
			 

Per separare il markup dei diversi templates delle view, usiamo require.js per caricare il template html da files esterni.

Per la grafica usiamo Ratchet (www.goratchet.com).

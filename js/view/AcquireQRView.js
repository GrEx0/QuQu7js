AcquireQR_View = Backbone.View.extend({
        initialize: function(){
            this.template = _.template( tpl.get('AcquireQR') );
            console.log("AcquireQR.html template caricato");
        },
        render: function(){
            this.$el.html( this.template() );
            return this.el;
        },
        events: {
        	"click #startScan" : "doScan"				// aggiungo un event listener sull'evento click 
    	},
 
 		doScan: function() 
 		{
    
    /* ------ PARTE DI ACQUISIZIONE QR-CODE, DISABILITATA IN DEBUG E TESTING DA PC  ----- */
    
         	console.log('scanning');
         	promise = this.longFirst().then(this.shortSecond);    // Utilizzo dell'oggetto deferred per garantire la sequenzialità
   
     /* ------  FINE FUNZIONE X ACQUISIZIONE QR-CODE               ----- */
			console.log('Bottone schiacciato');

	// ---- Parte abilitata solo in fase di emulazione da Ripple --------
	/*		 ticketLink = window.prompt("Inserisci link ticket");
			 console.log(ticketLink);*/
		
         },
 
 // longFirst: funzione "lunga" ( acquisizione del QR-Code da fotocamera)
        longFirst: function(){
        				window.d = new $.Deferred();
        		    	var scanner = cordova.require("cordova/plugin/BarcodeScanner");
						scanner.scan( function (result) 
        					{ 
								//alert("QRCode Rilevato\n" + "Result: " + result.text );  
            					console.log("Scanner result: \n" +"text: " + result.text);
            					window.ticketLink = result.text;
            					window.d.resolve();
            					$("#results").html(window.ticketLink); 
        					});
        				return window.d.promise();
        },
 //shortSecond: funzione "corta" da eseguire solo DOPO l'acquisizione del QR-CODE'
        shortSecond:function(){
        	 d = new $.Deferred();
        	window.link.set({link: window.ticketLink+"&regid="+window.regid});
        	//alert("Settato link");
        	d.resolve();
        	return d.promise();
        	
        }

    });

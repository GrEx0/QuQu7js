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
        	"click #startScan" : "doScan"
    	},
 
 		doScan: function() 
 		{
    
    /* ------ PARTE DI ACQUISIZIONE QR-CODE, DISABILITATA IN DEBUG E TESTING DA PC  ----- */
    
         	console.log('scanning');
        	var scanner = cordova.require("cordova/plugin/BarcodeScanner");
			scanner.scan( function (result) 
        		{ 
					alert("QRCode Rilevato\n" + "Result: " + result.text );  
            		console.log("Scanner result: \n" +"text: " + result.text);
            		$("#results").val(result.text);
        		});
        	
     
     /* ------  FINE FUNZIONE X ACQUISIZIONE QR-CODE               ----- */
			console.log('Bottone schiacciato');
			
	/*		 ticketLink = window.prompt("Inserisci link ticket");
			 console.log(ticketLink);
			$("#results").val(ticketLink); */
			window.link.set({link: $("#results").val()+"&regid="+window.regid});
         }
    });

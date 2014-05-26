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
    /* 
         	console.log('scanning');
        	var scanner = cordova.require("cordova/plugin/BarcodeScanner");
			scanner.scan( function (result) 
        		{ 
					alert("We got a barcode\n" + "Result: " + result.text );  
            		console.log("Scanner result: \n" +"text: " + result.text);
            		document.getElementById("results").innerHTML = result.text;
            		console.log(result);
        		});
        	
     */
     /* ------  FINE FUNZIONE X ACQUISIZIONE QR-CODE               ----- */
       console.log('Bottone schiacciato');
       $("#results").val("http://localhost/QuQu7js/ServerSide/index.php?id=1");
       this.model.set({link: $("#results").val()});
         }
    });

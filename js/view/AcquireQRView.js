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
 
 		doScan: function() {
        console.log('scanning');
        
        var scanner = cordova.require("cordova/plugin/BarcodeScanner");

        scanner.scan( function (result) { 

            alert("We got a barcode\n" + 
            "Result: " + result.text + "\n" + 
            "Format: " + result.format + "\n" + 
            "Cancelled: " + result.cancelled);  

           console.log("Scanner result: \n" +
                "text: " + result.text + "\n" +
                "format: " + result.format + "\n" +
                "cancelled: " + result.cancelled + "\n");
            document.getElementById("results").innerHTML = result.text;
            console.log(result);
    });

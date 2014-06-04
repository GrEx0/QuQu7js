Ticket = Backbone.Model.extend({
    defaults: {
        "id":"",
        "data":"",
        "center":"N/D",
        "centerPosition":"Piazza+Argentina+Milan",
        "ticketNumber":"N/D",
        "operation":"",
        "id_operazione_ext":"",
        "waitingTime":"N/D",
        "walkingTime":"N/D"
    },
	 initialize: function(){
      this.bind("change", this.attributesChanged);
    },
	 attributesChanged: function()
		{
				console.log(this.toJSON());
				if ((this.get('id_operazione_ext')!="") && (this.get('id')!="") && (this.get('waitingTime')=="N/D"))  // viene eseguito soltanto la prima volta che acquisisci il qrcod
				{   

					//stima attesa
					linkEstimate = window.url+"estimateWaiting.php?id="+this.get('id')+"&id_operazione="+this.get('id_operazione_ext');
					console.log("setto il nuovo link per la stima del tempo"+linkEstimate);
					$.getJSON(linkEstimate,function( data ){
							window.ticket.set({waitingTime:data.waitingTime});
					});


					//stima percorso
					window.ticket.routeCalc();



                    //aggiornamento stime				
					window.idtimer=setInterval(this.update,5000);

					}
					
					
					}

		},
		

		 update: function(){

		if (window.ticket.get('waitingTime') > 1) {
        	//update waiting time
				window.ticket.set({waitingTime:parseInt(window.ticket.get('waitingTime')-1)}); 
				window.ticket.routeCalc();
 
        		 } else {clearInterval(window.idtimer);
        		 	window.alert("non hai nessuno davanti coglione");}	        	

       },
       
       routeCalc: function(){
       	 	
       	 	//stima percorso

            navigator.geolocation.getCurrentPosition(

            function(position) {

	var mapurl="https://maps.googleapis.com/maps/api/directions/json?origin="+position.coords.latitude+","+position.coords.longitude
	+"&destination="+window.ticket.get('centerPosition')
    +"&mode=walking&sensor=false&key=AIzaSyC1U94HTYNNSUpJHot6_bBRIT-C0aGVE-Q";
    
    
			$.getJSON(mapurl,
			function(response){
            window.ticket.set({walkingTime:Math.round((response.routes[0].legs[0].duration.value)/60)});
            });
             }
             ,
           
           function() {alert('Error getting location');}
           
           ); //fine stima percorso
          }
        
});
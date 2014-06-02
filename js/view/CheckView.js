Check_View = Backbone.View.extend({
	
        initialize: function(){
            this.template = _.template( tpl.get('Check') );
             this.model.on("change", this.render);
            console.log("Check.html template caricato");
            
            
            
            
            //test geolocalizzazione
           /* navigator.geolocation.getCurrentPosition(
        	
            function(position) {
                $('.location', this.el).html(position.coords.latitude + ',' +position.coords.longitude);
                
            },
            function() {
                alert('Error getting location');
            });
            */
            //displaymappa


            
            
            
            //variabili
           
            
            //test calcolo distanza google distance matrix
            /*
            
             var service;
            var destination;
            service = new google.maps.DistanceMatrixService();
            destination= new google.maps.LatLng(43.5, -80.5);
            
            navigator.geolocation.getCurrentPosition(
            
            
         function (position){
        	
        	
        	service.getDistanceMatrix (
        		
        		{
        			//parametri : 
        			origins : [google.maps.LatLng(position.coords.latitude, position.coords.longitude)],
        			destinations : //get(this.model.centerPosition) ,
        			               [destination],
        			travelMode : google.maps.TravelMode.WALKING
        			
        			
        		},
        		    
        		    //callback :
        		    //this.model.walkingTime = response.rows[0].elements[0].distance.text
        		    
        		    //$('.est', this.el).html(response.rows[0].elements[0].distance.value)
        		    function(response,status){

                    if(status==google.maps.DistanceMatrixStatus.OK) {
   
                    $('.estimation', this.el).html(response.rows[0].elements[0].duration.value);
    
                    } else {
                    alert("Error: " + status);
                    }
        	
                    }
        		
        	);
        }

         
             ,
            
             function() {
                alert('Error getting location');
            }
            
            );
      
        },*/
       
          //test calcolo distanza google directions
            
            
            var service;
            var destination;
            service = new google.maps.DirectionsService();
            destination= new google.maps.LatLng('43.5', '-80.5');
            
            navigator.geolocation.getCurrentPosition(
            
            
         function (position){
         	
         	
        	
        	
        	service.route (
        		
        		{
        			//parametri : 
        			origins : google.maps.LatLng(position.coords.latitude, position.coords.longitude),
        			destinations : //get(this.model.centerPosition) ,
        			               destination,
        			travelMode : google.maps.TravelMode.WALKING
        			
        			
        		},
        		    
        		    //callback :
        		    
        		    function(response,status){
        		    	
        		    	alert('dentro');

                    if(status==google.maps.DirectionsStatus.OK) {
   
                    //$('.estimation', this.el).html(response.duration.value);
                    alert('we'+response);
    
                    } else {
                    alert("Error: " + status);
                    }
        	
                    }
        		
        	);
        }

         
             ,
            
             function() {
                alert('Error getting location');
            }
            
            );
      
        },
        
      //test di calcolo distanza mapquest
        
    
        render: function(){
            this.$el.html( this.template(this.model.toJSON()) );
            console.log("Rendering Check_view");
            return this.el;
            
           
        },
        
     
       
        
  
    });









       


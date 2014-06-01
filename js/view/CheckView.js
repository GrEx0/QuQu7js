Check_View = Backbone.View.extend({
	
        initialize: function(){
            this.template = _.template( tpl.get('Check') );
             this.model.on("change", this.render);
            console.log("Check.html template caricato");
            
         /*   navigator.geolocation.getCurrentPosition(estimateWalkingTime,function() {
                alert('Error getting location');
            		});*/    
        },
        
        render: function(){
            this.$el.html( this.template(this.model.toJSON()) );
            console.log("Rendering Check_view");
			console.log(window.ticket.get('id_operazione_ext'));
            return this.el;
            
           
        }
       
     /*   estimateWalkingTime: function(position){
        	google.maps.DistanceMatrixService.getDistanceMatrix (
    
        		{
        			//parametri :
        			origins : google.maps.LatLng(position.coords.latitude, position.coords.longitude),
        			destinations : this.centro.coordinate ,
        			travelmode : google.maps.TravelMode.WALKING,
        			avoidHighways : false,
        			avoidTolls : false
        			
        		},
        		    
        		    //callback :
        		    walkingTime = response.rows[0].elements[0].distance.text
        		
        	);
        }*/
  
    });









       


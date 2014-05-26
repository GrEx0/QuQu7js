var link = Backbone.Model.extend({
 
    initialize: function(){
      this.bind("change", this.attributesChanged);
    },
 
    attributesChanged: function(){
    	console.log("Link rilevato dal modello");
      if (this.get('link'))
      {
      	$.get( this.get('link'), function( data ) 
      	{
  				$("#answer" ).html( data );
  				alert( "Load was performed." );
		});
      }
        
    }
  
  });
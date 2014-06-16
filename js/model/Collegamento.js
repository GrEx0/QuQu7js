var link = Backbone.Model.extend({
 
    initialize: function(){
      this.bind("change", this.attributesChanged);
    },
 
    attributesChanged: function(){
    	alert("Link rilevato dal modello:"+this.get('link'));
      if (this.get('link'))
		{
			alert("sono dentro if");
			$.getJSON( this.get('link'),function( data ){
				
				this.longFunctionFirst(shortfunctionsecond);
					
				
			});
		}
        
    },
    
    longFunctionFirst: function(callback){
    	setTimeout(function(){
    			window.ticket.set({
						'id':data.id,
						'data':data.Data,
						'center':data.Nome,
						'centerPosition':data.centerPosition,
						'id_centro_ext':data.id_centro_ext,
						'ticketNumber':data.Numero,
						'operation':data.CodiceLettera,
						'id_operazione_ext':data.id_operazione
					});
    		if(typeof callback == 'function')
            callback();
    		
    	},1000);
    	
    },
    
    shortfunctionsecond: function(){
    	
    	 setTimeout($("#answer").html(window.ticket.get('data')+": SUCCESS, Ticket "+window.ticket.get('operation')+window.ticket.get('ticketNumber')+" attivato"), 200);
    	
    }
    
    
    
  
  });
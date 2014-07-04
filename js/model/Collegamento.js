var link = Backbone.Model.extend({
 
    initialize: function(){
      this.bind("change", this.attributesChanged);
    },
 
    attributesChanged: function(){
    	//("link rilevato dal modello");
      if (this.get('link'))
		{
			// utilizzo gli oggetti deferred per garantire la sequenzialità delle due operazioni
			
			promise = this.ajaxCall().then(this.updatediv); 		// Prima carico i dati nel modello ticket, 
																	// Poi aggiorno la pagina
		}
        
    },
    ajaxCall:function(){
    	window.dajax = new $.Deferred();
    	$.getJSON( this.get('link'),function( data ){			 // Ricevo un array JSON, e chiamo la funzione di callback
                
					window.ticket.set({
						'id':data.Id,
						'data':data.Data,
						'center':data.Nome,
						'centerPosition':data.centerPosition,
						'id_centro_ext':data.id_centro_ext,
						'ticketNumber':data.Numero,
						'operation':data.CodiceLettera,
						'id_operazione_ext':data.id_operazione
					});
					window.dajax.resolve();
			});
			return window.dajax.promise();	
    	
    },
    // Aggiorno il div
    
    updatediv:function(){
    	 d = new $.Deferred();
    	 $("#answer").html(window.ticket.get('data')+": SUCCESS, Ticket attivato");
    	 d.resolve();
    	 return d.promise();	
    	
    }
  
  });
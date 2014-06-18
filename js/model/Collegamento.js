var link = Backbone.Model.extend({
 
    initialize: function(){
      this.bind("change", this.attributesChanged);
    },
 
    attributesChanged: function(){
    	alert("1");
      if (this.get('link'))
		{

			alert("sono dentro if");
			promise = this.ajaxCall().then(this.updatediv);
			
		}
        
    },
    ajaxCall:function(){
    	window.dajax = new $.Deferred();
    	$.getJSON( this.get('link'),function( data ){

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
					window.dajax.resolve();
			});
			return window.dajax.promise();	
    	
    },
    updatediv:function(){
    	 d = new $.Deferred();
    	 $("#answer").html(window.ticket.get('data')+": SUCCESS, Ticket "+window.ticket.get('operation')+window.ticket.get('ticketNumber')+" attivato");
    	 d.resolve();
    	 return d.promise();	
    	
    }
  
  });
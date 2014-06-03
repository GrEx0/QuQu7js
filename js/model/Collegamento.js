var link = Backbone.Model.extend({
 
    initialize: function(){
      this.bind("change", this.attributesChanged);
    },
 
    attributesChanged: function(){
    	console.log("Link rilevato dal modello:"+this.get('link'));
      if (this.get('link'))
		{
			console.log("sono dentro if");
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
				$("#answer").html(window.ticket.get('data')+": SUCCESS, Ticket "+window.ticket.get('operation')+window.ticket.get('ticketNumber')+" attivato");
			});
		}
        
    }
  
  });
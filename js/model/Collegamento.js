var link = Backbone.Model.extend({
 
    initialize: function(){
      this.bind("change", this.attributesChanged);
    },
 
    attributesChanged: function(){
    	alert("1");
      if (this.get('link'))
		{
			alert("2");
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
			}).done($("#answer").html(window.ticket.get('data')+": SUCCESS, Ticket "+window.ticket.get('operation')+window.ticket.get('ticketNumber')+" attivato"));	
		}
        
    }
  
  });
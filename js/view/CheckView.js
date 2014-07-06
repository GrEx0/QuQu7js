Check_View = Backbone.View.extend({
	
        initialize: function(){
            this.template = _.template( tpl.get('Check') );
            window.ticket.bind("change", this.render,this);
            console.log("Check.html template caricato");
            
          
          },
          
      
        render: function(){
            this.$el.html( this.template(this.model.toJSON()) );
            console.log("Rendering Check_view");
			console.log(window.ticket.get('id_operazione_ext'));
            return this.el;
            
           
          }
      
 
    });









       


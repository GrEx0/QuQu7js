Check_View = Backbone.View.extend({
	
        initialize: function(){
            this.template = _.template( tpl.get('Check') );
            window.ticket.bind("change", this.render,this);
            console.log("Check.html template caricato");
<<<<<<< HEAD
            
=======
       
          },
>>>>>>> 9aeb1648698b9828aba35fa8be3da88421b7c609
          
          },
          
      
        render: function(){
            this.$el.html( this.template(this.model.toJSON()) );
            console.log("Rendering Check_view");
			console.log(window.ticket.get('id_operazione_ext'));
            return this.el;
            
           
<<<<<<< HEAD
          }
      
 
=======
        }
        
  
>>>>>>> 9aeb1648698b9828aba35fa8be3da88421b7c609
    });









       


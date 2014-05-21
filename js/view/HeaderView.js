Header_View = Backbone.View.extend({
        initialize: function(){
            this.template = _.template( tpl.get('Header') );
            console.log("Header.html template caricato");
        },
        render: function(){
            this.$el.html( this.template() );
            return this.el;
        },
        
        events: {
        	"click .back" : "goBack"
    	},
 
    	goBack: function() {
        	app.navigate('', true);
         	return false;
    	}
        
    });

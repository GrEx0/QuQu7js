Start_View = Backbone.View.extend({
        initialize: function(){
            this.template = _.template( tpl.get('Start') );
            console.log("Start.html template caricato");
        },
        render: function(){
            this.$el.html( this.template() );
            return this.el;
        }
        
    });

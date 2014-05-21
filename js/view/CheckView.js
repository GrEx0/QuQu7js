Check_View = Backbone.View.extend({
        initialize: function(){
            this.template = _.template( tpl.get('Check') );
            console.log("Check.html template caricato");
        },
        render: function(){
            this.$el.html( this.template() );
            return this.el;
        }
    });

ticket = new Ticket;
ticket.Centro = "cazzo";

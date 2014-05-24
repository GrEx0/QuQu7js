Check_View = Backbone.View.extend({
        initialize: function(){
            this.template = _.template( tpl.get('Check') );
             this.model.on("change", this.render);
            console.log("Check.html template caricato");
        },
        render: function(){
            this.$el.html( this.template(this.model.toJSON()) );
            return this.el;
        }
    });









       


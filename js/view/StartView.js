StartView = Backbone.View.extend({
        initialize: function(){
            this.template = _.template( tpl.get('Start') );
        },
        render: function(){
            this.$el.html( this.template() );
            return this.el;
        },
        events: {
            "click input[type=button]": "doSearch"
        },
        doSearch: function( event ){
            // Button clicked, you can access the element that was clicked with event.currentTarget
            alert( "Search for " + $("#search_input").val() );
        }
    });

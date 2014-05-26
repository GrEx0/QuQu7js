Backbone.View.prototype.close = function () {
    console.log('Closing view ' + this);
    if (this.beforeClose) {
        this.beforeClose();
    }
    this.remove();
    this.unbind();
};

var AppRouter = Backbone.Router.extend({
 
    initialize: function () {
        $('header').html(new Header_View().render());
    },

    routes: {
        "": "StartApp",
        "AcquireQR/": "AcquireQR",
        "Check/": "CheckDetails"
    },
 
    StartApp: function () {
        
            this.showView('.content', new Start_View());
            $('#backBtn').css({"visibility":"hidden"});
    },
 
    AcquireQR: function () {
          	this.showView('.content', new AcquireQR_View({model: new link()}));
          	$('#backBtn').css({"visibility":"visible"});  
    },
 
    CheckDetails: function () {
        ticket = new Ticket({
    		id:"1",
    		data:"05 maggio",
    		center:"Milano -ATM",
    		ticketNumber:"04",
    		operation:"N",
    		walkingTime:"4min"
    	});
    	console.log(ticket.get("center"));
        this.showView('.content', new Check_View({model:ticket}));
        $('#backBtn').css({"visibility":"visible"});    
            
    },
 
    showView: function (selector, view) {
        if (this.currentView) this.currentView.close();
 
        $(selector).html(view.render());
        this.currentView = view;
         
        return view;
    },
 
 /*   before: function (callback) {
        if (this.wineList) {
            if (callback) callback.call(this);
        } else {
            this.wineList = new WineCollection();
            var self = this;
            this.wineList.fetch({
                success: function () {
                    var winelist = new WineListView({
                        model: self.wineList
                    }).render();
                    $('#sidebar').html(winelist);
                    if (callback) callback.call(self);
                }
            });
        }
    }*/
 
});

/* --- Start main --- */

tpl.loadTemplates(['Start', 'AcquireQR', 'Check','Header'], function () {
   app = new AppRouter();
   Backbone.history.start();
});


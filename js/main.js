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
        window.ticket = new Ticket();
        pushNotification = window.plugins.pushNotification;
		pushNotification.register(this.successHandler, this.errorHandler,{"senderID":"408316694165","ecb":"app.onNotificationGCM"});
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
    	console.log(ticket.get("center"));
        this.showView('.content', new Check_View({model:window.ticket}));
        $('#backBtn').css({"visibility":"visible"});    
            
    },
 
    showView: function (selector, view) {
        if (this.currentView) this.currentView.close();
 
        $(selector).html(view.render());
        this.currentView = view;
         
        return view;
    },
    
    // result contains any message sent from the plugin call
	successHandler: function(result) {
   		 alert('Callback Success! Result = '+result);
	},
	
	errorHandler:function(error) {
    		alert(error);
	},

	onNotificationGCM: function(e) {
        switch( e.event )
        {
            case 'registered':
                if ( e.regid.length > 0 )
                {
                    console.log("Regid " + e.regid);
                    alert('registration id = '+e.regid);
                }
            break;
 
            case 'message':
              // this is the actual push notification. its format depends on the data model from the push server
              alert('message = '+e.message+' msgcnt = '+e.msgcnt);
            break;
 
            case 'error':
              alert('GCM error = '+e.msg);
            break;
 
            default:
              alert('An unknown GCM event has occurred');
              break;
        }
    }
 
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


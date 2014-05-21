Backbone.View.prototype.close = function () {
    console.log('Closing view ' + this);
    if (this.beforeClose) {
        this.beforeClose();
    }
    this.remove();
    this.unbind();
};

var AppRouter = Backbone.Router.extend({
 
/*    initialize: function () {
        $('.content').html(new StartView().render());
    },*/

    routes: {
        "": "StartApp",
        "AcquireQR/": "AcquireQR",
        "Check/": "CheckDetails"
    },
 
    StartApp: function () {
        
            this.showView('.content', new Start_View());
    },
 
    AcquireQR: function () {
          	this.showView('.content', new AcquireQR_View());  
    },
 
    CheckDetails: function () {
        
        this.showView('.content', new Check_View());  
            
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
 
tpl.loadTemplates(['Start', 'AcquireQR', 'Check'], function () {
   app = new AppRouter();
   Backbone.history.start();
});


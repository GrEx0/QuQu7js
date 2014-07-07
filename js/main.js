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

// Definisco le routes, ovvero le funzioni da chiamare quando navighi in una path
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
          	this.showView('.content', new AcquireQR_View({model:window.link}));
          	$('#backBtn').css({"visibility":"visible"});  
    },
 
    CheckDetails: function () {
    	console.log(ticket.get("center"));
        this.showView('.content', new Check_View({model:window.ticket}));
        $('#backBtn').css({"visibility":"visible"});    
            
    },
 //showView: Chiudo la view del content e faccio il render della nuova view
    showView: function (selector, view) {
        if (this.currentView) this.currentView.close();
 
        $(selector).html(view.render());
        this.currentView = view;
         
        return view;
    }
 
});

/* --- Start main --- */

document.addEventListener('deviceready', onDeviceReady, true);
function onDeviceReady() {
		console.log("DeviceReady");
		tpl.loadTemplates(['Start', 'AcquireQR', 'Check','Header'], function () {
   		app = new AppRouter();
   		Backbone.history.start();
   		window.ticket = new Ticket(); 
		window.link = new link();
   		window.regid='test';
   		window.url ="http://ququ7.altervista.org/ServerSide/";
   
	});
	var pushNotification;
	try 
				{ 
                	pushNotification = window.plugins.pushNotification;
                	if (device.platform == 'android' || device.platform == 'Android') 
                	{
						console.log("registro android");
                    	pushNotification.register(
                    		successHandler,
                    		errorHandler, {
                    			"senderID":"408316694165",
                    			"ecb":"onNotificationGCM"
                    		});		// required!
					} 
					else 
					{
                    	pushNotification.register(
                    		tokenHandler, 
                    		errorHandler, {
                    			"badge":"true",
                    			"sound":"true",
                    			"alert":"true",
                    			"ecb":"onNotificationAPN"
                    		});	// required!
                	}
                }
				catch(err) 
				{ 
					txt="There was an error on this page.\n\n"; 
					txt+="Error description: " + err.message + "\n\n"; 
					alert(txt);

				}
}
// handle APNS notifications for iOS
function onNotificationAPN(e) {
                if (e.alert) {
                     console.log(e.alert);
                     navigator.notification.alert(e.alert);
                     
                }
                    
                if (e.sound) {
                    var snd = new Media(e.sound);
                    snd.play();
                }
                
                if (e.badge) {
                    pushNotification.setApplicationIconBadgeNumber(successHandler, e.badge);
                }
            }
            
// handle GCM notifications for Android
function onNotificationGCM(e) {
				var my_media = new Media("/android_asset/www/beep.wav");
				var my_update = new Media("/android_asset/www/notifi.wav");		

                switch( e.event )
                {
                    case 'registered':
					if ( e.regid.length > 0 )
					{
						// Your GCM push server needs to know the regID before it can push to this device
						// here is where you might want to send it the regID for later use.
						//alert("regID = "+e.regid);
						window.regid = e.regid;
						
					}
                    break;
                    
                    case 'message':
                    	// if this flag is set, this notification happened while we were in the foreground.
                    	// you might want to play a sound to get the user's attention, throw up a dialog, etc.
                    	navigator.notification.vibrate(500);
                    	switch (e.message)
                    		{
                    			case "Turno terminato":
                    					window.ticket.set({
											"id":"",
       										"data":"",
        									"center":"N/D",
        									"centerPosition":"N/D",
        									"ticketNumber":"N/D",
        									"operation":"",
        									"id_operazione_ext":"",
        									"waitingTime":"N/D",
        									"walkingTime":"N/D",
        									"N":0
										});
									clearInterval(window.idtimer);
                    				window.count = 0;
                    				window.neveragain = 0;
                    			break;
                    			
                    			case "E' il tuo turno!":
                    				clearInterval(window.idtimer);
                    				window.count = 0;
                    				navigator.notification.alert(e.message, function(){},'Notifica');
                    				my_media.play();
                    			break;
                    			
                    			case "update":
									navigator.notification.alert("prima"+e.soundname, function(){},'Notifica');
                    			    valori= e.soundname;
                    			    risultato = valori.split(",");

                    			    
                    			   navigator.notification.alert("dopo"+risultato[0], function(){},'Notifica');
                    				window.ticket.set({
                    					"waitingTime":risultato[1],
                    					"N":risultato[0]
                    					});
                    			break;
                    			
                    			case "Utente inserito nel server":
                    				navigator.notification.alert(e.message, function(){},'Notifica');
                    			break;
                    			
                    			default:
                    				navigator.notification.alert(e.message, function(){},'Notifica');
                    				

                    		}	


                    	if (e.foreground)
                    	{
							console.log("INLINE NOTIFICATION");
							
							// if the notification contains a soundname, play it.
							var my_media = new Media("/android_asset/www/beep.wav");
							my_media.play();
						}
						else
						{	// otherwise we were launched because the user touched a notification in the notification tray.
							if (e.coldstart)
								console.log("COLDSTART NOTIFICATION");
							else
							console.log("BACKGROUND NOTIFICATION");
						}

                    break;
                    
                    case 'error':
						alert('GCM error = '+e.msg);
                    break;
                    
                    
                    default:
						 alert('An unknown GCM event has occurred');
                    break;
                }
            }
            
function tokenHandler (result) {
                console.log('token: '+ result +'\n');
                // Your iOS push server needs to know the token before it can push to this device
                // here is where you might want to send it the token for later use.
            }
			
function successHandler (result) {
                console.log('success:'+ result +'\n');
            }
            
function errorHandler (error) {
                console.log('error:'+ error +'\n');
            }

 


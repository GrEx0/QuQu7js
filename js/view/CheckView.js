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

var ticket = new Ticket();

ticket.Centro = "yo";
ticket.Numero = "yo";
ticket.Operazione = "yo";
ticket.Stima = "bro";


document.getElementById("center").innerHTML = ticket.Centro;

document.getElementById("ticketNumber").innerHTML = ticket.Numero;

document.getElementById("operation").innerHTML = ticket.Operazione;

document.getElementById("waitingTime").innerHTML = ticket.Stima;



       


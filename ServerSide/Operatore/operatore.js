$(document).ready(function(){
	
	$('#cc').combobox({
		url:'operatore.php?&operation=getOperazioni',
		valueField:'Descrizione',
		textField: 'Descrizione'
		
	});
	
	
	
	
	$("#number").load("operatore.php?&operation=getNumber");
	$("#oper").load("operatore.php?&operation=getOper");
	
	$("#changeButton").click(function(){
		
		
		console.log($( '#cc' ).val());
		
		});

});






$(document).ready(function(){
	
	console.log('figa');
	$("#number").load("operatore.php?&operation=getNumber");
	$("#oper").load("operatore.php?&operation=getOper");
	$("#cliente").load("operatore.php?&operation=getCliente");
	$('#combobox').load("operatore.php?&operation=getOperazioni");
	
	
	$('#combobox').change(function() {
   // assign the value to a variable, so you can test to see if it is working
    	var selectVal = $('#combobox :selected').val();
    	$.get("operatore.php?&operation=changeOperazione&NuovaOperazione="+selectVal,function(data){
    		if (data == 'SUCCESS')
    			{
    				alert("Operazione Aggiornata.");
    				$('#oper').html($('#combobox :selected').text());
    			}
    		});
    	
	});

	
	//chiama prossimo numero	
   $("#next").click(function(){
		
		$.get("operatore.php?&operation=avantiNumero",function(data){
			console.log('eccomi');
			alert(data);
		});
		
		});


});






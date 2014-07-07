$(document).ready(function(){
	
	$("#number").load("operatore.php?&operation=getNumber");
	$("#cliente").load("operatore.php?&operation=getCliente");
	$('#combobox').load("operatore.php?&operation=getOperazioni");
	
	$.getJSON("operatore.php?&operation=getOper",function(data){
		
		$("#oper").html(data.Descrizione);
		$('#combobox').val(data.Id);
		
	});
	
	//cambia operazione
	$('#combobox').change(function() {
   
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
			if(data=='nessun numero da servire, cambiare operazione per continuare a lavorare'){alert(data);}
			$("#cliente").load("operatore.php?&operation=getCliente");
		});
		
		});


});






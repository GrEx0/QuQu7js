$(document).ready(function(){
	
	
	$("#number").load("operatore.php?&operation=getNumber");
	$("#oper").load("operatore.php?&operation=getOper");
	$("#cliente").load("operatore.php?&operation=getCliente");
	
	
	$('#cc').combobox({
		
		
		url:'operatore.php?&operation=getOperazioni',
		valueField:'Id',
		textField: 'Descrizione',
		onSelect : function(record){
			
			//cambia operazione
			
			$('#cc').combobox('setValue', record.Id);
		    
		    $(this).load("operatore.php?&operation=changeOperazione&NuovaOperazione="+record.Id);
		    
		    location.reload();
		  
		}
		
	});
	
	
	
	//chiama prossimo numero	
   $("#next").click(function(){
		
		$(this).load("operatore.php?&operation=avantiNumero");
		
		
		location.reload();
		});


});






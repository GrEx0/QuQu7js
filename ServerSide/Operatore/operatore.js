$(document).ready(function(){
	
	
	
	$('#cc').combobox({
		
		
		url:'operatore.php?&operation=getOperazioni',
		valueField:'Id',
		textField: 'Descrizione',
		onSelect : function(record){
			
			//cambia operazione
			
			$('#cc').combobox('setValue', record.Id);
		    
		    console.log(record.Descrizione);
		    
		    $(this).load("operatore.php?&operation=changeOperazione&NuovaOperazione="+record.Id);
		    
		    
		    $("#oper").load("operatore.php?&operation=getOper");//refresh
		  
		}
		
	});
	
		
	
	$("#number").load("operatore.php?&operation=getNumber");
	$("#oper").load("operatore.php?&operation=getOper");
	
	
	//chiama prossimo numero	
   $("#next").click(function(){
		
		(this).load("operatore.php?&operation=avantiNumero");
		
		$("#number").load("operatore.php?&operation=getNumber");//refresh
		
		});


});






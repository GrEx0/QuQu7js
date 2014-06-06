$(document).ready(function(){
	console.log("eccomi");
    $("ul").load("./centerOperations.php?&operation=showOperations",function() {
						
						$('.popup-link').magnificPopup({
							type: 'ajax'
						});
				}
	
	);
});
$(document).ready(function(){
	
	$('form#process-data').validate();
	
	$('form#process-data #action-wrapper button:first-child').click(function(){
		history.go(-1);
	});
});
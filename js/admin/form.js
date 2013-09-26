$(document).ready(function(){

	$('input, select').tooltip();
	
	/* Form Auto Width */
	var max_width = 450;
	var label_width = 0;
	
	$('#form-content label.label-input').each(function(){
		if ($(this).width() > label_width)
		{
			label_width = $(this).width();
		}
	});
		
	$('#form-content label.label-input').width(label_width);

	var input_width = max_width - label_width - 40;
	
	$('#form-content input, #form-content select, #form-content textarea.input').each(function(){
		$(this).width(input_width);
	});
	
	/* END Form Auto Width */
	
	$('form#process-data').validate({
		ignoreTitle: true
	});
	
	$('form#process-data #action-wrapper button:first-child').click(function(){
		history.go(-1);
	});
	
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true
	});
});
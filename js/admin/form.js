$(document).ready(function(){

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
	
	var field_width = 0;
	
	$('#form-content input').each(function(){
		var input_width = max_width - label_width - 40;
		$('#form-content input').width(input_width);
	});
	/* END Form Auto Width */
	
//	$('form#process-data').validate();
	
	$('form#process-data #action-wrapper button:first-child').click(function(){
		history.go(-1);
	});
	
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true
	});
});
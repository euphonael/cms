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
		if ($(this).hasClass('has-suffix'))
		{
			var suffix_width = $(this).siblings('span.suffix').width();
			$(this).width(input_width - suffix_width - 5);
		}
		else
		{
			$(this).width(input_width);
		}
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
	
	$('input.number-format').each(function(){
		var angka = $(this).val().replace(',', '');
		var format = number_format(angka, 0, '', ',')
		$(this).val(format);
    });
	
	$('input.number-format').keyup(function(){
		var angka = $(this).val().replace(',', '');
		var format = number_format(angka, 0, '', ',')
		$(this).val(format);
	});
	
	$('p.hidden').hide();
	
	$('input.dhm_customer_type').change(function(){
		var type = $(this).val();
		
		if (type == 1)
		{
			$('#dhm_company_name_wrap').fadeOut().hide().find('input').prop('disabled', true);
			$('#dhm_client_name_wrap').fadeIn().find('input').prop('disabled', false);
		}
		else if (type == 2)
		{
			$('#dhm_client_name_wrap').fadeOut().hide().find('input').prop('disabled', true);
			$('#dhm_company_name_wrap').fadeIn().find('input').prop('disabled', false);
		}
	});
	
	$('input.maintenance_customer_type').change(function(){
		var type = $(this).val();
		
		if (type == 1)
		{
			$('#maintenance_company_name_wrap').fadeOut().hide().find('input').prop('disabled', true);
			$('#maintenance_client_name_wrap').fadeIn().find('input').prop('disabled', false);
		}
		else if (type == 2)
		{
			$('#maintenance_client_name_wrap').fadeOut().hide().find('input').prop('disabled', true);
			$('#maintenance_company_name_wrap').fadeIn().find('input').prop('disabled', false);
		}
	});
});
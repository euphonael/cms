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
		var angka = $(this).val().replace(/,/g, '');
		var format = number_format(angka, 0, '', ',')
		$(this).val(format);
    });
	
	$('input.number-format').keyup(function(){
		var angka = $(this).val().replace(/,/g, '');
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
	
	$('input.project_customer_type').change(function(){
		var type = $(this).val();
		
		if (type == 1)
		{
			$('#project_company_name_wrap').fadeOut().hide().find('input').prop('disabled', true);
			$('#project_client_name_wrap').fadeIn().find('input').prop('disabled', false);
		}
		else if (type == 2)
		{
			$('#project_client_name_wrap').fadeOut().hide().find('input').prop('disabled', true);
			$('#project_company_name_wrap').fadeIn().find('input').prop('disabled', false);
		}
	});
	
	$('#add-project-top').click(function(){
		/* How many TOP now? */
		var count = $('div.project-top').length;
		
		if (count == 1)
		{
			$('#del-project-top').fadeIn();
		}
		
		var type = ($('#type_value').is(':checked')) ? 2 : 1;
		
		$('#temp-top').load(base_url + 'admin/project/add_top/' + count + '/' + type, function(html){
			
			var suffix_width = $('#project-top-list span.suffix').width();

			$('#project-top-list').append($('#temp-top').html());
			$('#project-top-list label.label-input').width(label_width);
			$('#project-top-list input').width(input_width - suffix_width - 5);
			
			$('#temp-top').html('');
		});
	});
	
	$('#del-project-top').click(function(){
		
		var count = $('div.project-top').length;
		$('#project-top-list div.project-top:last').remove();

		var new_count = count - 1;
		
		if (new_count == 1)
		{
			$('#del-project-top').fadeOut();
		}
	});

	$('input.project_top_type').click(function(){
		var type = $(this).val();
		
		if (type == 1)
		{
			$('span.suffix').fadeIn();
			var price = int($('#project_price').val().replace(/,/g, ''));
			var markup = int($('#project_markup').val().replace(/,/g, ''));
			var total = price + markup;
			
			$('div.project-top input').each(function(){
				var amount = int($(this).val().replace(/,/g, ''));
				
				$(this).val(amount / total * 100);
			});
		}
		else if (type == 2) // Fixed amount, convert
		{
			var price = int($('#project_price').val().replace(/,/g, ''));
			var markup = int($('#project_markup').val().replace(/,/g, ''));
			var total = price + markup;
			
			console.log('Price : ' + price);
			
			$('span.suffix').fadeOut();
			$('div.project-top input').each(function(){
				var percent = int($(this).val().replace(/,/g, ''));
				
				$(this).val(number_format(percent / 100 * total));
			});
		}
	});
	
	/*
	$('div.project-top input').keyup(function(){
		var type = ($('input#type_value').is(':checked')) ? 2 : 1;
		
		
		if (type == 1)
		{
			var total = 0;
			$('div.project-top input').each(function(){
				var value = int($(this).val());
				total = total + value;
			});
			
			if (total != 100)
			{
				$('#project-top-error').html('Total amount must be 100%').fadeIn();
			}
			else
			{
				$('#project-top-error').html('').fadeOut();
			}
		}
		else if (type == 2)
		{
			var price = $('input#project_price').val().replace(',', '');
			var markup = $('input#project_markup').val().replace(',', '');
			
			var total = int(price) + int(markup);
			var result = 0;
			
			$('div.project-top input').each(function(){
				var value = int($(this).val().replace(',', ''));
				result = result + value;
			});
			
			if (result != total)
			{
				$('#project-top-error').html('Total amount must be equal to price + markup value').fadeIn();
			}
			else
			{
				$('#project-top-error').html('').fadeOut();
			}
		}
	});
	*/
});
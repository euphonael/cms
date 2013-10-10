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
		
		if ($(this).hasClass('number-format'))
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

	$('input.project_top_type').change(function(){
		var type = $(this).val();
		
		if (type == 1)
		{
			$('span.suffix').fadeIn();
			var price = int($('#project_price').val().replace(/,/g, ''));
			var markup = int($('#project_markup').val().replace(/,/g, ''));
			var total = price + markup;
			
			$('div.project-top input').each(function(){
				
				var char = $(this).val().length;
				
				if (char > 3) // Kalo udah bentuk harga, convert ke percent
				{
					console.log('Udah harga, convert ke percent');
					$(this).removeClass('number-format');
					$(this).attr('maxlength', 3);
					var amount = int($(this).val().replace(/,/g, ''));
					
					$(this).val(amount / total * 100);
				}
			});
		}
		else if (type == 2) // Fixed amount, convert
		{
			var price = int($('#project_price').val().replace(/,/g, ''));
			var markup = int($('#project_markup').val().replace(/,/g, ''));
			var total = price + markup;
			
			$('span.suffix').fadeOut();
			
			$('div.project-top input').each(function(){

				$(this).removeAttr('maxlength');
				$(this).addClass('number-format');
				var percent = $(this).val().replace(/,/g, '');
				
				$(this).val(number_format(percent / 100 * total));
			});
		}
	});
	
	$('table.project-invoice a.button.inside').click(function(){
		
		var top_number = $(this).closest('tr').find('td.payment-number').attr('id').replace('payment-', '');
		var tr = $(this).closest('tr');

		var amount = $('#project_top_' + $(this).attr('id').replace('project-top-', '')).val().replace(/,/g, ''); // Jumlahnya?
	
		if (amount.length < 4) // Kalo masih percent, convert ke harga
		{
			var price = int($('#project_price').val().replace(/,/g, ''));
			var markup = int($('#project_markup').val().replace(/,/g, ''));
			var total = price + markup;
			
			amount = amount / 100 * total;
		}
				
		var data = {
			invoice_type : 3, // Project
			invoice_item_id : $('#project_unique_id').val(), // Project unique id
			invoice_customer_type :($('#type_company').is(':checked')) ? 2 : 1,
			invoice_customer_name : ($('#type_company').is(':checked')) ? $('#project_company_name').val() : $('#project_client_name').val(),
			invoice_project_name : $('#project_name').val(),
			invoice_product_id : $('select[name=project_product_id]').val(),
			invoice_price : $('#project_price').val().replace(/,/g, ''),
			invoice_markup : $('#project_markup').val().replace(/,/g, ''),
			invoice_commission : 0,
			invoice_top : $('div.project-top').length,
			invoice_top_number : top_number,
			invoice_top_percent : '', // Kalo project, gimana?
			invoice_top_amount : amount,
			invoice_bank_id : $('select[name=project_bank_id]').val(),
			invoice_currency : $('select[name=project_currency]').val(),
		};
		
		alertify.prompt("Generate Invoice. Note:", function(e, memo){
			if (e)
			{
				data.invoice_note = memo;
				$.ajax({
					type : 'POST',
					data: data,
					url : base_url + 'admin/project/create_invoice',
					success: function(html)
					{
						var result = $.parseJSON(html);
						
						$(tr).attr('id', 'invoice-' + result.unique_id);
						$(tr).find('td.top').html(result.invoice_number);
						$(tr).find('td.date').html(result.readable_date);
						$(tr).find('td.note').html(result.invoice_note);
						$(tr).find('td.status').html('<span class="flag active"></span><img src="' + base_url + 'images/ajax-loader.gif' + '" />');
						$(tr).find('td.del').html('<td class="del"><input type="checkbox" /></td>');
						alertify.success('Invoice #___ generated');
					}
				});
			}
		});
	});
});
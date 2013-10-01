$(document).ready(function(){
	$('select#admin_privilege').change(function(){
		var value = $(this).val();
		
		if (value == 3)
			$('#privilege-table').fadeIn();
		else
			$('#privilege-table').fadeOut();
	});

	$('.access-add').change(function(){
		if (this.checked)
		{
			$(this).parent('td').prev().children('.access-read').prop('checked', true);
			$(this).parent('td').next().children('.access-modify').prop('checked', true);
		}
	});
	
	// If edit is allowed, read is too.
	$('.access-modify').change(function(){
		if (this.checked)
		{
			$(this).parent('td').prev().prev().children('.access-read').prop('checked', true);
		}
		else
		{
			$(this).parent('td').prev().children('.access-add').prop('checked', false);
			$(this).parent('td').next().children('.access-delete').prop('checked', false);
		}
	});
	
	// If delete is allowed, read & edit is too
	$('.access-delete').change(function(){
		
		if (this.checked){
			$(this).parent('td').prev().prev().prev().children('.access-read').prop('checked', true);
			$(this).parent('td').prev().children('.access-modify').prop('checked', true);
		}
	});
	
	// If read is OFF, edit is OFF too
	$('.access-read').change(function(){
		if ( ! this.checked) {
			$(this).parent('td').next().next().children('.access-modify').prop('checked', false);
			$(this).parent('td').next().children('.access-add').prop('checked', false);
			$(this).parent('td').next().next().next().children('.access-delete').prop('checked', false);
		}
	});

	// Calculate total :)
	$('tr td input').change(function(){
		
		// Which module?
		var module = $(this).attr('name');
		var module_id = module.replace('module-', '');
		
		// Get all value.
		var read = int($('input[name=' + module +'].access-read:checked').val());
		var add = int($('input[name=' + module +'].access-add:checked').val());
		var modify = int($('input[name=' + module +'].access-modify:checked').val());
		var del = int($('input[name=' + module +'].access-delete:checked').val());
		var value = read + add + modify + del
		
		$('#total-' + module_id).val(value);
	});
});
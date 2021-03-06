$(document).ready(function(){
		
	alertify.set({ buttonReverse: true });
	
	$('table.table-data').dataTable({
		iDisplayLength: 100,
		aLengthMenu: [100, 200, 300, 400, 999]
	});

	$('a.button.inside.extend').click(function(){
		
		var invoice_id = $(this).attr('name');
		var period = $(this).attr('rel');
		var dhm_id = $(this).closest('tr').attr('id').replace('dhm-', '');
		
		var ini = $(this);

		var range = $(this).closest('tr').find('td.dhm-start').attr('rel');
		var end = $(this).closest('tr').find('td.dhm-end-date');

		
		alertify.confirm("Extend this DHM by <strong style=\"font-size:14px;\">" + period + " months</strong>?", function(e){
			if (e)
			{
				$.ajax({
					type : 'POST',
					url : base_url + 'admin/dhm/extend/' + dhm_id,
					data : { period : period, invoice_id : invoice_id },
					success: function(html){
						$(end).html(html);
						alertify.success("DHM Successfully Extended");
						$(ini).remove();
					}
				});
			}
		});
		
		return false;
	});

	$('#list-filter').validate();
	
	$(document).on('click', 'table.table-data tbody tr td span.flag', function(){
		
		var db_table = $(this).closest('table.table-data').attr('id');
		var unique_id = $(this).closest('tr').attr('id').replace(db_table + '-', '');
		var current_status = $(this).attr('class').replace('flag ', '');
		var ajax_loader = $(this).siblings('img');
		var flag = $(this);
		var notes = $(this).closest('td').siblings('td.memo');
		var resign = $(this).closest('td').siblings('td.resign');
		
		if (db_table == 'invoice')
		{
			var flag = $('tr[rel=' + unique_id + '] span.flag');
			var notes = $('tr[rel=' + unique_id + '] td.memo');
		}
		
		if (current_status == 'active')
		{
			var change_to = 'inactive';
		}
		else if (current_status == 'inactive')
		{
			var change_to = 'active';
		}
		
		if (db_table == 'admin')
		{
			if (current_status == 'active')
			{
				var change_to = 'resigned';
				var reason = 'Please input resign date (yyyy-mm-dd)';
			}
			else
			{
				var reason = 'Reason';
			}
		}
		else
		{
			var reason = 'Reason';
		}
		
		alertify.prompt("Changing status to <strong>" + change_to.toUpperCase() + "</strong>. " + reason + ":", function(e, memo){
			if (e)
			{
				$(ajax_loader).fadeIn();
				$.ajax({
					type : 'POST',
					data : { db_table : db_table, unique_id : unique_id, current_status : current_status, memo : memo },
					url : base_url + 'admin/ajax/toggle_status',
					success: function(html)
					{
						if (change_to == 'resigned') change_to = 'inactive';
						$(flag).removeClass(current_status).addClass(change_to);
						
						if (db_table != 'admin')
						{
							$(notes).html(memo);
						}
						else
						{
							$(resign).html(memo);
						}
						$(ajax_loader).fadeOut();
						
						if (change_to == 'active')
						{
							alertify.success("Status changed to <strong>" + change_to.toUpperCase() + "</strong>");
						}
						else if (change_to == 'inactive')
						{
							if (db_table == 'admin')
							{
								alertify.error("Status changed to <strong>Resigned</strong>");
							}
							else
							{
								alertify.error("Status changed to <strong>" + change_to.toUpperCase() + "</strong>");
							}
						}
					}
				});
			}
		});
	});
	
	$(document).on('click', 'table.table-data tbody tr td.del input[type=checkbox]', function(){
		$(this).toggleClass('checked');
	});
	
	$('div#action-wrapper button.delete').click(function(){

		var table_id = $(this).attr('id').replace('delete-', '');
		
		if ($('table#' + table_id + ' tbody tr td.del input[type=checkbox].checked').length > 0)
		{
			alertify.confirm("Are you sure you want to delete the selected items?", function(e){;
			if (e)
			{			
				$('table#' + table_id + ' tbody tr td.del input[type=checkbox]').each(function(){
					if ($(this).hasClass('checked'))
					{
						var row = $(this).closest('tr');
						var db_table = $(this).closest('table.table-data').attr('id');
						var unique_id = $(this).closest('tr').attr('id').replace(db_table + '-', '');
						var project_id = ($(this).closest('td').attr('attr')) ? $(this).closest('td').attr('attr') : 0;
						
						$.ajax({
							type : 'POST',
							data : { db_table : db_table, unique_id : unique_id },
							url : base_url + 'admin/ajax/delete_row/' + project_id,
							success: function(html)
							{
								alertify.error("Items deleted");
								$(row).fadeOut(500);
							}
						});
					}
				});
			}
			});
		}
	});
	
});
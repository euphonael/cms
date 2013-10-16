$(document).ready(function(){
		
	alertify.set({ buttonReverse: true });
	
	$('table.table-data').dataTable({
		iDisplayLength: 100,
		aLengthMenu: [100, 200, 300, 400, 999]
	});


	$('#list-filter').validate();
	
	$(document).on('click', 'table.table-data tbody tr td span.flag', function(){
		
		var db_table = $(this).closest('table.table-data').attr('id');
		var unique_id = $(this).closest('tr').attr('id').replace(db_table + '-', '');
		var current_status = $(this).attr('class').replace('flag ', '');
		var ajax_loader = $(this).siblings('img');
		var flag = $(this);
		var notes = $(this).closest('td').siblings('td.memo');
		
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
		
		alertify.prompt("Changing status to <strong>" + change_to.toUpperCase() + "</strong>. Reason:", function(e, memo){
			if (e)
			{
				$(ajax_loader).fadeIn();
				$.ajax({
					type : 'POST',
					data : { db_table : db_table, unique_id : unique_id, current_status : current_status, memo : memo },
					url : base_url + 'admin/ajax/toggle_status',
					success: function(html)
					{
						$(flag).removeClass(current_status).addClass(change_to);
						$(notes).html(memo);
						$(ajax_loader).fadeOut();
						
						if (change_to == 'active')
						{
							alertify.success("Status changed to <strong>" + change_to.toUpperCase() + "</strong>");
						}
						else if (change_to == 'inactive')
						{
							alertify.error("Status changed to <strong>" + change_to.toUpperCase() + "</strong>");
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
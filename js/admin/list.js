$(document).ready(function(){

	$('table.table-data tbody tr td span.flag').click(function(){
		
		var db_table = $(this).closest('table.table-data').attr('id');
		var unique_id = $(this).closest('tr').attr('id').replace(db_table + '-', '');
		var current_status = $(this).attr('class').replace('flag ', '');
		var ajax_loader = $(this).siblings('img');
		var flag = $(this);
		var notes = $(this).closest('td').siblings('td.memo');
		
		var memo = prompt("Reason:");
		
		$(ajax_loader).fadeIn();
		
		$.ajax({
			type : 'POST',
			data : { db_table : db_table, unique_id : unique_id, current_status : current_status, memo : memo },
			url : base_url + 'admin/ajax/toggle_status',
			success: function(html)
			{				
				if (current_status == 'active')
				{
					$(flag).removeClass('active').addClass('inactive');
				}
				else if (current_status == 'inactive')
				{
					$(flag).removeClass('inactive').addClass('active');
				}
				
				$(notes).html(memo);
				
				$(ajax_loader).fadeOut();
			}
		});
	});
	
	$('table.table-data tbody tr').hover(function(){
		$(this).find('td span.action').css({ visibility: 'visible' });
	}, function(){
		$(this).find('td span.action').css({ visibility: 'hidden' });
	});
	
});
<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?></h2>
            <div id="action-wrapper">
                <button type="button">Back</button>
                <button type="reset">Reset Form</button>
            	<input type="submit" value="Save Data" />
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
        </div>
        
        <table id="add-invoice" class="table-data" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="small">No.</th>
                    <th class="long">Invoice Type</th>
                    <th>Item Name</th>
                    <th>Product</th> <!-- DHM auto DHM, Maintenance / Project Choose -->
                    <th>Periode</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
				<?php for ($x = 1; $x <= 5; $x++) : ?>
                <tr id="invoice-item-<?php echo $x; ?>" class="invoice-item">
                    <td><?php echo $x; ?></td>
                    <td>
						<select name="invoice_type[]" class="invoice_type">
                        	<option value="">--</option>
                            <option value="1">DHM</option>
                            <option value="2">Maintenance</option>
<!--                            <option value="3">Project</option>-->
                        </select>
                    </td>
                    <td>
                    	<select name="invoice_item_id[]" class="invoice_item_id">	
                        	<option value="">--</option>
                        </select>
                    </td>
                    <td>
                    	<select name="invoice_product_id[]" class="invoice_product_id">
                        	<option value="">--</option>
                        </select>
                    </td>
                    <td class="period"></td>
                    <td class="price"></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </form>
</div>
<style>
table#add-invoice select { width:100%; box-sizing:border-box; -moz-box-sizing:border-box; }
table#add-invoice input { width:15%; box-sizing:border-box; -moz-box-sizing:border-box; }
select.invoice_item_id, select.invoice_product_id { display:none; }
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('select.invoice_type').change(function(){
		var tr = $(this).closest('tr');
		var type = $(this).val();
		
		$(tr).find('select.invoice_item_id').load(base_url + 'admin/invoice/get_type/' + type, function(){
			
			$(tr).find('td.period *').fadeOut();
			$(tr).find('span').fadeOut();
			
			if (type)
			{
				$(this).fadeIn();
			}
			else
			{
				$(this).fadeOut();
			}
		});
		
		$(tr).find('select.invoice_product_id').load(base_url + 'admin/invoice/get_product/' + type, function(){
			if (type)
			{
				$(this).fadeIn();
				if (type == 1) $(this).find('option[value=2]').prop('selected', true); // Value 2 = DHM
			}
			else
			{
				$(this).fadeOut();
			}
		});
	});
	
	$('select.invoice_item_id').change(function(){
		var tr = $(this).closest('tr');
		var invoice_type = $(this).closest('tr').find('select.invoice_type').val();
		var item_id = $(this).val();
		
		if (item_id)
		{
			if (invoice_type != 3) // DHM ato Maintenance
			{
				$(tr).find('td.price').load(base_url + 'admin/invoice/get_price/' + invoice_type + '/' + item_id, function(){
					$(this).fadeIn();
				});
				
				$(tr).find('td.period').load(base_url + 'admin/invoice/get_period/' + invoice_type + '/' + item_id, function(){
					
					$(this).find(':hidden').fadeIn();
					
					if (invoice_type == 2) // Maintenance
					{
						$(this).keyup(function(){
							var angka = $(this).find('input.number-format').val().replace(/,/g, '');
							var format = number_format(angka, 0, '', ',');
							$(this).find('input.number-format').val(format);
						});
					}
				});
			}
		}
		else
		{
			$(tr).find('td.period *').fadeOut();
			$(tr).find('td.price *').fadeOut();
		}
	});
});
</script>
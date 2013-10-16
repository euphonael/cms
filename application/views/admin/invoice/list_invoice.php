<?php
$max = 0;
foreach ($result as $row) :

if ($max < $row['total_top_amount']) $max = $row['total_top_amount'];

endforeach; ?>
<script type="text/javascript">
$(document).ready(function(){	
	$('#company_list').autocomplete({
		source: <?php echo $company_list; ?>,
		change: function(event, ui)
		{
			if(ui.item == null || ui.item == undefined)
			{
				$('#company_list').val('').focus();
				alertify.error('You have to choose an existing company');
			}
		}
	});
	
	$('#client_list').autocomplete({
		source: <?php echo $client_list; ?>,
		change: function(event, ui)
		{
			if(ui.item == null || ui.item == undefined)
			{
				$('#client_list').val('').focus();
				alertify.error('You have to choose an existing client');
			}
		}
	});
	
	$('input[name=customer_type]').change(function(){
		if ($('#customer_client').is(':checked'))
		{
			$('#type-' + 2).fadeOut().hide();
			$('#type-' + 1).fadeIn();
		}
		else
		{
			$('#type-' + 1).fadeOut().hide();
			$('#type-' + 2).fadeIn();
		}
	});
	
	$('input.datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
	

	
	$("#slider-range").slider({
		range: true,
		step: 1000000, // 1 juta
		min: 0,
		max: <?php echo $max; ?>, // 100 juta
		values: [<?php echo ($this->input->post('amount')) ? $this->input->post('amount_start'): 0; ?>, <?php echo ($this->input->post('amount')) ? $this->input->post('amount_end'): 5000000; ?>], // 0 - 1 juta
		slide: function(event, ui) {
			$("#amount").val("Rp. " + number_format(ui.values[0]) + " - Rp. " + number_format(ui.values[1]));
			$('#amount_start').val(ui.values[0]);
			$('#amount_end').val(ui.values[1]);
		}
	});
	
	 $("#amount").val("Rp. " + number_format($("#slider-range").slider("values", 0 )) + " - Rp. " + number_format($("#slider-range").slider("values", 1 )));
	 
	 $('a.button.inside').fancybox({
		autoSize: false,
		width: 515,
		height: 400
	});	
});
</script>

<div id="container">
	<div id="content-heading">
    	<h2><?php echo $title; ?></h2>
        <div id="action-wrapper">
            <a class="button" href="<?php echo base_url('admin/' . $this->url . '/add'); ?>">New <?php echo $this->title; ?></a>
            <button class="delete" id="delete-<?php echo $this->db_table; ?>" title="Delete selected items"><img src="<?php echo base_url('images/icon-delete.png'); ?>" /></button>
            <div class="clear"></div>
        </div>
        
        <div class="clear"></div>
    </div>
    
    <form id="list-filter" method="post" action="<?php echo current_url(); ?>">
    	<div class="radio">
        	<p>
            	<label>Customer Type</label>
                <input type="radio" name="customer_type" id="customer_client" value="1" <?php if ($this->input->post('customer_type') == 1) echo 'checked="checked"'; ?> />
                <label class="label" for="customer_client">Client</label>
                <input type="radio" name="customer_type" id="customer_company" value="2" <?php if ($this->input->post('customer_type') == 2) echo 'checked="checked"'; ?> />
                <label class="label" for="customer_company">Company</label>
                <span class="clear"></span>
            </p>
        </div>
        <div id="type-1" <?php if ($this->input->post('customer_type') != 1) echo 'style="display:none;"'; ?>>
        	<p>
            	<label>Client Name</label>
                <input type="text" id="client_list" name="client" value="<?php echo $this->input->post('client'); ?>" />
            </p>
        </div>
        <div id="type-2" <?php if ($this->input->post('customer_type') != 2) echo 'style="display:none;"'; ?>>
        	<p>
            	<label>Company Name</label>
                <input type="text" id="company_list" name="company" value="<?php echo $this->input->post('company'); ?>" />
            </p>
        </div>
        <div class="clear"></div>
        <div>
        	<label>Invoice Date</label>
            <input type="text" class="datepicker" name="start" id="invoice_start" value="<?php echo $this->input->post('start'); ?>" />
            <span class="suffix">to</span>
            <input type="text" class="datepicker" name="end" id="invoice_end" value="<?php echo $this->input->post('end'); ?>" />
        </div>
        <div class="clear"></div>


		<div>
            <p>
            <label for="amount">Price range:</label>
            <input type="text" id="amount" name="amount" style="border: 0; color: #8DBBD8; font-weight: bold;" />
            <input type="hidden"  id="amount_start" name="amount_start" value="<?php if ($this->input->post('amount_start')) echo $this->input->post('amount_start'); else echo '0'; ?>" />
            <input type="hidden" id="amount_end" name="amount_end" value="<?php if ($this->input->post('amount_end')) echo $this->input->post('amount_end'); else echo '20000000'; ?>" />
            </p>
            <div id="slider-range"></div>
		</div>
        
        <div class="clear"></div>
        <div>
            <p>
                <label>Product</label>
                <select name="product">
                    <option value="">--</option>
                    <?php foreach ($product_list as $item) : ?>
                    <option value="<?php echo $item['unique_id']; ?>" <?php if ($this->input->post('product') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['product_code']; ?> <?php echo $item['product_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
        <div>
            <p>
                <label>Status</label>
                <select name="payment">
                    <option value="">--</option>
                    <option value="1" <?php if ($this->input->post('payment') == 1) echo 'selected="selected"'; ?>>Paid</option>
                    <option value="2" <?php if ($this->input->post('payment') == 2 || ! $this->input->post('payment')) echo 'selected="selected"'; ?>>Pending</option>
                    <option value="3" <?php if ($this->input->post('payment') == 3) echo 'selected="selected"'; ?>>All</option>
                </select>
            </p>
        </div>
    	<div>
        	<p>
                <label>Flag</label>
                <select name="flag">
                    <option value="">--</option>
                    <option value="1" <?php if ($this->input->post('flag') == 1) echo 'selected="selected"'; ?>>Active</option>
                    <option value="2" <?php if ($this->input->post('flag') == 2) echo 'selected="selected"'; ?>>Inactive</option>
                    <option value="3" <?php if ($this->input->post('flag') == 3) echo 'selected="selected"'; ?>>Deleted</option>
                </select>
            </p>
        </div>
        <div class="clear"></div>
        <input type="submit" value="Search" />
    </form>

    
    <table id="<?php echo $this->db_table; ?>" class="table-data" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="small">No.</th>
                <th>Invoice #</th>
                <th>Name</th>
                <th>Payment</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Bank</th>
                <th>Amount</th>
                <th>Price</th>
                <th>Markup</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Date</th>
                <th class="medium">Status</th>
                <th>Memo</th>
                <th class="small">Del</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 1; ?>
            
            <?php
			
			$price = 0;
			$markup = 0;
			$total = 0;
			
			$paid_price = 0;
			$paid_markup = 0;
			$paid_total = 0;

			
			?>
            
            
            <?php foreach ($result as $row) : ?>
            
            <?php
			
			$total += $row['total_top_amount'];
			
			$query = $this->db->get_where('invoice', array('unique_id' => $row['unique_id']))->result_array();
			
			foreach ($query as $sub)
			{
				if ($sub['invoice_paid'] == 1)
				{
					$paid_price += ($sub['invoice_top_amount'] / ($sub['invoice_price'] + $sub['invoice_markup'])) * $sub['invoice_price'];
					$paid_markup += ($sub['invoice_top_amount'] / ($sub['invoice_price'] + $sub['invoice_markup'])) * $sub['invoice_markup'];
				}
				
				$markup += ($sub['invoice_top_amount'] / ($sub['invoice_price'] + $sub['invoice_markup'])) * $sub['invoice_markup'];
				$price += ($sub['invoice_top_amount'] / ($sub['invoice_price'] + $sub['invoice_markup'])) * $sub['invoice_price'];
			}
			
			?>
            <tr rel="<?php echo $row['unique_id']; ?>" id="<?php echo $this->db_table; ?>-<?php echo $row['unique_id']; ?>">
                <td><?php echo $x; ?></td>
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['invoice_number']; ?></a></td>
                <?php if ($row['invoice_type'] == 1) $url = 'dhm'; elseif ($row['invoice_type'] == 2) $url = 'maintenance'; elseif ($row['invoice_type'] == 3) $url = 'project'; ?>
                <td><a href="<?php echo base_url('admin/' . $url . '/view/' . $row['invoice_item_id']); ?>"><?php echo $row['invoice_project_name']; ?></a></td>
                <?php if ($row['invoice_paid'] == 0) : ?>
                <td class="payment">
                	<a class="button inside" id="invoice-pay-<?php echo $row['unique_id']; ?>" data-fancybox-type="iframe" href="<?php echo base_url('admin/invoice/pay/' . $row['unique_id']); ?>">Paid</a>
                </td>
                <?php else : ?>
                <td><?php echo date('d M Y', strtotime($row['invoice_paid_date'])); ?></td>
                <?php endif; ?>
                <td><?php echo $row['product_code']; ?></td>
                <td><?php echo $row['invoice_customer_name']; ?></td>
                <td><?php echo $row['bank_name']; ?></td>
                
                <td><strong><?php echo number_format($row['total_top_amount']); ?></strong></td>
                <td><?php echo number_format($row['total_invoice_price']); ?></td>
                <td><?php echo number_format($row['total_invoice_markup']); ?></td>
                <td><?php echo number_format($row['total_invoice_price'] + $row['total_invoice_markup']); ?></td>
                <td><?php echo ($row['top_count'] == 1) ? $row['invoice_top_number'] . '/' . $row['invoice_top'] : '-'; ?></td>
                <td><?php echo date('d M Y', strtotime($row['invoice_create_date'])); ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
            <?php
			
			$paid_total = $paid_price + $paid_markup;
			
			$ar_price = $price - $paid_price;
			$ar_markup = $markup - $paid_markup;
			$ar_total = $total - $paid_total;
								
			?>
            
        </tbody>
    </table>
    
    <table style="margin:50px auto 0;" id="invoice-summary" border="1" cellspacing="0" cellpadding="5">
    	<thead>
        	<tr>
            	<th colspan="4">Total: <?php echo count($result); ?> invoice<?php if (count($result) > 1) echo 's'; ?></th>
            </tr>
        	<tr>
            	<th width="100"></th>
            	<th width="100">Price</th>
                <th width="100">Markup</th>
                <th width="100">Total</th>
            </tr>
        </thead>
        <tbody>
        	<tr>
            	<td>Total</td>
            	<td><?php echo number_format($price); ?></td>
                <td><?php echo number_format($markup); ?></td>
                <td><?php echo number_format($total); ?></td>
            </tr>
            <tr>
            	<td>Paid</td>
                <td><?php echo number_format($paid_price); ?></td>
                <td><?php echo number_format($paid_markup); ?></td>
                <td><?php echo number_format($paid_total); ?></td>
            </tr>
            <tr>
            	<td>AR</td>
                <td><?php echo number_format($ar_price); ?></td>
                <td><?php echo number_format($ar_markup); ?></td>
                <td><?php echo number_format($ar_total); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php
$max = 0;
foreach ($result as $row) :

if ($max < $row['project_price']) $max = $row['project_price'];

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
		values: [<?php echo ($this->input->post('amount')) ? $this->input->post('amount_start'): 0; ?>, <?php echo ($this->input->post('amount')) ? $this->input->post('amount_end'): $max; ?>], // 0 - 1 juta
		slide: function(event, ui) {
			$("#amount").val("Rp. " + number_format(ui.values[0]) + " - Rp. " + number_format(ui.values[1]));
			$('#amount_start').val(ui.values[0]);
			$('#amount_end').val(ui.values[1]);
		}
	});
	
	 $("#amount").val("Rp. " + number_format($("#slider-range").slider("values", 0 )) + " - Rp. " + number_format($("#slider-range").slider("values", 1 )));
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
        	<label>Project Date</label>
            <input type="text" class="datepicker" name="start" id="project_start" value="<?php echo $this->input->post('start'); ?>" />
            <span class="suffix">to</span>
            <input type="text" class="datepicker" name="end" id="project_end" value="<?php echo $this->input->post('end'); ?>" />
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
                <label>Sales</label>
                <select name="sales">
                    <option value="">--</option>
                    <?php foreach ($admin_list as $item) : ?>
                    <option value="<?php echo $item['unique_id']; ?>" <?php if ($this->input->post('sales') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['admin_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
        <div>
            <p>
                <label>Payment</label>
                <select name="payment">
                    <option value="">--</option>
                    <option value="0">No payment yet</option>
                    <option value="1" <?php if ($this->input->post('payment') == 1) echo 'selected="selected"'; ?>>1st Payment</option>
                    <option value="2" <?php if ($this->input->post('payment') == 2) echo 'selected="selected"'; ?>>2nd Payment</option>
                    <option value="3" <?php if ($this->input->post('payment') == 3) echo 'selected="selected"'; ?>>3rd Payment</option>
                    <option value="4" <?php if ($this->input->post('payment') == 4) echo 'selected="selected"'; ?>>4th Payment</option>
                    <option value="5" <?php if ($this->input->post('payment') == 5) echo 'selected="selected"'; ?>>5th Payment</option>
                    <option value="ALL">All payment done</option>
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
                <th>Project Name</th>
                <th>Create Date</th>
                <th>Product</th>
                <th>Company / Client</th>
                <th>T.O.P</th>
<!--                <th>Percent / Value</th>-->
                <th>Bank</th>
                <th>Price</th>
                <th>Markup</th>
                <th>Total</th>
                <th>Sales</th>
                <th class="medium">Status</th>
                <th>Memo</th>
                <th class="small">Del</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 1; ?>
            <?php foreach ($result as $row) : ?>
            <tr id="<?php echo $this->db_table; ?>-<?php echo $row['unique_id']; ?>">
                <td><?php echo $x; ?></td>
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['project_name']; ?></a></td>
                <td><?php echo date('d M Y', strtotime($row['project_create_date'])); ?></td>
                <td><?php echo $row['product_code'] . ' ' . $row['product_name']; ?></td>
                <td><?php echo ($row['company_name']) ? $row['company_name'] : $row['client_name']; ?></td>
                <td><?php echo $row['project_invoice_count'] . '/' . $row['project_top']; ?></td>
                <td><?php echo $row['bank_name']; ?></td>
                <td><?php echo number_format($row['project_price']); ?></td>
                <td><?php echo number_format($row['project_markup']); ?></td>
                <td><?php echo number_format($row['project_price'] + $row['project_markup']); ?></td>
                <td><?php echo $row['admin_name']; ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
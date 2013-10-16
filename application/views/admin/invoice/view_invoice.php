<script type="text/javascript">
$(document).ready(function(){
	$('a.invoice-payment').fancybox({
		autoSize: false,
		width: 515,
		height: 400
	});
	
	$('a.print').click(function(){
		var teks = $(this).html();
		var href = $(this).attr('href');
		
		postdata = new Object();
		
		alertify.prompt($(this).html() + '? Note :', function(e, memo){
			if (e)
			{
				postdata.invoice_unique_id = <?php echo $Row[0]['unique_id']; ?>;
				
				if (memo)
				{
					postdata.invoice_log_description = teks + ' (Note: ' + memo + ')';
				}
				else
				{
					postdata.invoice_log_description = teks;
				}
				
				$.ajax({
					type : 'POST',
					url : base_url + 'admin/invoice/add_log',
					data : postdata
				});
				
				var printWindow = window.open(href, "mywindow", "width=700, height=500, scrollbars=1, resizable=1");
				printWindow.moveTo(300, 75);
			}
		});
		
		return false;
	});
});
</script>
<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $Row[0]['invoice_number']; ?></h2>
            <div id="action-wrapper">
			<?php if ($Row[0]['invoice_paid'] == 0) : ?>
               	<a class="button inside invoice-payment" id="invoice-pay-<?php echo $Row[0]['unique_id']; ?>" data-fancybox-type="iframe" href="<?php echo base_url('admin/invoice/pay/' . $Row[0]['unique_id'] . '/view'); ?>">Paid</a>
			<?php endif; ?>
            	<a class="button inside print" href="<?php echo base_url('admin/invoice/print_invoice/' . $Row[0]['unique_id']); ?>">Print Invoice</a>
                <a class="button inside print" href="<?php echo base_url('admin/invoice/print_receipt/' . $Row[0]['unique_id']); ?>">Print Receipt</a>
                <button type="button">Back</button>
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
        </div>
        
        <div id="form-content">
        	<div id="form-left">
                <fieldset>
                    <legend>Invoice Info</legend>
                    
                    <p>
                        <label class="label-input">Invoice Number</label>
                        <input type="text" value="<?php echo $Row[0]['invoice_number']; ?>" readonly="readonly" />
                    </p>
                    
                    <p>
                        <label class="label-input">Create Date</label>
                        <input type="text" value="<?php echo date('d M Y', strtotime($Row[0]['invoice_create_date'])); ?>" readonly="readonly" />
                    </p>
                    
                    <p>
                        <label class="label-input">Customer Name</label>
                        <input type="text" value="<?php echo $Row[0]['invoice_customer_name']; ?>" readonly="readonly" />
                    </p>
                    
                    <?php
					$price = 0;
					$markup = 0;
					$amount = 0;
					
					foreach ($Row as $item)
					{
						$price = $price + $item['invoice_price'];
						$markup = $markup + $item['invoice_markup'];
						$amount = $amount + $item['invoice_top_amount'];
					}
					?>
                    <p>
                        <label class="label-input">Total Price</label>
                        <input type="text" value="<?php echo number_format($price); ?>" readonly="readonly" />
                    </p>
                    
                    <p>
                        <label class="label-input">Total Mark up</label>
                        <input type="text" value="<?php echo number_format($markup); ?>" readonly="readonly" />
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
            	<fieldset>
                	<legend>Payment Info</legend>
                    
                    <p>
                    	<label class="label-input">Bank</label>
                        <input type="text" value="<?php echo $Row[0]['bank_name']; ?> (<?php echo $Row[0]['bank_account_number']; ?> a/n <?php echo $Row[0]['bank_account_holder']; ?>)" readonly="readonly" />
                    </p>
                    
                    <p>
                    	<label class="label-input">Currency</label>
                        <input type="text" value="<?php echo $Row[0]['bank_currency']; ?>" readonly="readonly" />
                    </p>
                    
                    <p>
                    	<label class="label-input">Invoice Amount</label>
                        <input type="text" value="<?php echo number_format($amount); ?>" readonly="readonly" />
                    </p>
                </fieldset>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
    
    <table id="invoice_detail" class="table-data" cellpadding="0" cellspacing="0">
    	<thead>
        	<tr>
            	<th>ID</th>
                <th>Product Description</th>
                <th>Price</th>
                <th>Markup</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($Row as $item) : ?>
        	<tr>
            	<td><?php echo $item['product_code']; ?></td>
                <td><?php echo $item['product_name']; ?></td>
                <td align="center"><?php echo number_format($item['invoice_price']); ?></td>
                <td align="center"><?php echo number_format($item['invoice_markup']); ?></td>
                <td><?php echo number_format($item['invoice_top_amount']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
	<table id="invoice_log" class="table-data" cellpadding="0" cellspacing="0">
    	<thead>
        	<tr>
            	<th class="small">No.</th>
                <th class="long">Date / Time</th>
                <th class="long">Admin</th>
                <th class="note">Note</th>
            </tr>
        </thead>
        <tbody>
        	<?php $x = 1; ?>
        	<?php foreach ($log as $item) : ?>
        	<tr>
            	<td><?php echo $x; ?></td>
                <td><?php echo date('d M Y H:i', strtotime($item['invoice_log_datetime'])); ?></td>
                <td><?php echo $item['admin_name']; ?></td>
                <td><?php echo $item['invoice_log_description']; ?></td>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
                <?php if ($Row[0]['invoice_paid'] == 0) : ?>
            <tr id="add-new">
                    <td><?php echo $x; ?></td>
                    <td class="date"><?php echo date('d M Y H:i'); ?></td>
                    <td><?php echo $this->session->userdata('admin_name'); ?></td>
                    <td class="note"><input type="text" name="<?php echo $Row[0]['unique_id']; ?>" id="invoice_log_description" /></td>
            </tr>
                <?php endif; ?>
        </tbody>
    </table>
</div>
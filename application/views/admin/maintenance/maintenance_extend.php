<script type="text/javascript">
$(document).ready(function(){
	$('form#maintenance-extend').validate({
		submitHandler: function(){
			$.ajax({
				type: 'POST',
				url: '<?php echo current_url(); ?>',
				data: $('form#maintenance-extend').serialize(),
				success: function(html)
				{
					parent.$.fancybox.close();
					parent.alertify.success('Domain: <strong><?php echo $row['maintenance_name']; ?></strong><br />Extended to: <strong>' + html + '</strong>');
					parent.$('#maintenance-<?php echo $row['unique_id']; ?> td.maintenance-end-date').html(html);
					parent.$('#maintenance-<?php echo $row['unique_id']; ?> td.maintenance-extend').html('');
				}
			})
		}
	});
});
</script>
<div id="container">
	<form id="maintenance-extend" class="popup" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $row['maintenance_name']; ?></h2>            
            <div class="clear"></div>
        </div>
        
        <div id="form-content">
        	<div id="form-left">
                
                <fieldset>
                    <legend>Maintenance Info</legend>
                    
                    <input type="hidden" name="invoice_customer_type" value="<?php echo $row['maintenance_customer_type']; ?>" readonly="readonly" />                    
					<?php if ($row['maintenance_customer_type'] == 1) : ?>
                    <p>
                        <label class="label-input" for="maintenance_client_name">Client Name</label>
                        <input type="text" name="maintenance_client_name" id="maintenance_client_name" value="<?php echo $row['maintenance_client_name']; ?>" class="required" readonly="readonly" />
                    </p>
                    <?php elseif ($row['maintenance_customer_type'] == 2) : ?>
                    <p>
                        <label class="label-input" for="maintenance_company_name">Company Name</label>
                        <input type="text" name="maintenance_company_name" id="maintenance_company_name" value="<?php echo $row['maintenance_company_name']; ?>" class="required" readonly="readonly" />
                    </p>
                    <?php endif; ?>
                    
                    <p>
                        <label class="label-input" for="invoice_project_name">Project Name</label>
                        <input type="text" name="invoice_project_name" id="invoice_project_name" value="<?php echo (set_value('invoice_project_name')) ? set_value('invoice_project_name') : $row['maintenance_name'] . ' ' . date('M Y'); ?>" class="required" />
                        <?php echo form_error('invoice_project_name'); ?>
                    </p>
                    
					<p>
                        <label class="label-input" for="maintenance_period">Period</label>
                        <input type="text" name="maintenance_period" id="maintenance_period" class="has-suffix digits required" title="Number of months" value="<?php echo form_value('maintenance_period', $row); ?>" />
                        <span class="suffix">Months</span>
                        <?php echo form_error('maintenance_period'); ?>
                        <span class="clear"></span>
                        <label class="error initial" for="maintenance_period"></label>
                    </p>
                    
                    <p>
                        <label class="label-input" for="maintenance_product_id">Product Name</label>
                        <select name="maintenance_product_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($product_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('maintenance_product_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['product_code']; ?> <?php echo $item['product_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('maintenance_product_id'); ?>
                    </p>
                </fieldset>
                
            	<fieldset>
                	<legend>Payment Details</legend>
					<p>
                        <label class="label-input" for="maintenance_bank_id">Bank</label>
                        <select name="maintenance_bank_id" class="required">
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('maintenance_bank_id', $row, $item['unique_id']); ?>><?php echo $item['bank_name']; ?> (<?php echo $item['bank_account_number']; ?> a/n <?php echo $item['bank_account_holder']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('maintenance_bank_id'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="bank_currency">Currency</label>
                        <select name="bank_currency" class="required">
                            <option value="Rp." <?php default_selected('bank_currency', $row, 'Rp.'); ?>>Rp.</option>
                            <option value="USD" <?php default_selected('bank_currency', $row, 'USD'); ?>>USD</option>
                        </select>
                        <?php echo form_error('bank_currency'); ?>
                    </p>    
                    
                    <p>
                        <label class="label-input" for="maintenance_price">Price</label>
                        <input type="text" name="maintenance_price" id="maintenance_price" class="number-format required" value="<?php echo form_value('maintenance_price', $row); ?>" />
                        <?php echo form_error('maintenance_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_markup">Mark-up</label>
                        <input type="text" name="maintenance_markup" id="maintenance_markup" class="number-format" value="<?php echo form_value('maintenance_markup', $row); ?>" />
                        <?php echo form_error('maintenance_markup'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="invoice_note">Note</label>
                        <textarea class="input" name="invoice_note" id="invoice_note"><?php echo (set_value('invoice_note')) ? set_value('invoice_note') : 'Maintenance: ' . $row['maintenance_name']; ?></textarea>
                        <?php echo form_error('invoice_note'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div class="clear"></div>
        </div>
        
		<div id="action-wrapper">
            <input type="submit" value="Extend &amp; Create Invoice" />
            <div class="clear"></div>
        </div>
    </form>
</div>
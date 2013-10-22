<script type="text/javascript">
$(document).ready(function(){
	$('form#dhm-extend').validate({
		submitHandler: function(){
			$.ajax({
				type: 'POST',
				url: '<?php echo current_url(); ?>',
				data: $('form#dhm-extend').serialize(),
				success: function(html)
				{
					parent.$.fancybox.close();
					parent.alertify.success('Invoice created for: <strong><?php echo $row['dhm_name']; ?></strong>');
					parent.$('#dhm-<?php echo $row['unique_id']; ?> td.dhm-end-date').html(html);
					parent.$('#dhm-<?php echo $row['unique_id']; ?> td.dhm-extend').html('');
				}
			})
		}
	});
});
</script>
<div id="container">
	<form id="dhm-extend" class="popup" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $row['dhm_name']; ?></h2>            
            <div class="clear"></div>
        </div>
        
        <div id="form-content">
        	<div id="form-left">
                
                <fieldset>
                    <legend>DHM Info</legend>
                    
                    <input type="hidden" name="invoice_customer_type" value="<?php echo $row['dhm_customer_type']; ?>" readonly="readonly" />                    
					<?php if ($row['dhm_customer_type'] == 1) : ?>
                    <p>
                        <label class="label-input" for="dhm_client_name">Client Name</label>
                        <input type="text" name="dhm_client_name" id="dhm_client_name" value="<?php echo $row['dhm_client_name']; ?>" class="required" readonly="readonly" />
                    </p>
                    <?php elseif ($row['dhm_customer_type'] == 2) : ?>
                    <p>
                        <label class="label-input" for="dhm_company_name">Company Name</label>
                        <input type="text" name="dhm_company_name" id="dhm_company_name" value="<?php echo $row['dhm_company_name']; ?>" class="required" readonly="readonly" />
                    </p>
                    <?php endif; ?>
                    
                    <p>
                        <label class="label-input" for="invoice_project_name">Project Name</label>
                        <input type="text" name="invoice_project_name" id="invoice_project_name" value="<?php echo (set_value('invoice_project_name')) ? set_value('invoice_project_name') : $row['dhm_name'] . ' ' . date('M Y'); ?>" class="required" />
                        <?php echo form_error('invoice_project_name'); ?>
                    </p>
                    
					<p>
                        <label class="label-input" for="dhm_period">Extension Period</label>
                        <select name="dhm_period" class="required">
                        	<option value="12" <?php if (set_value('dhm_period') == 12) echo 'selected="selected"'; ?>>12 months</option>
                            <option value="24" <?php if (set_value('dhm_period') == 24) echo 'selected="selected"'; ?>>24 months</option>
                            <option value="36" <?php if (set_value('dhm_period') == 36) echo 'selected="selected"'; ?>>36 months</option>
                            <option value="48" <?php if (set_value('dhm_period') == 48) echo 'selected="selected"'; ?>>48 months</option>
                            <option value="60" <?php if (set_value('dhm_period') == 60) echo 'selected="selected"'; ?>>60 months</option>
                        </select>
                        <?php echo form_error('dhm_period'); ?>
                    </p>
                </fieldset>
                
            	<fieldset id="extend-payment-details">
                	<legend>Payment Details</legend>
					<p>
                        <label class="label-input" for="dhm_bank_id">Bank</label>
                        <select name="dhm_bank_id" class="required">
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('dhm_bank_id', $row, $item['unique_id']); ?>><?php echo $item['bank_name']; ?> (<?php echo $item['bank_account_number']; ?> a/n <?php echo $item['bank_account_holder']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_bank_id'); ?>
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
                        <label class="label-input" for="dhm_price">Price</label>
                        <input type="text" name="dhm_price" id="dhm_price" class="number-format required" value="<?php echo form_value('dhm_price', $row); ?>" />
                        <?php echo form_error('dhm_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_markup">Mark-up</label>
                        <input type="text" name="dhm_markup" id="dhm_markup" class="number-format" value="<?php echo form_value('dhm_markup', $row); ?>" />
                        <?php echo form_error('dhm_markup'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="invoice_note">Note</label>
                        <textarea class="input" name="invoice_note" id="invoice_note"><?php echo (set_value('invoice_note')) ? set_value('invoice_note') : 'Domain: ' . $row['dhm_name']; ?></textarea>
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
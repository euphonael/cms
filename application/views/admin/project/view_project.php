<script type="text/javascript">
$(document).ready(function(){	
	$('#project_company_name').autocomplete({
		source: <?php echo $company_list; ?>,
		change: function(event, ui)
		{
			if(ui.item == null || ui.item == undefined)
			{
				$('#project_company_name').val('').focus();
				alertify.error('You have to choose an existing company');
			}
		}
	});
	
	$('#project_client_name').autocomplete({
		source: <?php echo $client_list; ?>,
		change: function(event, ui)
		{
			if(ui.item == null || ui.item == undefined)
			{
				$('#project_client_name').val('').focus();
				alertify.error('You have to choose an existing client');
			}
		}
	});
});
</script>
<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $row['project_name']; ?></h2>
            <div id="action-wrapper">
                <button type="button">Back</button>
                <button type="reset">Reset Form</button>
            	<input type="submit" value="Save Data" />
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
        </div>
        
        <div id="form-content">
        	<div id="form-left">
                <fieldset>
                    <legend>Basic Info</legend>
                    
                    <p>
                        <label class="label-input" for="project_name">Project Name</label>
                        <input type="text" name="project_name" id="project_name" class="required" value="<?php echo form_value('project_name', $row); ?>" />
                        <?php echo form_error('project_name'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_product_id">Product Name</label>
                        <select name="project_product_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($product_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('project_product_id', $row, $item['unique_id']); ?>><?php echo $item['product_code']; ?> <?php echo $item['product_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('project_product_id'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_sales_id">Sales</label>
                        <select name="project_sales_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($admin_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('project_sales_id', $row, $item['unique_id']); ?>><?php echo $item['admin_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('project_sales_id'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_price">Price</label>
                        <input type="text" name="project_price" id="project_price" class="number-format required" value="<?php echo form_value('project_price', $row); ?>" />
                        <?php echo form_error('project_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="project_markup">Mark-up</label>
                        <input type="text" name="project_markup" id="project_markup" class="number-format" value="<?php echo form_value('project_markup', $row); ?>" />
                        <?php echo form_error('project_markup'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_note">Note</label>
                        <textarea class="input" name="project_note" id="project_note"><?php echo form_value('project_note', $row); ?></textarea>
                        <?php echo form_error('project_note'); ?>
                    </p>
                </fieldset>
                
                <fieldset>
                	<legend>Payment Details</legend>
                    <p>
                        <label class="label-input" for="project_bank_id">Bank</label>
                        <select name="project_bank_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('project_bank_id', $row, $item['unique_id']); ?>><?php echo $item['bank_name']; ?> (<?php echo $item['bank_account_number']; ?> a/n <?php echo $item['bank_account_holder']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('project_bank_id'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_currency">Currency</label>
                        <select name="project_currency" class="required">
                            <option value="Rp." <?php default_selected('project_currency', $row, 'Rp.'); ?>>Rp.</option>
                            <option value="USD" <?php default_selected('project_currency', $row, 'USD'); ?>>USD</option>
                        </select>
                        <?php echo form_error('project_currency'); ?>
                    </p>    
                </fieldset>
            </div>
            
            <div id="form-right">
                <fieldset>
                    <legend>Customer Info</legend>
                    <p>
                        <label class="label-input">Type</label>
                        <span class="radio-options">
                            <input type="radio" name="project_customer_type" value="1" id="type_client" class="project_customer_type required" <?php default_checked('project_customer_type', $row, 1); ?> />
                            <label class="radio" for="type_client">Client</label>
                            <input type="radio" name="project_customer_type" value="2" id="type_company" class="project_customer_type" <?php default_checked('project_customer_type', $row, 2); ?> />
                            <label class="radio" for="type_company">Company</label>
                            <span class="clear"></span>
                        </span>
                        <span class="clear"></span>
                        <label class="error initial" for="project_customer_type"></label>
                        <?php echo form_error('project_customer_type'); ?>
                    </p>

                    <p id="project_client_name_wrap" <?php if ($row['project_customer_type'] == 2) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="project_client_name">Client Name</label>
                        <input type="text" name="project_client_name" id="project_client_name" <?php if ($row['project_customer_type'] == 2) echo 'disabled="disabled"'; ?> value="<?php echo form_value('project_client_name', $row); ?>" class="required" />
                        <?php echo form_error('project_client_name'); ?>
                    </p>
                    
                    <p id="project_company_name_wrap" <?php if ($row['project_customer_type'] == 1) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="project_company_name">Company Name</label>
                        <input type="text" name="project_company_name" id="project_company_name" <?php if ($row['project_customer_type'] == 1) echo 'disabled="disabled"'; ?> value="<?php echo form_value('project_company_name', $row); ?>" class="required" />
                        <?php echo form_error('project_company_name'); ?>
                    </p>
                </fieldset>
                <fieldset>
                	<legend>Terms of Payment (in %)</legend>
                    
                    <div>
	                    <button class="inside-form" id="add-project-top" type="button">Add</button>
	                    <button class="inside-form" id="del-project-top" type="button">Remove</button>
	                    <div class="clear"></div>
                    </div>
                    
                    <div id="temp-top" style="display:none;"></div>
                    
                    <div id="project-top-list">
                    
                    	<p>
                        <label class="label-input">Payment Type</label>
                        <span class="radio-options">
                            <input type="radio" name="project_top_type" value="1" id="type_percent" class="project_top_type required" />
                            <label class="radio" for="type_percent">Percent (%)</label>
                            <input type="radio" name="project_top_type" value="2" id="type_value" class="project_top_type" checked="checked" />
                            <label class="radio" for="type_value">Fixed Amount</label>
                            <span class="clear"></span>
                        </span>
                        <span class="clear"></span>
                        <label class="error initial" for="project_top_type"></label>
                        <?php echo form_error('project_top_type'); ?>
                    </p>
                    
                    	<?php $x = 0; ?>
                    	<?php $value = explode(',', $row['project_top_value']); ?>
                    	<?php for ($i = 1; $i <= $row['project_top']; $i++) : ?>
                        <div class="project-top">
                            <p>
                                <label class="label-input" for="project_top_<?php echo $i; ?>">Payment <?php echo $i; ?></label>
                                <input type="text" class="has-suffix number-format required" name="project_top[]" id="project_top_<?php echo $i; ?>" value="<?php echo $value[$x]; ?>" />
                                <span class="suffix" style="display:none;">%</span>
                                <span class="clear"></span>
                                <label class="error initial" for="project_top_<?php echo $i; ?>"></label>
                            </p>
                        </div>
                        <?php $x++; ?>
                        <?php endfor; ?>
                    </div>
                </fieldset>
                
                <?php $this->load->view('admin/template/view_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
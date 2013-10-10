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
            <h2><?php echo $title; ?></h2>
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
                        <input type="text" name="project_name" id="project_name" class="required" value="<?php echo set_value('project_name'); ?>" />
                        <?php echo form_error('project_name'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_product_id">Product Name</label>
                        <select name="project_product_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($product_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('project_product_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['product_code']; ?> <?php echo $item['product_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('project_product_id'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_sales_id">Sales</label>
                        <select name="project_sales_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($admin_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('projet_sales_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['admin_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('project_sales_id'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_price">Price</label>
                        <input type="text" name="project_price" id="project_price" class="number-format required" value="<?php echo set_value('project_price'); ?>" />
                        <?php echo form_error('project_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="project_markup">Mark-up</label>
                        <input type="text" name="project_markup" id="project_markup" class="number-format" value="<?php echo set_value('project_markup'); ?>" />
                        <?php echo form_error('project_markup'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_note">Note</label>
                        <textarea class="input" name="project_note" id="project_note"><?php echo set_value('project_note'); ?></textarea>
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
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('project_bank_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['bank_name']; ?> (<?php echo $item['bank_account_number']; ?> a/n <?php echo $item['bank_account_holder']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('project_bank_id'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="project_currency">Currency</label>
                        <select name="project_currency" class="required">
                            <option value="Rp." <?php if (set_value('project_currency') == 'Rp.') echo 'selected="selected"'; ?>>Rp.</option>
                            <option value="USD" <?php if (set_value('project_currency') == 'USD') echo 'selected="selected"'; ?>>USD</option>
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
                            <input type="radio" name="project_customer_type" value="1" id="type_client" class="project_customer_type required" <?php if (set_value('project_customer_type') == 1) echo 'checked="checked"'; ?> />
                            <label class="radio" for="type_client">Client</label>
                            <input type="radio" name="project_customer_type" value="2" id="type_company" class="project_customer_type" <?php if (set_value('project_customer_type') == 2) echo 'checked="checked"'; ?> />
                            <label class="radio" for="type_company">Company</label>
                            <span class="clear"></span>
                        </span>
                        <span class="clear"></span>
                        <label class="error initial" for="project_customer_type"></label>
                        <?php echo form_error('project_customer_type'); ?>
                    </p>

                    <p id="project_client_name_wrap" <?php if (set_value('project_customer_type') == 2 || empty(set_value('dhm_customer_type'))) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="project_client_name">Client Name</label>
                        <input type="text" name="project_client_name" id="project_client_name" <?php if (set_value('project_customer_type') == 2 || empty(set_value('project_customer_type'))) echo 'disabled="disabled"'; ?> value="<?php echo set_value('project_client_name'); ?>" class="required" />
                        <?php echo form_error('project_client_name'); ?>
                    </p>
                    
                    <p id="project_company_name_wrap" <?php if (set_value('project_customer_type') == 1 || empty(set_value('project_customer_type'))) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="project_company_name">Company Name</label>
                        <input type="text" name="project_company_name" id="project_company_name" <?php if (set_value('project_customer_type') == 2 || empty(set_value('project_customer_type'))) echo 'disabled="disabled"'; ?> value="<?php echo set_value('project_company_name'); ?>" class="required" />
                        <?php echo form_error('project_company_name'); ?>
                    </p>
                </fieldset>
                <fieldset>
                	<legend>Terms of Payment</legend>

                    <div id="temp-top" style="display:none;"></div>
                    
                    <div>
	                    <button class="inside-form" id="add-project-top" type="button">Add</button>
	                    <button class="inside-form" id="del-project-top" type="button">Remove</button>
	                    <div class="clear"></div>
                    </div>
                    
                    <p>
                        <label class="label-input">Payment Type</label>
                        <span class="radio-options">
                            <input type="radio" name="project_top_type" value="1" id="type_percent" class="project_top_type required" <?php if (set_value('project_top_type') == 1 || empty(set_value('project_top_type'))) echo 'checked="checked"'; ?> />
                            <label class="radio" for="type_percent">Percent (%)</label>
                            <input type="radio" name="project_top_type" value="2" id="type_value" class="project_top_type" <?php if (set_value('project_top_type') == 2) echo 'checked="checked"'; ?> />
                            <label class="radio" for="type_value">Fixed Amount</label>
                            <span class="clear"></span>
                        </span>
                        <span class="clear"></span>
                        <label class="error initial" for="project_top_type"></label>
                        <?php echo form_error('project_top_type'); ?>
                    </p>
                    
                    <div id="project-top-list">
                    	<p id="project-top-error"></p>
                        <div class="project-top">
                            <p>
                                <label class="label-input" for="project_top_1">Payment 1</label>
                                <input type="text" class="has-suffix required number-format" name="project_top[]" id="project_top_1" value="30" />
                                <span class="suffix">%</span>
                                <span class="clear"></span>
                            </p>
                        </div>
                        <div class="project-top">
                            <p>
                                <label class="label-input" for="project_top_2">Payment 2</label>
                                <input type="text" class="has-suffix required number-format" name="project_top[]" id="project_top_2" value="40" />
                                <span class="suffix">%</span>
                                <span class="clear"></span>
                            </p>
                        </div>
                        <div class="project-top">
                            <p>
                                <label class="label-input" for="project_top_3">Payment 3</label>
                                <input type="text" class="has-suffix required number-format" name="project_top[]" id="project_top_3" value="30" />
                                <span class="suffix">%</span>
                                <span class="clear"></span>
                            </p>
                        </div>
                    </div>
                </fieldset>
                
                <?php $this->load->view('admin/template/add_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
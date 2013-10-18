<script type="text/javascript">
$(document).ready(function(){	
	<?php if ($company_list) : ?>
	$('#dhm_company_name').autocomplete({
		source: <?php echo $company_list; ?>
	});
	<?php endif; ?>
	
	<?php if ($client_list) : ?>
	$('#dhm_client_name').autocomplete({
		source: <?php echo $client_list; ?>
	});
	<?php endif; ?>
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
                        <label class="label-input" for="dhm_name">http://www.</label>
                        <input type="text" name="dhm_name" id="dhm_name" class="required" value="<?php echo set_value('dhm_name'); ?>" />
                        <?php echo form_error('dhm_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_start">Start Date</label>
                        <input type="text" name="dhm_start" id="dhm_start" class="datepicker required" value="<?php echo set_value('dhm_start'); ?>" />
                        <?php echo form_error('dhm_start'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_period">Period</label>
                        <select name="dhm_period" class="required">
                        	<option value="12" <?php if (set_value('dhm_period') == 12) echo 'selected="selected"'; ?>>12 months</option>
                            <option value="24" <?php if (set_value('dhm_period') == 24) echo 'selected="selected"'; ?>>24 months</option>
                            <option value="36" <?php if (set_value('dhm_period') == 36) echo 'selected="selected"'; ?>>36 months</option>
                            <option value="48" <?php if (set_value('dhm_period') == 48) echo 'selected="selected"'; ?>>48 months</option>
                            <option value="60" <?php if (set_value('dhm_period') == 60) echo 'selected="selected"'; ?>>60 months</option>
                        </select>
                        <?php echo form_error('dhm_period'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_price">Price / year</label>
                        <input type="text" name="dhm_price" id="dhm_price" class="number-format required" value="<?php echo set_value('dhm_price'); ?>" />
                        <?php echo form_error('dhm_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_markup">Mark-up</label>
                        <input type="text" name="dhm_markup" id="dhm_markup" class="number-format" value="<?php echo set_value('dhm_markup'); ?>" />
                        <?php echo form_error('dhm_markup'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <fieldset>
                	<legend>Details</legend>
                    
                    <p>
                    	<label class="label-input">Type</label>
                        <span class="radio-options">
                            <input type="radio" name="dhm_customer_type" value="1" id="type_client" class="dhm_customer_type required" <?php if (set_value('dhm_customer_type') == 1) echo 'checked="checked"'; ?> />
                            <label class="radio" for="type_client">Client</label>
                            <input type="radio" name="dhm_customer_type" value="2" id="type_company" class="dhm_customer_type" <?php if (set_value('dhm_customer_type') == 2) echo 'checked="checked"'; ?> />
                            <label class="radio" for="type_company">Company</label>
	                        <span class="clear"></span>
                        </span>
						<span class="clear"></span>
                        <label class="error initial" for="dhm_customer_type"></label>
                        <?php echo form_error('dhm_customer_type'); ?>
                    </p>

					<?php $set_value_customer_type = set_value('dhm_customer_type'); ?>
                    <p id="dhm_client_name_wrap" <?php if (set_value('dhm_customer_type') == 2 || empty($set_value_customer_type)) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="dhm_client_name">Client Name</label>
                        <input type="text" name="dhm_client_name" id="dhm_client_name" <?php if (set_value('dhm_customer_type') == 2 || empty($set_value_customer_type)) echo 'disabled="disabled"'; ?> value="<?php echo set_value('dhm_client_name'); ?>" class="required" />
                        <?php echo form_error('dhm_client_name'); ?>
                    </p>
                    
                    <p id="dhm_company_name_wrap" <?php if (set_value('dhm_customer_type') == 1 || empty($set_value_customer_type)) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="dhm_company_name">Company Name</label>
                        <input type="text" name="dhm_company_name" id="dhm_company_name" <?php if (set_value('dhm_customer_type') == 2 || empty($set_value_customer_type)) echo 'disabled="disabled"'; ?> value="<?php echo set_value('dhm_company_name'); ?>" class="required" />
                        <?php echo form_error('dhm_company_name'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="dhm_domain_id">Domain</label>
                        <select name="dhm_domain_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($domain_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('dhm_domain_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['domain_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_domain_id'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_hosting_id">Hosting</label>
                        <select name="dhm_hosting_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($hosting_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('dhm_hosting_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['hosting_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_hosting_id'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_bank_id">Bank</label>
                        <select name="dhm_bank_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('dhm_bank_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['bank_name']; ?> (<?php echo $item['bank_account_number']; ?> a/n <?php echo $item['bank_account_holder']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_bank_id'); ?>
                    </p>
                </fieldset>
                
                <?php $this->load->view('admin/template/add_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
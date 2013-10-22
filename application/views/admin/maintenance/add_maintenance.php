<script type="text/javascript">
$(document).ready(function(){	
	<?php if ($company_list) : ?>
	$('#maintenance_company_name').autocomplete({
		source: <?php echo $company_list; ?>
	});
	<?php endif; ?>
	
	<?php if ($client_list) : ?>
	$('#maintenance_client_name').autocomplete({
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
                        <label class="label-input" for="maintenance_name">Name</label>
                        <input type="text" name="maintenance_name" id="maintenance_name" class="required" value="<?php echo set_value('maintenance_name'); ?>" />
                        <?php echo form_error('maintenance_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_start">Start Date</label>
                        <input type="text" name="maintenance_start" id="maintenance_start" class="datepicker required" value="<?php echo set_value('maintenance_start'); ?>" />
                        <?php echo form_error('maintenance_start'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_period">Period</label>
                        <input type="text" name="maintenance_period" id="maintenance_period" class="has-suffix digits required" title="Number of months" value="<?php echo set_value('maintenance_period'); ?>" />
                        <span class="suffix">Months</span>
                        <?php echo form_error('maintenance_period'); ?>
                        <span class="clear"></span>
                        <label class="error initial" for="maintenance_period"></label>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_price">Price</label>
                        <input type="text" name="maintenance_price" id="maintenance_price" class="number-format required" value="<?php echo set_value('maintenance_price'); ?>" />
                        <?php echo form_error('maintenance_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_markup">Mark-up</label>
                        <input type="text" name="maintenance_markup" id="maintenance_markup" class="number-format" value="<?php echo set_value('maintenance'); ?>" />
                        <?php echo form_error('maintenance'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <fieldset>
                	<legend>Details</legend>
                    
                    <p>
                    	<label class="label-input">Type</label>
                        <span class="radio-options">
                            <input type="radio" name="maintenance_customer_type" value="1" id="type_client" class="maintenance_customer_type required" />
                            <label class="radio" for="type_client">Client</label>
                            <input type="radio" name="maintenance_customer_type" value="2" id="type_company" class="maintenance_customer_type" />
                            <label class="radio" for="type_company">Company</label>
	                        <span class="clear"></span>
                        </span>
						<span class="clear"></span>
                        <label class="error initial" for="maintenance_customer_type"></label>
                        <?php echo form_error('maintenance_customer_type'); ?>
                    </p>
                    
                    <p id="maintenance_client_name_wrap" class="hidden">
                        <label class="label-input" for="maintenance_client_name">Client Name</label>
                        <input type="text" name="maintenance_client_name" id="maintenance_client_name" disabled="disabled" value="<?php echo set_value('maintenance_client_name'); ?>" class="required" />
                        <?php echo form_error('maintenance_client_name'); ?>
                    </p>
                    
                    <p id="maintenance_company_name_wrap" class="hidden">
                        <label class="label-input" for="maintenance_company_name">Company Name</label>
                        <input type="text" name="maintenance_company_name" id="maintenance_company_name" disabled="disabled" value="<?php echo set_value('maintenance_company_name'); ?>" class="required" />
                        <?php echo form_error('maintenance_company_name'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="maintenance_bank_id">Bank</label>
                        <select name="maintenance_bank_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('maintenance_bank_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['bank_name']; ?> (<?php echo $item['bank_account_number']; ?> a/n <?php echo $item['bank_account_holder']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('maintenance_bank_id'); ?>
                    </p>
                </fieldset>
                
                <?php $this->load->view('admin/template/add_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
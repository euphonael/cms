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
            <h2><?php echo $title; ?> : <?php echo $row['maintenance_name']; ?></h2>
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
                        <input type="text" name="maintenance_name" id="maintenance_name" class="required" value="<?php echo form_value('maintenance_name', $row); ?>" />
                        <?php echo form_error('maintenance_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_start">Start Date</label>
                        <input type="text" name="maintenance_start" id="maintenance_start" class="datepicker required" value="<?php echo form_value('maintenance_start', $row); ?>" />
                        <?php echo form_error('maintenance_start'); ?>
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
                    	<label class="label-input">Extend Counter</label>
                        <input type="text" readonly="readonly" value="<?php echo $row['maintenance_extend_counter']; ?>" />
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <fieldset>
                	<legend>Details</legend>
                    
                    <p>
                    	<label class="label-input">Type</label>
                        <span class="radio-options">
                            <input type="radio" name="maintenance_customer_type" value="1" id="type_client" class="maintenance_customer_type required" <?php default_checked('maintenance_customer_type', $row, 1); ?> />
                            <label class="radio" for="type_client">Client</label>
                            <input type="radio" name="maintenance_customer_type" value="2" id="type_company" class="maintenance_customer_type" <?php default_checked('maintenance_customer_type', $row, 2); ?> />
                            <label class="radio" for="type_company">Company</label>
	                        <span class="clear"></span>
                        </span>
						<span class="clear"></span>
                        <label class="error initial" for="maintenance_customer_type"></label>
                        <?php echo form_error('maintenance_customer_type'); ?>
                    </p>
                    
                    <p id="maintenance_client_name_wrap" <?php if ($row['maintenance_customer_type'] == 2) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="maintenance_client_name">Client Name</label>
                        <input type="text" name="maintenance_client_name" id="maintenance_client_name" <?php if ($row['maintenance_customer_type'] == 2) echo 'disabled="disabled"'; ?> value="<?php echo form_value('maintenance_client_name', $row); ?>" class="required" />
                        <?php echo form_error('maintenance_client_name'); ?>
                    </p>
                    
                    <p id="maintenance_company_name_wrap" <?php if ($row['maintenance_customer_type'] == 1) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="maintenance_company_name">Company Name</label>
                        <input type="text" name="maintenance_company_name" id="maintenance_company_name" <?php if ($row['maintenance_customer_type'] == 1) echo 'disabled="disabled"'; ?> value="<?php echo form_value('maintenance_company_name', $row); ?>" class="required" />
                        <?php echo form_error('maintenance_company_name'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="maintenance_bank_id">Bank</label>
                        <select name="maintenance_bank_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('maintenance_bank_id', $row, $item['unique_id']); ?>><?php echo $item['bank_name']; ?> (<?php echo $item['bank_account_number']; ?> a/n <?php echo $item['bank_account_holder']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('maintenance_bank_id'); ?>
                    </p>
                </fieldset>
                
                <?php $this->load->view('admin/template/view_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
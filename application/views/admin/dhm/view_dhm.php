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
            <h2><?php echo $title; ?> : <?php echo $row['dhm_name']; ?></h2>
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
                        <label class="label-input" for="dhm_name">Name</label>
                        <input type="text" name="dhm_name" id="dhm_name" class="required" value="<?php echo form_value('dhm_name', $row); ?>" />
                        <?php echo form_error('dhm_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_start">Start Date</label>
                        <input type="text" name="dhm_start" id="dhm_start" class="datepicker required" value="<?php echo form_value('dhm_start', $row); ?>" />
                        <?php echo form_error('dhm_start'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_period">Period</label>
                        <select name="dhm_period" class="required">
                        	<option value="12" <?php default_selected('dhm_period', $row, 12); ?>>12 months</option>
                            <option value="24" <?php default_selected('dhm_period', $row, 24); ?>>24 months</option>
                            <option value="36" <?php default_selected('dhm_period', $row, 36); ?>>36 months</option>
                            <option value="48" <?php default_selected('dhm_period', $row, 48); ?>>48 months</option>
                            <option value="60" <?php default_selected('dhm_period', $row, 60); ?>>60 months</option>
                        </select>
                        <?php echo form_error('dhm_period'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_price">Price / year</label>
                        <input type="text" name="dhm_price" id="dhm_price" class="number-format required" value="<?php echo form_value('dhm_price', $row); ?>" />
                        <?php echo form_error('dhm_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_markup">Mark-up</label>
                        <input type="text" name="dhm_markup" id="dhm_markup" class="number-format" value="<?php echo form_value('dhm_markup', $row); ?>" />
                        <?php echo form_error('dhm_markup'); ?>
                    </p>
                    <p>
                    	<label class="label-input">Extend Counter</label>
                        <input type="text" readonly="readonly" value="<?php echo $row['dhm_extend_counter']; ?>" />
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <fieldset>
                	<legend>Details</legend>
                    
                    <p>
                    	<label class="label-input">Type</label>
                        <span class="radio-options">
                            <input type="radio" name="dhm_customer_type" value="1" id="type_client" class="dhm_customer_type required" <?php default_checked('dhm_customer_type', $row, 1); ?> />
                            <label class="radio" for="type_client">Client</label>
                            <input type="radio" name="dhm_customer_type" value="2" id="type_company" class="dhm_customer_type" <?php default_checked('dhm_customer_type', $row, 2); ?> />
                            <label class="radio" for="type_company">Company</label>
	                        <span class="clear"></span>
                        </span>
						<span class="clear"></span>
                        <label class="error initial" for="dhm_customer_type"></label>
                        <?php echo form_error('dhm_customer_type'); ?>
                    </p>

                    <p id="dhm_client_name_wrap" <?php if ($row['dhm_customer_type'] == 2) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="dhm_client_name">Client Name</label>
                        <input type="text" name="dhm_client_name" id="dhm_client_name" <?php if ($row['dhm_customer_type'] == 2) echo 'disabled="disabled"'; ?> value="<?php echo form_value('dhm_client_name', $row); ?>" class="required" />
                        <?php echo form_error('dhm_client_name'); ?>
                    </p>
                    
                    <p id="dhm_company_name_wrap" <?php if ($row['dhm_customer_type'] == 1) echo 'class="hidden"'; ?>>
                        <label class="label-input" for="dhm_company_name">Company Name</label>
                        <input type="text" name="dhm_company_name" id="dhm_company_name" <?php if ($row['dhm_customer_type'] == 1) echo 'disabled="disabled"'; ?> value="<?php echo form_value('dhm_company_name', $row); ?>" class="required" />
                        <?php echo form_error('dhm_company_name'); ?>
                    </p>
                    
                    <p>
                        <label class="label-input" for="dhm_domain_id">Domain</label>
                        <select name="dhm_domain_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($domain_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('dhm_domain_id', $row, $item['unique_id']); ?>><?php echo $item['domain_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_domain_id'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_hosting_id">Hosting</label>
                        <select name="dhm_hosting_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($hosting_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('dhm_hosting_id', $row, $item['unique_id']); ?>><?php echo $item['hosting_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_hosting_id'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_bank_id">Bank</label>
                        <select name="dhm_bank_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('dhm_bank_id', $row, $item['unique_id']); ?>><?php echo $item['bank_name']; ?> (<?php echo $item['bank_account_number']; ?> a/n <?php echo $item['bank_account_holder']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_bank_id'); ?>
                    </p>
                </fieldset>
                
                <?php $this->load->view('admin/template/view_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
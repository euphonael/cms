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
                        <input type="text" name="dhm_period" id="dhm_period" class="digits required" title="Number of months" value="<?php echo form_value('dhm_period', $row); ?>" />
                        <?php echo form_error('dhm_period'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_price">Price</label>
                        <input type="text" name="dhm_price" id="dhm_price" class="digits required" value="<?php echo form_value('dhm_price', $row); ?>" />
                        <?php echo form_error('dhm_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_extend">Extend</label>
                        <input type="text" name="dhm_extend" id="dhm_extend" class="digits" value="<?php echo form_value('dhm_extend', $row); ?>" />
                        <?php echo form_error('dhm_extend'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <fieldset>
                	<legend>Details</legend>
                    <p>
                        <label class="label-input" for="dhm_company_id">Company</label>
                        <select name="dhm_company_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($company_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if ($row['dhm_company_id'] == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['company_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('hosting_root_domain'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_domain_id">Domain</label>
                        <select name="dhm_domain_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($domain_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if ($row['dhm_domain_id'] == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['domain_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_domain_id'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_hosting_id">Hosting</label>
                        <select name="dhm_hosting_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($hosting_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if ($row['dhm_hosting_id'] == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['hosting_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('dhm_hosting_id'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="dhm_bank_id">Bank</label>
                        <select name="dhm_bank_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if ($row['dhm_bank_id'] == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['bank_name']; ?></option>
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
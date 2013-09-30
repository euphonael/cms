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
                        <input type="text" name="maintenance_period" id="maintenance_period" class="digits required" title="Number of months" value="<?php echo form_value('maintenance_period', $row); ?>" />
                        <?php echo form_error('maintenance_period'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_price">Price</label>
                        <input type="text" name="maintenance_price" id="maintenance_price" class="digits required" value="<?php echo form_value('maintenance_price', $row); ?>" />
                        <?php echo form_error('maintenance_price'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_extend">Extend</label>
                        <input type="text" name="maintenance_extend" id="maintenance_extend" class="digits" value="<?php echo form_value('maintenance_extend', $row); ?>" />
                        <?php echo form_error('maintenance_extend'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <fieldset>
                	<legend>Details</legend>
                    <p>
                        <label class="label-input" for="maintenance_company_id">Company</label>
                        <select name="maintenance_company_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($company_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('maintenance_company_id', $row, $item['unique_id']); ?>><?php echo $item['company_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('hosting_root_domain'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="maintenance_bank_id">Bank</label>
                        <select name="maintenance_bank_id" class="required">
                        	<option value="">--</option>
                            <?php foreach ($bank_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('maintenance_bank_id', $row, $item['unique_id']); ?>><?php echo $item['bank_name']; ?></option>
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
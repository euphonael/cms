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
                    <legend>Client Info</legend>
                    <p>
                        <label class="label-input" for="client_name">Client Name</label>
                        <input type="text" name="client_name" id="client_name" class="required" value="<?php echo set_value('client_name'); ?>" />
                        <?php echo form_error('client_name'); ?>
                    </p>
                    <p>
                    	<label class="label-input">Company Name</label>
                        <select name="client_company_id">
                        	<option value="">--</option>
                            <?php foreach ($company_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('client_company_id') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['company_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label class="label-input" for="client_address">Address</label>
                        <textarea class="input" name="client_address" id="client_address"><?php echo set_value('client_address'); ?></textarea>
                        <?php echo form_error('client_address'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="client_country">Country</label>
                        <input type="text" name="client_country" id="client_country" value="<?php echo set_value('client_country'); ?>" />
                        <?php echo form_error('client_country'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="client_city">City</label>
                        <input type="text" name="client_city" id="client_city" value="<?php echo set_value('client_city'); ?>" />
                        <?php echo form_error('client_city'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="client_postal_code">Postal Code</label>
                        <input type="text" name="client_postal_code" id="client_postal_code" class="digits" value="<?php echo set_value('client_postal_code'); ?>" />
                        <?php echo form_error('client_postal_code'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">                
                <fieldset>
                	<legend>Contact Info</legend>
                    <p>
                        <label class="label-input" for="client_phone">Phone</label>
                        <input type="text" name="client_phone" id="client_phone" value="<?php echo set_value('client_phone'); ?>" />
                        <?php echo form_error('client_phone'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="client_mobile">Mobile</label>
                        <input type="text" name="client_mobile" id="client_mobile" value="<?php echo set_value('client_mobile'); ?>" />
                        <?php echo form_error('client_mobile'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="client_fax">Fax</label>
                        <input type="text" name="client_fax" id="client_fax" value="<?php echo set_value('client_fax'); ?>" />
                        <?php echo form_error('client_fax'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="client_email">E-mail</label>
                        <input type="text" name="client_email" id="client_email" class="email" value="<?php echo set_value('client_email'); ?>" />
                        <?php echo form_error('client_email'); ?>
                    </p>
                </fieldset>
                
                <?php $this->load->view('admin/template/add_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
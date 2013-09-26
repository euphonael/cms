<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $row['company_name']; ?></h2>
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
                    <legend>Company Info</legend>
                    <p>
                        <label class="label-input" for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="required" value="<?php echo form_value('company_name', $row); ?>" />
                        <?php echo form_error('company_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="company_address">Address</label>
                        <textarea class="input" name="company_address" id="company_address"><?php echo form_value('company_address', $row); ?></textarea>
                        <?php echo form_error('company_address'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="company_country">Country</label>
                        <input type="text" name="company_country" id="company_country" value="<?php echo form_value('company_country', $row); ?>" />
                        <?php echo form_error('company_country'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="company_city">City</label>
                        <input type="text" name="company_city" id="company_city" value="<?php echo form_value('company_city', $row); ?>" />
                        <?php echo form_error('company_city'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="company_postal_code">Postal Code</label>
                        <input type="text" name="company_postal_code" id="company_postal_code" class="digits" value="<?php echo form_value('company_postal_code', $row); ?>" />
                        <?php echo form_error('company_postal_code'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">                
                <fieldset>
                	<legend>Contact Info</legend>
                    <p>
                        <label class="label-input" for="company_phone">Phone</label>
                        <input type="text" name="company_phone" id="company_phone" value="<?php echo form_value('company_phone', $row); ?>" />
                        <?php echo form_error('company_phone'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="company_mobile">Mobile</label>
                        <input type="text" name="company_mobile" id="company_mobile" value="<?php echo form_value('company_mobile', $row); ?>" />
                        <?php echo form_error('company_mobile'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="company_fax">Fax</label>
                        <input type="text" name="company_fax" id="company_fax" value="<?php echo form_value('company_fax', $row); ?>" />
                        <?php echo form_error('company_fax'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="company_email">E-mail</label>
                        <input type="text" name="company_email" id="company_email" class="email" value="<?php echo form_value('company_email', $row); ?>" />
                        <?php echo form_error('company_email'); ?>
                    </p>
                </fieldset>
                
                <?php $this->load->view('admin/template/view_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
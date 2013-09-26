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
                    <legend>Hosting Info</legend>
                    <p>
                        <label class="label-input" for="hosting_name">Hosting Name</label>
                        <input type="text" name="hosting_name" id="hosting_name" class="required" value="<?php echo set_value('hosting_name'); ?>" />
                        <?php echo form_error('hosting_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="hosting_root_domain">Root Domain</label>
                        <input type="text" name="hosting_root_domain" id="hosting_root_domain" class="required" value="<?php echo set_value('hosting_root_domain'); ?>" />
                        <?php echo form_error('hosting_root_domain'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="hosting_expiry">Expiry Date</label>
                        <input type="text" name="hosting_expiry" id="hosting_expiry" class="datepicker required" value="<?php echo set_value('hosting_expiry'); ?>" />
                        <?php echo form_error('hosting_expiry'); ?>
                    </p>
                </fieldset>
                
                <fieldset>
                	<legend>cPanel Info</legend>
                    <p>
                        <label class="label-input" for="hosting_cpanel_url">URL</label>
                        <input type="text" name="hosting_cpanel_url" id="hosting_cpanel_url" class="required" value="<?php echo set_value('hosting_cpanel_url'); ?>" />
                        <?php echo form_error('hosting_cpanel_url'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="hosting_cpanel_username">Username</label>
                        <input type="text" name="hosting_cpanel_username" id="hosting_cpanel_username" class="required" value="<?php echo set_value('hosting_cpanel_username'); ?>" />
                        <?php echo form_error('hosting_cpanel_username'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="hosting_cpanel_password">Password</label>
                        <input type="text" name="hosting_cpanel_password" id="hosting_cpanel_password" value="<?php echo set_value('hosting_cpanel_password'); ?>" />
                        <?php echo form_error('hosting_cpanel_password'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
            	<fieldset>
                	<legend>Specifications</legend>
                    <p>
                        <label class="label-input" for="hosting_disk_space">Disk Space</label>
                        <input type="text" name="hosting_disk_space" id="hosting_disk_space" title="Disk space in MB" class="required digits" value="<?php echo set_value('hosting_disk_space'); ?>" />
                        <?php echo form_error('hosting_disk_space'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="hosting_subdomain">Subdomain</label>
                        <input type="text" name="hosting_subdomain" id="hosting_subdomain" title="Number of subdomains allowed" class="required digits" value="<?php echo set_value('hosting_subdomain'); ?>" />
                        <?php echo form_error('hosting_subdomain'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="hosting_addon_domain">Add-on Domain</label>
                        <input type="text" name="hosting_addon_domain" id="hosting_addon_domain" title="Number of add-on domains allowed" class="required digits" value="<?php echo set_value('hosting_addon_domain'); ?>" />
                        <?php echo form_error('hosting_addon_domain'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="hosting_mysql_db">MySQL Database</label>
                        <input type="text" name="hosting_mysql_db" id="hosting_mysql_db" title="Number of MySQL database allowed" class="required digits" value="<?php echo set_value('hosting_mysql_db'); ?>" />
                        <?php echo form_error('hosting_mysql_db'); ?>
                    </p>
                </fieldset>
                <?php $this->load->view('admin/template/add_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
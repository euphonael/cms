<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $row['domain_name']; ?></h2>
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
                    <legend>Domain Info</legend>
                    <p>
                        <label class="label-input" for="domain_name">Domain Name</label>
                        <input type="text" name="domain_name" id="domain_name" class="required" value="<?php echo form_value('domain_name', $row); ?>" />
                        <?php echo form_error('domain_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="domain_location">Domain Location</label>
                        <input type="text" name="domain_location" id="domain_location" class="required" value="<?php echo form_value('domain_location', $row); ?>" />
                        <?php echo form_error('domain_location'); ?>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <?php $this->load->view('admin/template/view_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
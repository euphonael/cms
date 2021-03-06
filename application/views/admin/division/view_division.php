<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $row['division_name']; ?></h2>
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
                        <label class="label-input" for="division_name">Division Name</label>
                        <input type="text" name="division_name" id="division_name" class="required" value="<?php echo form_value('division_name', $row); ?>" />
                        <?php echo form_error('division_name'); ?>
                    </p>
                    <p>
                        <label class="label-input">Person-in-Charge</label>
                        <select name="division_head" class="required">
                        	<option value="">--</option>
                            <?php foreach ($admin_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php default_selected('division_head', $row, $item['unique_id']); ?>><?php echo $item['admin_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('division_head'); ?>
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
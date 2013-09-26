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
                    <legend>Module Info</legend>
                    <p>
                        <label class="label-input" for="module_name">Module Name</label>
                        <input type="text" name="module_name" id="module_name" class="required" value="<?php echo set_value('module_name'); ?>" />
                        <?php echo form_error('module_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="module_url">Module URL</label>
                        <input type="text" name="module_url" id="module_url" class="required" value="<?php echo set_value('module_url'); ?>" />
                        <?php echo form_error('module_url'); ?>
                    </p>
                    <p>
                        <label class="label-input">Module Parent</label>
                        <select name="module_parent" class="required">
                        	<option value="">--</option>
                        	<option value="0" <?php if (set_value('module_parent') == '0') echo 'selected="selected"'; ?>>(Parent module)</option>
                            <?php foreach ($module_list as $item) : ?>
                            <option value="<?php echo $item['unique_id']; ?>" <?php if (set_value('module_parent') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['module_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('module_parent'); ?>
                    </p>
                    <p>
                    	<label class="label-input" for="module_notes">Module Notes</label>
                        <textarea class="input" name="module_notes" id="module_notes"><?php echo set_value('module_notes'); ?></textarea>
                        <?php echo form_error('module_notes'); ?>
                    </p>
                    <p>
                    	<label class="label-input" for="module_multi_language">Allow multi language</label>
                        <input type="checkbox" name="module_multi_language" id="module_multi_language" value="1" <?php if (set_value('module_multi_language') == 1) echo 'checked="checked"'; ?> />
                        <span class="clear"></span>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <?php $this->load->view('admin/template/add_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
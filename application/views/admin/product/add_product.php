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
                    <legend>Product Info</legend>
                    <p>
                        <label class="label-input" for="product_name">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="required" value="<?php echo set_value('product_name'); ?>" />
                        <?php echo form_error('product_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="product_code">Product Code</label>
                        <input type="text" name="product_code" id="product_code" class="required" value="<?php echo set_value('product_code'); ?>" />
                        <?php echo form_error('product_code'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="product_description">Product Description</label>
                        <textarea class="input" name="product_description" id="product_description"><?php echo set_value('product_description'); ?></textarea>
                        <?php echo form_error('product_description'); ?>
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
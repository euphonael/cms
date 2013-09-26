<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?>: <?php echo $row['bank_name']; ?></h2>
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
                    <legend>Bank Info</legend>
                    <p>
                        <label class="label-input" for="bank_name">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" class="required" value="<?php echo form_value('bank_name', $row); ?>" />
                        <?php echo form_error('bank_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="bank_branch">Branch</label>
                        <input type="text" name="bank_branch" id="bank_branch" class="required" value="<?php echo form_value('bank_branch', $row); ?>" />
                        <?php echo form_error('bank_branch'); ?>
                    </p>
                </fieldset>
                
                <fieldset>
                	<legend>Account Info</legend>
                    <p>
                        <label class="label-input" for="bank_account_holder">Account Holder</label>
                        <input type="text" name="bank_account_holder" id="bank_account_holder" class="required" value="<?php echo form_value('bank_account_holder', $row); ?>" />
                        <?php echo form_error('bank_account_holder'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="bank_account_number">Account Number</label>
                        <input type="text" name="bank_account_number" id="bank_account_number" class="required" value="<?php echo form_value('bank_account_number', $row); ?>" />
                        <?php echo form_error('bank_account_number'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="bank_swift_code">SWIFT Code</label>
                        <input type="text" name="bank_swift_code" id="bank_swift_code" value="<?php echo form_value('bank_swift_code', $row); ?>" />
                        <?php echo form_error('bank_swift_code'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="bank_currency">Currency</label>
                        <select name="bank_currency" class="required">
                        	<option value="">--</option>
                            <option value="Rp." <?php default_selected('bank_currency', $row, 'Rp.'); ?>>Rp.</option>
                            <option value="USD" <?php default_selected('bank_currency', $row, 'USD'); ?>>USD</option>
                        </select>
                        <?php echo form_error('bank_currency'); ?>
                    </p>       
                    <p>
                        <label class="label-input" for="bank_invoice_type">Invoice Type</label>
                        <select name="bank_invoice_type" class="required">
                        	<option value="">--</option>
                            <option value="1" <?php default_selected('bank_invoice_type', $row, 1); ?>>Wilson Iwan</option>
                            <option value="2" <?php default_selected('bank_invoice_type', $row, 2); ?>>PT. Go Online Solusi</option>
                        </select>
                        <?php echo form_error('bank_currency'); ?>
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
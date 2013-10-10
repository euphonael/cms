<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $row['invoice_number']; ?></h2>
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
                    	<label class="label-input">Created On</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo date('d M Y', strtotime($row['invoice_create_date'])); ?>" />
                    </p>
                    
                    <p>
                        <label class="label-input">Customer Name</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo $row['invoice_customer_name']; ?>" />
                    </p>
                    
                    <p>
                        <label class="label-input">Product</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo $row['product_code'] . ' ' . $row['product_name']; ?>" />
                    </p>
                    
                    <p>
                        <label class="label-input">Project Name</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo $row['invoice_project_name']; ?>" />
                    </p>
                    
                    <p>
                        <label class="label-input">Price</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo number_format($row['invoice_price']); ?>" />
                    </p>
                    <p>
                        <label class="label-input">Mark-up</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo number_format($row['invoice_markup']); ?>" />
                    </p>
                    
                    <p>
                        <label class="label-input">Note</label>
                        <textarea class="input readonly" readonly="readonly"><?php echo $row['invoice_note']; ?></textarea>
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                
                <fieldset>
                	<legend>Payment <?php echo $row['invoice_top_number']; ?> of <?php echo $row['invoice_top']; ?></legend>
                    <p>
                        <label class="label-input">Bank</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo $row['bank_name']; ?> (<?php echo $row['bank_account_number']; ?> a/n <?php echo $row['bank_account_holder']; ?>)" />
                    </p>
                    
                    <p>
                        <label class="label-input">Currency</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo $row['invoice_currency']; ?>" />
                    </p>
                    <p>
                    	<label class="label-input">Amount</label>
                        <input type="text" class="readonly" readonly="readonly" value="<?php echo number_format($row['invoice_top_amount']); ?>" />
                    </p>
                </fieldset>
                <?php $this->load->view('admin/template/view_flag'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
        
    
	<div id="content-heading">
    	<h2>Log</h2>
        <div id="action-wrapper">
            <button class="delete" id="delete-invoice" title="Delete selected items"><img src="<?php echo base_url('images/icon-delete.png'); ?>" /></button>
            <div class="clear"></div>
        </div>
        
        <div class="clear"></div>
    </div>
    
</div>
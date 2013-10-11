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
    
	<table id="invoice_log" class="table-data" cellpadding="0" cellspacing="0">
    	<thead>
        	<tr>
            	<th class="small">No.</th>
                <th class="long">Date / Time</th>
                <th class="long">Admin</th>
                <th class="medium">IP Address</th>
                <th class="note">Note</th>
            </tr>
        </thead>
        <tbody>
        	<?php $x = 1; ?>
        	<?php foreach ($log as $item) : ?>
        	<tr>
            	<td><?php echo $x; ?></td>
                <td><?php echo date('d M Y H:i', strtotime($item['invoice_log_datetime'])); ?></td>
                <td><?php echo $item['admin_name']; ?></td>
                <td><?php echo $item['invoice_log_admin_ip']; ?></td>
                <td><?php echo $item['invoice_log_description']; ?></td>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
            <tr id="add-new">
            	<td><?php echo $x; ?></td>
                <td class="date"><?php echo date('d M Y H:i'); ?></td>
                <td><?php echo $this->session->userdata('admin_name'); ?></td>
                <td><?php echo $this->input->ip_address(); ?></td>
                <td class="note"><input type="text" name="<?php echo $row['unique_id']; ?>" id="invoice_log_description" /></td>
            </tr>
        </tbody>
    </table>
</div>
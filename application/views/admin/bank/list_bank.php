<div id="container">
	<div id="content-heading">
    	<h2><?php echo $title; ?></h2>
        <div id="action-wrapper">
            <a class="button" href="<?php echo base_url('admin/' . $this->url . '/add'); ?>">New <?php echo $this->title; ?></a>
            <button class="delete" id="delete-<?php echo $this->db_table; ?>" title="Delete selected items"><img src="<?php echo base_url('images/icon-delete.png'); ?>" /></button>
            <div class="clear"></div>
        </div>
        
        <div class="clear"></div>
    </div>
    
    <table id="<?php echo $this->db_table; ?>" class="table-data" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="small">No.</th>
                <th>Bank Name</th>
                <th>Branch</th>
                <th>Account Holder</th>
                <th>Account Number</th>
                <th>Currency</th>
                <th>Invoice Type</th>
                <th>Swift Code</th>
                <th class="medium">Status</th>
                <th>Memo</th>
                <th class="small">Del</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 1; ?>
            <?php foreach ($result as $row) : ?>
            <tr id="<?php echo $this->db_table; ?>-<?php echo $row['unique_id']; ?>">
                <td><?php echo $x; ?></td>
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['bank_name']; ?></a></td>
                <td><?php echo $row['bank_branch']; ?></td>
                <td><?php echo $row['bank_account_holder']; ?></td>
                <td><?php echo $row['bank_account_number']; ?></td>
                <td><?php echo $row['bank_currency']; ?></td>
                <td><?php if ($row['bank_invoice_type'] == 1) echo 'Wilson Iwan'; elseif ($row['bank_invoice_type'] == 2) echo 'PT. Go Online Solusi'; ?></td>
                <td><?php echo $row['bank_swift_code']; ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
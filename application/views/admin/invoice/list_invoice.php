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
                <th>Invoice #</th>
                <th>Name</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Bank</th>
                <th>Price</th>
                <th>Payment</th>
                <th>Amount</th>
                <th>Date</th>
                <th class="medium">Status</th>
                <th>Memo</th>
                <th class="small">Del</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 1; ?>
            <?php foreach ($result as $row) : ?>
            <tr title="<?php echo $row['unique_id']; ?>" id="<?php echo $this->db_table; ?>-<?php echo $row['unique_id']; ?>">
                <td><?php echo $x; ?></td>
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['invoice_number']; ?></a></td>
                <?php if ($row['invoice_type'] == 1) $url = 'dhm'; elseif ($row['invoice_type'] == 2) $url = 'maintenance'; elseif ($row['invoice_type'] == 3) $url = 'project'; ?>
                <td><a href="<?php echo base_url('admin/' . $url . '/view/' . $row['invoice_item_id']); ?>"><?php echo $row['invoice_project_name']; ?></a></td>
                <td><?php echo $row['product_code']; ?></td>
                <td><?php echo $row['invoice_customer_name']; ?></td>
                <td><?php echo $row['bank_name'] . ' ' . $row['invoice_currency'] . '<br />' . $row['bank_account_holder'] . '<br />' . $row['bank_account_number'] . ''; ?> </td>
                <td><?php echo number_format($row['invoice_price'] + $row['invoice_markup']); ?></td>
                <td><?php echo $row['invoice_top_number'] . '/' . $row['invoice_top']; ?></td>
                <td><?php echo number_format($row['invoice_top_amount']); ?></td>
                <td><?php echo date('d M Y', strtotime($row['invoice_create_date'])); ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('a.button.inside').fancybox({
		width: 515
	});
});
</script>
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
                <th>Project Name</th>
                <th>Product</th>
                <th>Company / Client</th>
                <th>T.O.P</th>
<!--                <th>Percent / Value</th>-->
                <th>Bank</th>
                <th>Price</th>
                <th>Sales</th>
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
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['project_name']; ?></a></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo ($row['company_name']) ? $row['company_name'] : $row['client_name']; ?></td>
                <td><?php echo $row['project_top']; ?></td>
                <td><?php echo $row['bank_name']; ?></td>
                <td><?php echo number_format($row['project_price'] + $row['project_markup']); ?></td>
                <td><?php echo $row['admin_name']; ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
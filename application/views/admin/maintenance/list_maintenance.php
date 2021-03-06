<script type="text/javascript">
$(document).ready(function(){
	$('a.button.inside').fancybox({
		autoSize: false,
		width: 515,
		height: 400
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
    
    <form id="list-filter" method="post" action="<?php echo current_url(); ?>">
    	<div>
        	<p>
                <label>Flag</label>
                <select name="flag">
                    <option value="">--</option>
                    <option value="1" <?php if ($this->input->post('flag') == 1) echo 'selected="selected"'; ?>>Active</option>
                    <option value="2" <?php if ($this->input->post('flag') == 2) echo 'selected="selected"'; ?>>Inactive</option>
                    <option value="3" <?php if ($this->input->post('flag') == 3) echo 'selected="selected"'; ?>>Deleted</option>
                </select>
            </p>
        </div>
        <div class="clear"></div>
        <input type="submit" value="Search" />
    </form>
    
    <table id="<?php echo $this->db_table; ?>" class="table-data" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="small">No.</th>
                <th>Maintenance Name</th>
                <th>Company / Client</th>
                <th class="medium">Extend</th>
                <th>Bank</th>
                <th>Period</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Price</th>
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
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['maintenance_name']; ?></a></td>
                <td><?php echo ($row['company_name']) ? $row['company_name'] : $row['client_name']; ?></td>
                <td class="maintenance-extend">
					<?php if ($row['date_diff'] >= -30) : ?>
                    <a class="button inside" id="maintenance-extend-<?php echo $row['unique_id']; ?>" data-fancybox-type="iframe" href="<?php echo base_url('admin/maintenance/extend/' . $row['unique_id']); ?>">Extend</a>
                    <?php endif; ?>
                </td>
                <td><?php echo $row['maintenance_period']; ?> months</td>
                <td><?php echo $row['bank_name']; ?></td>
                <td><?php echo date('d M Y', strtotime($row['maintenance_start'])); ?></td>
                <td class="maintenance-end-date"><?php echo date('d M Y', strtotime($row['maintenance_end'])); ?></td>
                <td><?php echo number_format($row['maintenance_price']); ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
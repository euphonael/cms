<script>
$(function(){
	$('table').dataTable();
});
</script>
<div id="container">
	<div id="action-wrapper">
    	<a class="button" href="<?php echo base_url('admin/' . $this->url . '/add'); ?>">New <?php echo $this->title; ?></a>
    </div>
    <table id="<?php echo $this->db_table; ?>" class="table-data" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Username</th>
                <th>Join Date</th>
                <th>Birthday</th>
                <th>Phone</th>
                <th>Work E-mail</th>
                <th>Job Position</th>
                <th>Privilege</th>
                <th>Status</th>
                <th>Memo</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 1; ?>
            <?php foreach ($result as $row) : ?>
            <tr id="<?php echo $this->db_table; ?>-<?php echo $row['unique_id']; ?>">
                <td><?php echo $x; ?></td>
                <td>
					<?php echo $row['admin_name']; ?>
                    <span class="action">
                    	<a href="javascript:;">Edit</a>
                        <a href="javascript:;">Delete</a>
                    </span>
                </td>
                <td><?php echo $row['admin_username']; ?></td>
                <td><?php echo date('d M Y', strtotime($row['admin_join_date'])); ?></td>
                <td><?php echo date('d M Y', strtotime($row['admin_dob'])); ?></td>
                <td><?php echo $row['admin_phone']; ?></td>
                <td><?php echo $row['admin_work_email']; ?></td>
                <td><?php echo $row['admin_job_position']; ?></td>
                <td><?php echo $row['admin_privilege']; ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
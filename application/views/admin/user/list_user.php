<script>
$(function(){
	$('table').dataTable();
});
</script>
<div id="container">
<table id="<?php echo $this->db_table; ?>" class="table-data">
	<thead>
    	<tr>
        	<th>No.</th>
            <th>Nama</th>
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
        	<td><?php echo $row['admin_name']; ?></td>
            <td><?php echo $row['admin_username']; ?></td>
            <td><?php echo $row['admin_join_date']; ?></td>
            <td><?php echo $row['admin_dob']; ?></td>
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
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
                <th>Del</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 1; ?>
            <?php foreach ($result as $row) : ?>
            <tr id="<?php echo $this->db_table; ?>-<?php echo $row['unique_id']; ?>">
                <td><?php echo $x; ?></td>
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['admin_name']; ?></a></td>
                <td><?php echo $row['admin_username']; ?></td>
                <td><?php if ($row['admin_join_date'] != '0000-00-00') echo date('d M Y', strtotime($row['admin_join_date'])); ?></td>
                <td><?php if ($row['admin_dob'] != '0000-00-00') echo date('d M Y', strtotime($row['admin_dob'])); ?></td>
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
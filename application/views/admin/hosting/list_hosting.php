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
                <th class="medium">Hosting<br />Location</th>
                <th>Root Domain</th>
                <th>cPanel URL</th>
                <th>Username</th>
                <th>Password</th>
                <th>Disk<br />Space</th>
                <th>Subdomain</th>
                <th>Add-on<br />Domain</th>
                <th>MySQL<br />Database</th>
                <th>Expiry Date</th>
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
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['hosting_name']; ?></a></td>
                <td><?php echo $row['hosting_root_domain']; ?></td>
                <td><a href="<?php echo prep_url($row['hosting_cpanel_url']); ?>"><?php echo $row['hosting_cpanel_url']; ?></a></td>
                <td><?php echo $row['hosting_cpanel_username']; ?></td>
                <td><?php echo $row['hosting_cpanel_password']; ?></td>
                <td><?php echo $row['hosting_disk_space']; ?></td>
                <td><?php echo $row['hosting_subdomain']; ?></td>
                <td><?php echo $row['hosting_addon_domain']; ?></td>
                <td><?php echo $row['hosting_mysql_db']; ?></td>
                <td><?php echo date('d M Y', strtotime($row['hosting_expiry'])); ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
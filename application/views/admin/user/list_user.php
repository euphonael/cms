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
                <label>Status</label>
                <select name="admin_status">
                    <option value="">--</option>
                    <option value="1" <?php if ($this->input->post('admin_status') == 1) echo 'selected="selected"'; ?>>Active</option>
                    <option value="2" <?php if ($this->input->post('admin_status') == 2) echo 'selected="selected"'; ?>>Resigned</option>
                </select>
            </p>
        </div>
        <div>
            <p>
                <label>Division</label>
                <select name="admin_division">
                    <option value="">--</option>
                    <?php foreach ($division_list as $item) : ?>
                    <option value="<?php echo $item['unique_id']; ?>" <?php if ($this->input->post('admin_division') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['division_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
        <div>
        	<p>
        	<label>Work Duration</label>
            <select name="duration_type">
            	<option value="">--</option>
                <option value=">" <?php if ($this->input->post('duration_type') == '>') echo 'selected="selected"'; ?>>Greater Than</option>
                <option value="<=" <?php if ($this->input->post('duration_type') == '<=') echo 'selected="selected"'; ?>>Less Than / Equal to</option>
            </select>
            <input type="text" name="duration" class="digits" value="<?php echo $this->input->post('duration'); ?>" />
            <span class="suffix">months</span>
            </p>
        </div>
        <div class="clear"></div>
        <input type="submit" value="Search" />
    </form>
    
    <table id="<?php echo $this->db_table; ?>" class="table-data" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="small">No.</th>
                <th>Name</th>
                <th>Username</th>
                <th>Join Date</th>
                <th>Work Duration</th>
                <th>Birthday</th>
                <th>Phone</th>
                <th>Work E-mail</th>
                <th>Job Position</th>
                <th>Privilege</th>
                <th class="medium">Status</th>
                <th>Memo</th>
                <th class="small">Del</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 1; ?>
            <?php foreach ($result as $row) : ?>
            <?php $period = ($row['admin_resign_date'] == '0000-00-00') ? $row['total_days_now'] : $row['total_days_resign']; ?>
            <tr id="<?php echo $this->db_table; ?>-<?php echo $row['unique_id']; ?>">
                <td><?php echo $x; ?></td>
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['admin_name']; ?></a></td>
                <td><?php echo $row['admin_username']; ?></td>
                <td><?php if ($row['admin_join_date'] != '0000-00-00') echo date('d M Y', strtotime($row['admin_join_date'])); ?></td>
                <td><?php echo floor($period / 12) . ' year ' . floor($period % 12) . ' months'; ?></td>
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
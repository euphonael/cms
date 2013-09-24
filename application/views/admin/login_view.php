<form id="login" method="post" action="<?php echo base_url('admin'); ?>">
    <?php echo $this->session->flashdata('login_form_message'); ?>
	<p>
    	<label for="admin_username">Username</label>
        <input type="text" id="admin_username" name="admin_username" class="required" />
        <?php echo form_error('admin_username'); ?>
    </p>
    <p>
    	<label for="admin_password">Password</label>
        <input type="password" id="admin_password" name="admin_password" class="required" />
        <?php echo form_error('admin_password'); ?>
    </p>
    <p>
    	<input type="submit" value="Login" />
    </p>
</form>
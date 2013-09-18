<form id="login" class="cmxform" method="post" action="<?php echo base_url('admin'); ?>">
    <?php echo $this->session->flashdata('login_form_message'); ?>
	<p>
    	<label for="admin-username">Username</label>
        <input type="text" id="admin-username" name="admin-username" class="required" />
        <?php echo form_error('admin-username'); ?>
    </p>
    <p>
    	<label for="admin-password">Password</label>
        <input type="password" id="admin-password" name="admin-password" class="required" />
        <?php echo form_error('admin-password'); ?>
    </p>
    <p>
    	<input type="submit" value="Login" />
    </p>
</form>
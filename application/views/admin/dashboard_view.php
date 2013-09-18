<div id="container">
Welcome <?php echo $this->session->userdata('admin_name'); ?>!

Dashboard View

<a href="<?php echo base_url('admin/logout'); ?>">Logout</a>
</div>
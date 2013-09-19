<ul id="main-menu">
	<?php foreach ($menu as $parent_menu) : ?>
        <li>
            <a <?php if ($parent_menu['has_submenu'] == 1) echo 'class="has-submenu"'; ?> href="<?php echo base_url('admin/' . $parent_menu['module_url']); ?>"><span><?php echo $parent_menu['module_name']; ?></span><?php if ($parent_menu['has_submenu'] == 1) echo '<span class="arrow"></span>'; ?></a>
            <?php if ($parent_menu['has_submenu'] == 1) : ?>
            <ul class="submenu">
                <?php foreach ($parent_menu['submenu'] as $child_menu) : ?>
                    <li>
                    	<a href="<?php echo base_url('admin/' . $child_menu['module_url']); ?>"><?php echo $child_menu['module_name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    
    <li class="top-right">
    	<a href="<?php echo base_url('admin/logout'); ?>">Logout</a>
    </li>
    
    <li class="top-right">
    	<a href="javascript:;"><?php echo $this->session->userdata('admin_name'); ?></a>
    </li>
</ul>

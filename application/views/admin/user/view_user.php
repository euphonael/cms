<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>" enctype="multipart/form-data">
        <div id="content-heading">
            <h2><?php echo $title; ?>: <?php echo $row['admin_name']; ?></h2>
            <div id="action-wrapper">
                <button type="button">Back</button>
                <button type="reset">Reset Form</button>
            	<input type="submit" value="Save Data" />
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
        </div>
        
        <div id="form-content">
        	<div id="form-left">
                <fieldset>
                    <legend>Login Details</legend>
                    <p>
                        <label class="label-input" for="admin_username">Username</label>
                        <input type="text" name="admin_username" id="admin_username" class="required" value="<?php echo form_value('admin_username', $row); ?>" />
                        <?php echo form_error('admin_username'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="admin_password">Password</label>
                        <input type="password" name="admin_password" id="admin_password" />
                        <?php echo form_error('admin_password'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="admin_repassword">Re-enter Password</label>
                        <input type="password" name="admin_repassword" id="admin_repassword" equalTo="#admin_password" />
                        <?php echo form_error('admin_repassword'); ?>
                    </p>
                </fieldset>
                
                <fieldset>
                    <legend>Personal Details</legend>
                    <p>
                        <label class="label-input" for="admin_name">Name</label>
                        <input type="text" name="admin_name" id="admin_name" class="required" value="<?php echo form_value('admin_name', $row); ?>" />
                        <?php echo form_error('admin_name'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="admin_dob">Date of Birth</label>
                        <input type="text" name="admin_dob" id="admin_dob" class="datepicker" value="<?php echo form_value('admin_dob', $row); ?>" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_pob">Place of Birth</label>
                        <input type="text" name="admin_pob" id="admin_pob" value="<?php echo form_value('admin_pob', $row); ?>" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_phone">Phone</label>
                        <input type="text" name="admin_phone" id="admin_phone" class="digits" value="<?php echo form_value('admin_phone', $row); ?>" />
                        <?php echo form_error('admin_phone'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="admin_personal_email">Personal E-mail</label>
                        <input type="text" name="admin_personal_email" id="admin_personal_email" class="email" value="<?php echo form_value('admin_personal_email', $row); ?>" />
                        <?php echo form_error('admin_personal_email'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="admin_ktp">Scan KTP</label>
                        <input type="file" name="admin_ktp" id="admin_ktp" />
                    </p>
                    
                    <?php if ($row['admin_ktp']) : ?>
                    <p>
                    	<label class="label-input">Current File</label>
						<a class="fake-input fancybox" title="<?php echo $row['admin_ktp']; ?>" href="<?php echo base_url('upload/ktp/' . $row['admin_ktp']); ?>"><?php echo $row['admin_ktp']; ?></a>
                        <input class="file-checkbox" type="checkbox" value="1" name="admin_ktp_delete" title="Check this box to delete current file" />
                        <span class="clear"></span>
                    </p>
                    <?php endif; ?>
                    
                    <p>
                        <label class="label-input" for="admin_npwp">Scan NPWP</label>
                        <input type="file" name="admin_npwp" id="admin_npwp" />
                    </p>
                    
                    <?php if ($row['admin_npwp']) : ?>
                    <p>
                    	<label class="label-input">Current File</label>
						<a class="fake-input fancybox" title="<?php echo $row['admin_npwp']; ?>" href="<?php echo base_url('upload/npwp/' . $row['admin_npwp']); ?>"><?php echo $row['admin_npwp']; ?></a>
                        <input class="file-checkbox" type="checkbox" value="1" name="admin_npwp_delete" title="Check this box to delete current file" />
                        <span class="clear"></span>
                    </p>
                    <?php endif; ?>
                </fieldset>
            </div>
            
            <div id="form-right">
                
                <?php $this->load->view('admin/template/view_flag'); ?>
                
                <fieldset>
                    <legend>Staff Info</legend>
                    <p>
                        <label class="label-input" for="admin_work_email">Work E-mail</label>
                        <input type="text" name="admin_work_email" id="admin_work_email" class="email" value="<?php echo form_value('admin_work_email', $row); ?>" />
                        <?php echo form_error('admin_work_email'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="admin_job_position">Job Position</label>
                        <input type="text" name="admin_job_position" id="admin_job_position" class="required" value="<?php echo form_value('admin_job_position', $row); ?>" />
                        <?php echo form_error('admin_job_position'); ?>
                    </p>
                    <p>
                        <label class="label-input" for="admin_join_date">Join Date</label>
                        <input type="text" name="admin_join_date" id="admin_join_date" class="datepicker" value="<?php echo form_value('admin_join_date', $row); ?>" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_resign_date">Resign Date</label>
                        <input type="text" name="admin_resign_date" id="admin_resign_date" class="datepicker" value="<?php echo form_value('admin_resign_date', $row); ?>" />
                    </p>
                </fieldset>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
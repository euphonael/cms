<div id="container">
	<form id="process-data" method="post" action="javascript:;">
        <div id="content-heading">
            <h2><?php echo $title; ?></h2>
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
                        <input type="text" name="admin_username" id="admin_username" class="required" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_password">Password</label>
                        <input type="password" name="admin_password" id="admin_password" class="required" />
                    </p>
                </fieldset>
                
                <fieldset>
                    <legend>Personal Details</legend>
                    <p>
                        <label class="label-input" for="admin_name">Name</label>
                        <input type="text" name="admin_name" id="admin_name" class="required" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_dob">Date of Birth</label>
                        <input type="text" name="admin_dob" id="admin_dob" class="required" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_pob">Place of Birth</label>
                        <input type="text" name="admin_pob" id="admin_pob" class="required" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_phone">Phone</label>
                        <input type="text" name="admin_phone" id="admin_phone" class="required digits" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_personal_email">Personal E-mail</label>
                        <input type="text" name="admin_personal_email" id="admin_email" class="required email" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_ktp">Scan KTP</label>
                        <input type="file" name="admin_ktp" id="admin_ktp" class="required" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_npwp">Scan NPWP</label>
                        <input type="file" name="admin_npwp" id="admin_npwp" />
                    </p>
                </fieldset>
            </div>
            
            <div id="form-right">
                <fieldset>
                    <legend>Staff Info</legend>
                    <p>
                        <label class="label-input" for="admin_work_email">Work E-mail</label>
                        <input type="text" name="admin_work_email" id="admin_work_email" class="required email" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_job_position">Job Position</label>
                        <input type="text" name="admin_job_position" id="admin_job_position" class="required" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_join_date">Join Date</label>
                        <input type="text" name="admin_join_date" id="admin_join_date" class="required" />
                    </p>
                    <p>
                        <label class="label-input" for="admin_resign_date">Resign Date</label>
                        <input type="text" name="admin_resign_date" id="admin_resign_date" class="required" />
                    </p>
                </fieldset>
            </div>
            
            <div class="clear"></div>
        </div>
    </form>
</div>
<div id="container">
	<form id="process-data" method="post" action="javascript:;">
        <div id="content-heading">
            <h2><?php echo $title; ?></h2>
            <div id="action-wrapper">
                <button>Back</button>
                <button type="reset">Reset Form</button>
            	<input type="submit" value="Save Data" />
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
        </div>
        
        <div id="form-content">
        	<fieldset>
            	<legend>Login Details</legend>
                <p>
                	<label for="admin_username">Username</label>
                    <input type="text" name="admin_username" id="admin_username" class="required" />
                </p>
            </fieldset>
        </div>
    </form>
</div>
<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
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
        
        <table class="table-data" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Invoice Type</th>
                    <th>Item Name</th>
                    <th>Periode</th>
                    <th>Product</th> <!-- DHM auto DHM, Maintenance / Project Choose -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div id="container">
	<form id="process-data" method="post" action="<?php echo current_url(); ?>">
    	<input type="hidden" name="flag" value="1" />
        <input type="hidden" id="item_count" name="count" value="0" />
        
        <div id="content-heading">
            <h2><?php echo $title; ?></h2>
            <div id="action-wrapper">
                <button type="button" style="margin-right:15px;">Back</button>
            	<input type="submit" value="Save Data" />
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
        </div>
        
		<div>
            <button class="inside-form" id="add-invoice-item" type="button">Add Item</button>
            <button class="inside-form" id="del-invoice-item" type="button">Remove Item</button>
            <div class="clear"></div>
        </div>

        <table id="add-invoice" class="table-data" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="small">No.</th>
                    <th class="long">Invoice Type</th>
                    <th>Item Name</th>
                    <th>Product</th> <!-- DHM auto DHM, Maintenance / Project Choose -->
                    <th>Price</th>
                    <th>Markup</th>
                    <th>Period</th>
                </tr>
            </thead>
            <tbody>
				<?php for ($x = 1; $x <= 5; $x++) : ?>
                <tr class="invoice-item">
                    <td><?php echo $x; ?></td>
                    <td class="type">
						<select name="invoice_type[]" class="invoice_type">
                        	<option value="">--</option>
                            <option value="1">DHM</option>
                            <option value="2">Maintenance</option>
                            <option value="3">Project</option>
                        </select>
                    </td>
                    <td class="item"></td>
                    <td class="product"></td>
                    <td class="price"></td>
                    <td class="markup"></td>
                    <td class="period"></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </form>
</div>

<div id="temp-invoice"></div>
<script type="text/javascript">
$(document).ready(function(){
	$('form#invoice-payment').validate({
		submitHandler: function(){
			
			if (parent.$('table#invoice_log tbody tr:last-child').attr('id') == 'add-new')
				var count = parent.$('table#invoice_log tbody tr').length;
			else
				var count = parent.$('table#invoice_log tbody tr').length + 1;
			$.ajax({
				type: 'POST',
				url: '<?php echo current_url(); ?>',
				data: $('form#invoice-payment').serialize(),
				success: function(html)
				{
					parent.$('a.invoice-payment').fadeOut();
					parent.$.fancybox.close();
					parent.alertify.success('Invoice: <strong><?php echo $row[0]['invoice_number']; ?></strong><br />Paid on: <strong>' + html + '</strong>');
					<?php if ($source == 'list') : ?>
						parent.$('#invoice-<?php echo $row[0]['unique_id']; ?> td.payment').html(html);
					<?php elseif ($source == 'view') : ?>
						parent.$('tr#add-new').remove();
						parent.$('table#invoice_log tbody').append('<tr><td>' + count + '</td><td>' + '<?php echo date('d M Y H:i:s'); ?>'+ '</td><td>' + '<?php echo $this->session->userdata('admin_name'); ?>' + '</td>><td>Paid on: ' + html + '</td></tr>');
					<?php endif; ?>
				}
			})
		}
	});
});
</script>
<div id="container">
	<form id="invoice-payment" class="popup" method="post" action="<?php echo current_url(); ?>">
        <div id="content-heading">
            <h2><?php echo $title; ?> : <?php echo $row[0]['invoice_number']; ?></h2>            
            <div class="clear"></div>
        </div>
        
        <div id="form-content">
        	<div id="form-left">
                
                <fieldset>
                    <legend>Invoice Info</legend>
                    
                    <p>
                    	<label class="label-input" for="invoice_paid_date">Payment Date</label>
                        <input type="text" name="invoice_paid_date" id="invoice_paid_date" class="datepicker required" value="<?php echo date('Y-m-d'); ?>" />
                    </p>
                    <p>
                    	<label class="label-input" for="invoice_paid_note">Note</label>
                        <textarea class="input" name="invoice_paid_note" id="invoice_paid_note"></textarea>
                    </p>
                </fieldset>
			</div>
            
            <div class="clear"></div>
        </div>
        
		<div id="action-wrapper">
            <input type="submit" value="Change status to Paid" />
            <div class="clear"></div>
        </div>
    </form>
</div>
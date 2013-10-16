<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice No: <?=$row[0]['invoice_number']?></title>
</head>
<body style="margin:15px auto 0; padding:0;font-family:Verdana;font-size:12px;width:595px;height:842px;position:relative;" onload="window.print();">

<hr id="markertop" style="margin:0;padding:0;position:absolute;border:none;border-top:1px solid #CCC;width:10px;height:1px;right:-20px;top:301px;">

<hr id="markerbottom" style="margin:0;padding:0;position:absolute;border:none;border-top:1px solid #CCC;width:10px;height:1px;right:-20px;top:675px;">

<div id="header" style="margin:0;padding:0;height:155px;border-bottom:1px solid #CCC; width:595px;">
	<div>
	<a id="logo" href="http://www.gositus.com" target="_blank" style="margin:0;padding:0;outline:none;text-decoration:none;display:block;float:left;margin-top:5px; margin-right:15px;"><img src="<?php echo base_url('images/logo.png'); ?>" style="margin:0;padding:0;border:none;"></a>
    <div id="company" style="margin:0;padding:0;float:right;font-size:11px;margin-left:5px;margin-top:5px;">
    	<p style="margin:0;padding:0; text-align:right; line-height:1.6; font-size:11px; color:#666;">
        	www.gositus.com<br style="margin:0; padding:0;">
            <strong>phone</strong> (021) 8023 8800<br style="margin:0; padding:0;">
            <strong>fax</strong> (021) 6983 0191<br style="margin:0; padding:0;">
            <strong>email</strong> go@gositus.com<br style="margin:0; padding:0;">
            Jl. Pejagalan 1 No. 1-B 2nd Fl<br style="margin:0; padding:0;">
        	Jakarta Barat - 11240
        </p>
    </div>

    <div style="margin:0; padding:0; clear:both;"></div>

    </div>

   	<h1 style="display:block; font-weight:bold; font-variant:small-caps; float:right; margin:0;padding:0;color:#3399cc;font-size:30px; margin-top:10px;">Invoice</h1>

    <div class="clear" style="margin:0;padding:0;clear:both;"></div>
</div>

<div id="content" style="margin:0;padding:0;margin-top:15px; width:595px;">
	<div id="billing" style="float:left; margin:0; padding:0;">
    	<strong style="margin:0;padding:0;line-height:1.3;display:block;">Bill To:</strong>
        <p style="margin:0;padding:0;line-height:1.6;">
			<?php
			echo $row[0]['invoice_customer_name'] . '<br />';
			
			if ($cust[$type . '_address'])
			{
				echo nl2br($cust[$type . '_address']) . '<br />';
				echo $cust[$type .'_city'];
				if ($cust[$type . '_postal_code'])
				{
					echo ' - ' . $cust[$type . '_postal_code'];
				}
				echo '<br />';
			}
			
			echo $cust[$type .'_country'] . '<br />';
			
			if ( ! $cust[$type .'_address'])
			{
				echo '<br /><br />';
			}
			?>
        </p>
    </div>

    

    <div style="float:right; margin:0; padding:0; text-align:right;">
        <p style="margin:0;padding:0;line-height:1.3;font-size:13px;">
    Date: <?=date('d F Y', strtotime($row[0]['invoice_create_date']))?><br style="margin:0; padding:0;">
    Invoice: <?=$row[0]['invoice_number']?><br style="margin:0; padding:0;">
    Due Date: <?=date('d F Y', strtotime($row[0]['invoice_create_date'] . ' + 7 days'))?>        </p>
    </div>

    <div style="margin:0; padding:0; clear:both;"></div>

    <table cellspacing="0" cellpadding="0" style="margin:0;padding:0;border-top:2px solid #2b93d1;width:595px;margin-top:20px;">
	    <thead style="margin:0; padding:0;"><tr style="margin:0; padding:0;">
            <tr>
                <th class="first" style="margin:0;padding:0;border-bottom:1px solid #2b93d1;color:#4f81bd;border-left:2px solid #2b93d1;">ID</th>
                <th width="400" style="margin:0;padding:0;border-bottom:1px solid #2b93d1;color:#4f81bd;">Description</th>
                <th class="last" style="margin:0;padding:0;border-bottom:1px solid #2b93d1;color:#4f81bd;border-right:2px solid #2b93d1;">Total</th>
            </tr>
		</thead>

		<?php $price = 0; ?>
		<tbody style="margin:0; padding:0;">
        	<?php foreach ($row as $item) : ?>
            <?php
			$price = $price + $item['invoice_top_amount'];
			?>
			<tr class="odd" style="margin:0;padding:0;background:#dbe5f1;">
				<td class="first" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-left:2px solid #2b93d1;"><?=$item['product_code']?></td>
                <td class="align-left" style="margin:0;padding:1px;color:#4ea4e0;text-align:left;"><?=$item['product_name']?></td>
                <td class="last" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-right:2px solid #2b93d1;"><?=$item['invoice_currency']?> <?=number_format($item['invoice_top_amount'])?></td>
            </tr>
<tr class="even" style="margin:0; padding:0;">
<td class="first" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-left:2px solid #2b93d1;">&nbsp;</td>
                <td class="align-left" style="margin:0;padding:1px;color:#4ea4e0;text-align:left;">Payment <?=$item['invoice_top_number']?></td>
                <td class="last" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-right:2px solid #2b93d1;"></td>
            </tr>
			<?php endforeach; ?>
<tr class="odd" style="margin:0;padding:0;background:#dbe5f1;">
<td class="first" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-left:2px solid #2b93d1;">&nbsp;</td>
                <td class="align-left" style="margin:0;padding:1px;color:#4ea4e0;text-align:left;"><?php echo nl2br($item['invoice_note']);?></td>
                <td class="last" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-right:2px solid #2b93d1;"></td>
            </tr>
<tr class="even" style="margin:0; padding:0;">
<td class="first" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-left:2px solid #2b93d1;">&nbsp;</td>
                <td style="margin:0;padding:1px;color:#4ea4e0;text-align:center;"></td>
                <td class="last" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-right:2px solid #2b93d1;"></td>
            </tr>
<tr class="odd" style="margin:0;padding:0;background:#dbe5f1;">
<td class="first" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-left:2px solid #2b93d1;">&nbsp;</td>
                <td style="margin:0;padding:1px;color:#4ea4e0;text-align:center;"></td>
                <td class="last" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-right:2px solid #2b93d1;"></td>
            </tr>
<tr class="even" style="margin:0; padding:0;">
<td class="first" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-left:2px solid #2b93d1;">&nbsp;</td>
                <td style="margin:0;padding:1px;color:#4ea4e0;text-align:center;"></td>
                <td class="last" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-right:2px solid #2b93d1;"></td>
            </tr>
<tr class="odd" style="margin:0;padding:0;background:#dbe5f1;">
<td class="first" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-left:2px solid #2b93d1;">&nbsp;</td>
                <td style="margin:0;padding:1px;color:#4ea4e0;text-align:center;"></td>
                <td class="last" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-right:2px solid #2b93d1;"></td>
            </tr>
<tr class="even final" style="margin:0; padding:0;">
<td class="first" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-left:2px solid #2b93d1;border-bottom:2px solid #2b93d1;">&nbsp;</td>
                <td style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-bottom:2px solid #2b93d1;"></td>
                <td class="last" style="margin:0;padding:1px;color:#4ea4e0;text-align:center;border-right:2px solid #2b93d1;border-bottom:2px solid #2b93d1;"></td>
            </tr>
</tbody>
<tfoot style="margin:0; padding:0;"><tr style="margin:0; padding:0;">
                <td style="margin:0;padding:10px;color:#4f81bd;">&nbsp;</td>
                <td align="right" style="margin:0;padding:10px;color:#4f81bd;">Total:</td>
                <td align="center" class="price" style="margin:0;padding:10px;color:#4f81bd;border-bottom:4px solid #2b93d1;"><?=$row[0]['invoice_currency']?> <?=number_format($price)?></td>
            </tr></tfoot>
</table>

</div>

<?php $amount = ($row[0]['invoice_currency'] == "Rp.") ? terbilang($price) . ' Rupiah' : spellnumber($price) . ' Dollars'; ?>

<div id="footer" style="margin:0;padding:0;margin-top:50px; height:355px;position:relative; width:595px;">
	<p id="amount" style="margin:0;padding:0;line-height:1.3;display:block;">
    	Amount:<br style="margin:0; padding:0;"><em style="margin:0; padding:0; text-transform:capitalize;"><?=$amount?></em>
    </p>
    <p id="payment" style="margin:25px 0;padding:0;line-height:1.3;display:block;">
    	Please make all payment to:<br style="margin:0; padding:0;">
        Beneficiary Name: <?=$row[0]['bank_account_holder']?><br />
        Bank: <?=$row[0]['bank_name']?><br style="margin:0; padding:0;">
		Branch: <?=$row[0]['bank_branch']?><br style="margin:0; padding:0;">
        Currency: <?=$row[0]['bank_currency']?><br style="margin:0; padding:0;">
        Account No: <?=$row[0]['bank_account_number']?><br style="margin:0; padding:0;">
        Swift Code: <?=$row[0]['bank_swift_code']?><br style="margin:0; padding:0;">
        </p>

    <p id="date" style="margin:0;padding:0;line-height:1.3;">Jakarta, <?=date('d F Y', strtotime($row[0]['invoice_create_date']))?></p>

    <h2 style="margin:0;padding:0;color:#622423;font-size:16px;text-transform:uppercase;position:absolute;left:250px;bottom:0;right:0;margin-bottom:15px;">Thank You</h2>
</div>
</body>
</html>
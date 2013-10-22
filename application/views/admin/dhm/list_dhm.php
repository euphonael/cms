<script type="text/javascript">
$(document).ready(function(){
	$('a.button.inside.create').fancybox({
		autoSize: false,
		width: 515,
		height: 350
	});
});
</script>
<div id="container">
	<div id="content-heading">
    	<h2><?php echo $title; ?></h2>
        <div id="action-wrapper">
            <a class="button" href="<?php echo base_url('admin/' . $this->url . '/add'); ?>">New <?php echo $this->title; ?></a>
            <button class="delete" id="delete-<?php echo $this->db_table; ?>" title="Delete selected items"><img src="<?php echo base_url('images/icon-delete.png'); ?>" /></button>
            <div class="clear"></div>
        </div>
        
        <div class="clear"></div>
    </div>
    
    <form id="list-filter" method="post" action="<?php echo current_url(); ?>">
        <div>
            <p>
                <label>Domain</label>
                <select name="domain">
                    <option value="">--</option>
                    <?php foreach ($domain_list as $item) : ?>
                    <option value="<?php echo $item['unique_id']; ?>" <?php if ($this->input->post('domain') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['domain_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
        <div>
            <p>
                <label>Hosting</label>
                <select name="hosting">
                    <option value="">--</option>
                    <?php foreach ($hosting_list as $item) : ?>
                    <option value="<?php echo $item['unique_id']; ?>" <?php if ($this->input->post('hosting') == $item['unique_id']) echo 'selected="selected"'; ?>><?php echo $item['hosting_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
    	<div>
        	<p>
                <label>Flag</label>
                <select name="flag">
                    <option value="">--</option>
                    <option value="1" <?php if ($this->input->post('flag') == 1) echo 'selected="selected"'; ?>>Active</option>
                    <option value="2" <?php if ($this->input->post('flag') == 2) echo 'selected="selected"'; ?>>Inactive</option>
                    <option value="3" <?php if ($this->input->post('flag') == 3) echo 'selected="selected"'; ?>>Deleted</option>
                </select>
            </p>
        </div>
        <div class="clear"></div>
        <input type="submit" value="Search" />
    </form>
    
    <table id="<?php echo $this->db_table; ?>" class="table-data" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="small">No.</th>
                <th>DHM Name</th>
                <th>Company / Client</th>
                <th>Extend</th>
                <th>Domain</th>
                <th>Hosting</th>
                <th>Username</th>
                <th>Password</th>
                <th>Bank</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Price / year</th>
                <th class="medium">Status</th>
                <th>Memo</th>
                <th class="small">Del</th>
            </tr>
        </thead>
        <tbody>
            <?php $x = 1; ?>
            <?php foreach ($result as $row) : ?>
            <tr id="<?php echo $this->db_table; ?>-<?php echo $row['unique_id']; ?>">
                <td><?php echo $x; ?></td>
                <td><a href="<?php echo base_url('admin/' . $this->url . '/view/' . $row['unique_id']); ?>"><?php echo $row['dhm_name']; ?></a></td>
                <td><?php echo ($row['company_name']) ? $row['company_name'] : $row['client_name']; ?></td>
                <td class="dhm-extend">
					<?php
                    
					if ($row['date_diff'] >= -30) :
					
						// Apa ada invoice yg udah di create tapi blom dibayar 
						$check = $this->db->get_where('invoice', array('invoice_type' => 1, 'invoice_paid' => 0, 'invoice_item_id' => $row['unique_id'], 'flag !=' => 3))->row_array();
						
						if ( ! $check) : // Kalo ga ada.. allow create invoice
					
							$subcheck = $this->db->get_where('invoice', array('invoice_type' => 1, 'invoice_paid' => 1, 'invoice_item_id' => $row['unique_id'], 'flag !=' => 3, 'invoice_clear' => 0))->row_array();
							
							if ( ! $subcheck) :
					?>
						<a class="button inside create" id="dhm-create-invoice-<?php echo $row['unique_id']; ?>" data-fancybox-type="iframe" href="<?php echo base_url('admin/dhm/create_invoice/' . $row['unique_id']); ?>">Create Invoice</a>
                        
                        <?php else : ?>
                        
                        <a name="<?php echo $subcheck['invoice_id']; ?>" rel="<?php echo $subcheck['invoice_top_amount'] / $row['dhm_price'] * 12; ?>" class="button inside extend" id="dhm-extend-<?php echo $row['unique_id']; ?>" href="<?php echo base_url('admin/dhm/extend/' . $row['unique_id']); ?>">Extend</a>
                        
                        <?php endif; ?>
                    
                    <?php
                    
					elseif ($check) : // Tapi kalo ternyata ada invoice yg udah di create tapi blom dibayar,
					// Kita tampilin invoice number aja
					?>
                    
                    <a href="<?php echo base_url('admin/invoice/view/' . $check['unique_id']); ?>"><?php echo $check['invoice_number']; ?></a>
                    
                    <?php endif; ?>
                    
                    <?php /*
                    <?php if ( ! $row['invoice_id'] || ($row['invoice_id'] && $row['invoice_dhm_extend'] == 1)) : // If ga ada invoice, bisa create invoice ?>
                    
                    	<a class="button inside create" id="dhm-create-invoice-<?php echo $row['unique_id']; ?>" data-fancybox-type="iframe" href="<?php echo base_url('admin/dhm/create_invoice/' . $row['unique_id']); ?>">Create Invoice</a>
                        
                    <?php elseif ($row['invoice_paid'] == 1 && $row['invoice_dhm_extend'] == 0) : // Tapi kalo udah ada, tinggal extend ?>
                    
                    	<a name="<?php echo $row['invoice_id']; ?>" rel="<?php echo $period; ?> months" class="button inside extend" id="dhm-extend-<?php echo $row['unique_id']; ?>" href="<?php echo base_url('admin/dhm/extend/' . $row['unique_id']); ?>">Extend</a>
                        
                        
                    <?php elseif ($row['invoice_paid'] == 0) : ?>
                    <a href="<?php echo base_url('admin/invoice/view/' . $row['invoice_unique_id']); ?>"><?php echo $row['invoice_number']; ?></a>
                    <?php endif; ?>
					*/ ?>
                    <?php endif; ?>
                </td>
                <td><?php echo $row['domain_name']; ?></td>
                <td>
                	<a href="<?php echo prep_url($row['hosting_cpanel_url']); ?>" target="_blank"><?php echo $row['hosting_name']; ?></a>
                    <a style="display:block; float:right;" href="<?php echo base_url('admin/hosting/view/' . $row['hosting_unique_id']); ?>"><img src="<?php echo base_url('images/open-new-tab.png'); ?>" /></a>
                </td>
                <td><?php echo $row['hosting_cpanel_username']; ?></td>
                <td><?php echo $row['hosting_cpanel_password']; ?></td>
                <td><?php echo $row['bank_name']; ?></td>
                <td class="dhm-start"><?php echo date('d M Y', strtotime($row['dhm_start'])); ?></td>
                <td class="dhm-end-date"><?php echo date('d M Y', strtotime($row['dhm_end'])); ?></td>
                <td><?php echo number_format($row['dhm_price']); ?></td>
                <?php table_end($row); ?>
            </tr>
            <?php $x++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
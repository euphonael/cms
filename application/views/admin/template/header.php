<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?> | Content Management System</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/admin-stylesheet.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/jquery-ui.min.css'); ?>" />
<?php foreach ($css as $stylesheet) : ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/' . $stylesheet . '.css'); ?>" />
<?php endforeach; ?>
<script type="text/javascript">var base_url = '<?php echo base_url(); ?>'; </script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-1.10.2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/function.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/admin/global.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery.validate.min.js'); ?>"></script>
<?php foreach ($js as $javascript) : ?>
<script type="text/javascript" src="<?php echo base_url('js/' . $javascript . '.js'); ?>"></script>
<?php endforeach; ?>
</head>

<body>

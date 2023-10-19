<?php
	$styles = array(
		'bootstrap/css/bootstrap.min.css',
		'css/navbar.css',
		//'css/btn-menu.css',
		//'css/bootstrap-editable.css',
		'css/main-style.css',
		'css/bootstrap-datepicker3.css',
		'css/select2.css',
		'css/select2-bootstrap.css',
		'css/bootstrap-switch.css',
		'css/font-awesome.min.css',
	);

	foreach($styles as $style) : 
?>
	
	<link href="<?php echo base_url() . $style;?>" rel="stylesheet">

<?php endforeach; ?>

<style media='print' type='text/css'>
	body {
		padding: 10px;
	}
</style>
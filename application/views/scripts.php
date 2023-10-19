<?php
	$scripts = array(
		'bootstrap/js/bootstrap.min.js',
		'js/Chart.min.js',
		'js/tooltip.js',
		'js/passEye.js',
		'js/charRemaining.js',
		'js/jquery.maskedinput.min.js',
		'js/bootstrap-datepicker.min.js',
		'js/bootstrap-datepicker.ru.min.js',
		'js/select2.min.js',
		//'js/ru.js',
		//'js/bootstrap-editable.min.js',
		'js/mindmup-editabletable.js',
		'js/bootstrap-switch.min.js',
		'js/bootstrap-contextmenu.js',
		//'js/legend.js',
	);

?>
	<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

<?php foreach($scripts as $script) : ?>
	
	<script src="<?php echo base_url() . $script;?>" type="text/javascript"></script>

<?php endforeach; ?>

<div class="container">
	<?php if(isset($error)) {?>
	<div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
	<?php }?>
	<span id="show-timetable" onclick="location.href='<?php echo base_url();?>';" class="a-block"
						title="На главную">На главную страницу</span>
</div>
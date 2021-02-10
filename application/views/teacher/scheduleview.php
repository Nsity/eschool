<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-calendar"></i> Расписание</h3>
	<div class="well">
		<div class="row">
		<?php
			$days = array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");
			for($i = 1; $i <= count($days); $i++) :
		?>
			<div class="col-md-2">
			
			<?php echo "<strong>".$days[$i-1]."</strong></br>";?>

			<?php if(!array_key_exists($i, $timetable)) : ?>
				<span style="font-size: 10px; "><?php echo "Занятий нет"; ?></span>
			<?php else: ?>
				<?php foreach ($timetable[$i] as $timetableforDay) : ?>
					<span style="font-size: 10px;"><?php echo $timetableforDay['time']; ?></span>
					<?php echo " "; ?>
					<span style="font-size: 10px;"><?php echo $timetableforDay['subject']."</br>"; ?></span>
				<?php endforeach; ?>
			<?php endif; ?>

			</div>
		<?php endfor; ?>
		</div>
	</div>
</div>
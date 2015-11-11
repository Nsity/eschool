<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-calendar"></i> Расписание</h3>
	<div class="well">
	<div class="row">
	<?php
		$days=array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");
		for($i = 1; $i <= 6; $i++) {
			?>
			<div class="col-md-2">
			<?php
			echo "<strong>".$days[$i-1]."</strong></br>";
			if(empty($timetable[$i])) {
				?><span style="font-size: 10px; "><?php echo "Занятий нет";?></span><?
			} else {
			for($y = 1; $y < 10; $y++) {
				if(isset($timetable[$i][$y]['subject'])) {
					?>
					<span style="font-size: 10px;"><?php echo $timetable[$i][$y]['time']; ?></span>
					<?php
						echo " ";
						?>
					<span style="font-size: 10px;"><?php echo $timetable[$i][$y]['subject']."</br>"; ?></span>
				<?php }
			}}?>
	</div>
			<?php
		}
		 ?>
	</div>
	</div>
</div>
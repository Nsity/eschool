<div class="container">
<?php
	function setColor($mark) {

		if ($mark >= 4.5) {
			echo '<span class="green">'.$mark.'</span>';
		}
		if ($mark < 4.5 && $mark >=3.5) {
			echo '<span class="yellow">'.$mark.'</span>';
		}
		if ($mark < 3.5 && $mark >= 2.5) {
			echo '<span class="blue">'.$mark.'</span>';
		}
		if ($mark < 2.5 && $mark > 0) {
			echo '<span class="red">'.$mark.'</span>';
		}
		if ($mark == 0) {
			echo '<span class="grey">'.$mark.'</span>';
		}
	}


	function setGreyColor($mark) {
		if ($mark == 0) {
			echo '<span class="grey">'.$mark.'</span>';
		}
		else {
			echo '<span><strong>'.$mark.'</strong></span>';
		}
	}

	?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<form action="" method="POST">
				Учебный год
				<select id="year" name="year" onchange="this.form.submit();" >
						<?php
							foreach ($years as $key => $value) { ?>
									<option value="<?php echo $key?>"><?php echo $years[$key]; ?> гг.</option>
									<?php
								}
						?>
					</select>
			</form>
			<form action="" method="POST">
				Период
				<select id="period" name="period" onchange="this.form.submit();">
						<?php
							foreach ($periods as $key => $value) {
									?>
									<option value="<?php echo $key?>"><?php echo $periods[$key]['name']; ?></option>
									<?php
								}
						?>
					</select>
			</form>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered numeric">
				<thead>
					<tr>
						<th rowspan="2">#</th>
						<th rowspan="2">Предмет</th>
						<th colspan="2" style=" text-align: center;">Пропуски</th>
						<th colspan="3" style=" text-align: center;">Средний балл по классу</th>
						<th colspan="3" style=" text-align: center;">Число обучающихся класса,</br>имеющих показатели</th>
					</tr>
					<tr >
						<th style="border-bottom-width: 1px;">Всего</th>
						<th style="border-bottom-width: 1px;">Из них по</br>болезни</th>
						<th style="border-bottom-width: 1px;">мин. по</br>классу</th>
						<th style="border-bottom-width: 1px;">учащегося</th>
						<th style="border-bottom-width: 1px;">макс. по</br>классу</th>
						<th style="border-bottom-width: 1px;">ниже</th>
						<th style="border-bottom-width: 1px;">такие же</th>
						<th style="border-bottom-width: 1px;">выше</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(isset($stat)) {
							$i = 1;
							foreach ($stat as $key => $value) {
						?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $stat[$key]["subject"];?></td>
						<td><?php setGreyColor($stat[$key]["pass"]);?></td>
						<td><?php setGreyColor($stat[$key]["ill"]);?></td>
						<td><?php setColor($stat[$key]["min"]);?></td>
						<td><?php setColor($stat[$key]["average"]);?></td>
						<td><?php setColor($stat[$key]["max"]);?></td>
						<td><?php setGreyColor($stat[$key]["min_count"]);?></td>
						<td><?php setGreyColor($stat[$key]["same_count"]);?></td>
						<td><?php setGreyColor($stat[$key]["max_count"]);?></td>
					</tr>
					<?php
						$i++; } }?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		if(!isset($stat)) {
	?>
	<div class="alert alert-info" role="alert">Данных нет</div>
	<?php } ?>
</div>


<script type="text/javascript">
  document.getElementById('year').value = "<?php  echo $this->uri->segment(3);?>";
  document.getElementById('period').value = "<?php  echo $this->uri->segment(4);?>";
</script>
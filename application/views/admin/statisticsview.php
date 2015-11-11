<?php
	function setColor($mark, $tooltip) {
			switch ($mark) {
				case 5: echo '<span data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="label label-success">'.$mark.'</span>'; break;
				case 4: echo '<span data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="label label-warning">'.$mark.'</span>'; break;
				case 3: echo '<span data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="label label-primary">'.$mark.'</span>';  break;
				case 2: echo '<span data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="label label-danger">'.$mark.'</span>'; break;
			}
	}
?>
<div class="container">
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-4">
			<form method="post">
				<label for="year" class="control-label"><i class="fa fa-clock-o"></i> Год</label>
				<select id="year" name="year" onchange="this.form.submit();" style="width: 70%;">
					<?php
						foreach ($years as $year) {
								?>
								<option value="<?php echo $year['YEAR_ID'];?>"><?php echo date("Y", strtotime($year['YEAR_START'])).' - '.date("Y", strtotime($year['YEAR_FINISH']))." гг."; ?></option><?php
								}
						?>
				</select>
			</form>
		</div>
		<div class="col-md-8">
			<form method="post">
				<label for="period" class="control-label"><i class="fa fa-calendar"></i> Период</label>
				<select id="period" name="period" onchange="this.form.submit();" style="width: 30%;">
					<?php
						foreach ($periods as $period) {
								?>
								<option value="<?php echo $period['PERIOD_ID'];?>"><?php echo $period['PERIOD_NAME']; ?></option><?php
								}
						?>
				</select>
			</form>
		</div>
	</div>
	<div class="row">
	    <div class="col-md-8">
		    <h3 class="sidebar-header">Успеваемость <strong><?php if(isset($name)) echo $name;?></strong></h3>
		</div>
	    <div class="col-md-4" >
		    <h5><span onclick="print();" class="a-block pull-right" title="Печать"><i class="fa fa-print"></i> Печать</span></h5>
	    </div>
    </div>
	<div class="panel panel-default">
	    <div class="table-responsive">
			<table class="table table-striped table-hover table-bordered numeric">
				<thead>
					<tr>
						<th rowspan="2">#</th>
						<th rowspan="2">Класс</th>
						<th rowspan="2">Всего</th>
						<th colspan="2" style=" text-align: center;"><span class="green">Отличники</span></th>
						<th colspan="2" style=" text-align: center;"><span class="yellow">Хорошисты</span></th>
						<th colspan="2" style=" text-align: center;"><span class="blue">Троечники</span></th>
						<th colspan="2" style=" text-align: center;"><span class="red">Неуспевающие</span></th>
					</tr>
					<tr>
						<th style="width: 10%; border-bottom-width: 1px;">Всего</th>
						<th style="width: 10%; border-bottom-width: 1px;">%</th>
						<th style="width: 10%; border-bottom-width: 1px;">Всего</th>
						<th style="width: 10%; border-bottom-width: 1px;">%</th>
						<th style="width: 10%; border-bottom-width: 1px;">Всего</th>
						<th style="width: 10%; border-bottom-width: 1px;">%</th>
						<th style="width: 10%; border-bottom-width: 1px;">Всего</th>
						<th style="width: 10%; border-bottom-width: 1px;">%</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for($i = 0; $i < count($result); $i++) {
						 ?>
					<tr style="cursor: pointer; cursor: hand;" onclick="location.href='<?php echo base_url();?>admin/progress/<?php echo $result[$i]["class_id"]; ?>'">
						<td><?php echo $i+1; ?></td>
						<td><?php echo $result[$i]["class_name"]; ?></td>
						<td><strong><?php echo $result[$i]["count"]; ?></strong></td>
						<?php  for($y = 5; $y >= 2; $y--) { ?>
						<td>
							<?php echo $result[$i][$y]['mark'];  ?></td>
						<td><?php if ($result[$i]["count"] != 0) echo round($result[$i][$y]['mark'] / $result[$i]["count"] * 100); else echo "0"; ?></td>
						<?php } ?>
					</tr>
					<?php
						} ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php if(isset($pass1)) {  ?><span>Самый болеющий класс <?php echo $pass1; ?></span><?php } ?>
</div>

<script type="text/javascript">
	document.getElementById('year').value = "<?php  echo $this->uri->segment(3);?>";
	document.getElementById('period').value = "<?php  echo $this->uri->segment(4);?>";
	$("#year").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});
	$("#period").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});

</script>
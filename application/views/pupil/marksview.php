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
				<label for="class" class="control-label"><i class="fa fa-clock-o"></i> Год</label>
				<select id="class" name="class" onchange="this.form.submit();" style="width: 70%;">
					<?php
						foreach ($classes as $class) {
								?>
								<option value="<?php echo $class['CLASS_ID'];?>"><?php echo $class['YEAR_START']." - ".$class['YEAR_FINISH']." гг."; ?></option><?php
								}
						?>
				</select>
			</form>
		</div>
		<div class="col-md-8">
			<form method="post">
				<label for="period" class="control-label"><i class="fa fa-calendar"></i> Период</label>
				<select id="period" name="period" onchange="this.form.submit();" style="width: 30%;" >
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
		    <h3 class="sidebar-header">Оценки и пропуски</h3>
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
						<th class="col-md-2" rowspan="2">Предмет</th>
						<th rowspan="2">Оценки</th>
						<th colspan="3" style=" text-align: center;">Пропуски</th>
					</tr>
					<tr>
						<th style="width: 10%; border-bottom-width: 1px;">по болезни</th>
						<th style="width: 10%; border-bottom-width: 1px;">по неуваж.</br>причине</th>
						<th style="width: 10%; border-bottom-width: 1px;">по уваж.</br>причине</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for($i = 0; $i < count($progress); $i++) {
						 ?>
					<tr>
						<td><?php echo $i+1; ?></td>
						<td><?php echo $progress[$i]["subject"]; ?></td>
						<td>
							<?php
								for ($y =0; $y < count($progress[$i]["marks"]); $y++) {
									setColor($progress[$i]["marks"][$y]["mark"], $progress[$i]["marks"][$y]["type"]);
									echo " ";
								}
								?>
						</td>
						<td><?php if(isset($progress[$i]["pass"]['б'])) echo "<strong>".$progress[$i]["pass"]['б']."</strong>"; else echo "<span class='grey'>н/д</span>"; ?></td>
						<td><?php if(isset($progress[$i]["pass"]['н'])) echo "<strong>".$progress[$i]["pass"]['н']."</strong>"; else echo "<span class='grey'>н/д</span>"; ?></td>
						<td><?php if(isset($progress[$i]["pass"]['у'])) echo "<strong>".$progress[$i]["pass"]['у']."</strong>"; else echo "<span class='grey'>н/д</span>"; ?></td>
					</tr>
					<?php
						} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	document.getElementById('class').value = "<?php  echo $this->uri->segment(3);?>";
	$("#class").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});

	document.getElementById('period').value = "<?php  echo $this->uri->segment(4);?>";
	$("#period").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});

</script>
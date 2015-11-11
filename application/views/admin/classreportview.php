<?php
	function setColor($mark) {
			switch ($mark) {
				case 5: echo '<span class="green">'.$mark.'</span>'; break;
				case 4: echo '<span class="yellow">'.$mark.'</span>'; break;
				case 3: echo '<span class="blue">'.$mark.'</span>';  break;
				case 2: echo '<span class="red">'.$mark.'</span>'; break;
				default: echo '<span class="grey">'.$mark.'</span>';  break;

			}
	}
?>
<div class="container">
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-4">
			<form method="post">
				<label for="period" class="control-label"><i class="fa fa-calendar"></i> Период</label>
				<select id="period" name="period" onchange="this.form.submit();" style="width: 70%;" >
			<?php
				foreach ($periods as $period) {?>
					<option value="<?php echo $period['PERIOD_ID'];?>"><?php echo $period['PERIOD_NAME']; ?></option><?php
						}?>
	            </select>
	        </form>
	    </div>
		<div class="col-md-8">
		</div>
	</div>
	<div class="row">
	    <div class="col-md-8">
		    <h3 class="sidebar-header">Итоговый отчет <strong><?php echo $class_name;?></strong></h3>
		</div>
	    <div class="col-md-4" >
		    <h5><span onclick="print();" class="a-block pull-right" title="Печать"><i class="fa fa-print"></i> Печать</span></h5>
	    </div>
    </div>
	<div class="panel panel-default">
	    <div class="table-responsive">
			<table class="table table-striped table-hover table-bordered numeric">
				<thead >
					<tr>
						<th>#</th>
						<th>ФИО учащегося</th>
						<?php
							foreach($subjects as $subject) {
							 ?>
							 <th class="rotate"><div><span><?php echo $subject['SUBJECT_NAME']; ?></span></div></th>
							 <?php
							}
						?>
						<th class="rotate"><div><span>Средний балл</span></div></th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i = 0; $i < count($progress); $i++) {
						 ?>
					<tr>
						<td><?php echo $i+1; ?></td>
						<td><?php echo $progress[$i]["pupil"]; ?></td>
						<?php
							$s = 0;
							$k = 0;
							if(isset($progress[$i]["mark"])) {
								for($y = 0; $y < count($progress[$i]["mark"]); $y++) {
									?>
									<td><?php if(isset($progress[$i]["mark"][$y])) {
										 setColor($progress[$i]["mark"][$y]);
										 $s = $s + $progress[$i]["mark"][$y];
										 $k++;
										 }
										else setColor("н/д");
										 ?></td>
									<?php
								}
							}
						?>
						<td><?php if($k != 0) { ?><strong><?php echo number_format($s / $k, 1); ?></strong><?php } else echo "<span class='grey'>н/д</span>"; ?></td>
					</tr>
					<?php }?>
					<tr>
						<td></td>
						<td><strong>Средний балл по предмету</strong></td>
						<?php if(isset($average)) {
							for ($i = 0; $i < count($average); $i++) { ?>
						<td><?php if(isset($average[$i]) && $average[$i] != 0) echo "<strong>".$average[$i]."</strong>"; else echo "<span class='grey'>н/д</span>"; ?></td>
						<?php } }?>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	document.getElementById('period').value = "<?php  echo $this->uri->segment(4);?>";
	$("#period").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});

</script>
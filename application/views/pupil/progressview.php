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
				<label for="year" class="control-label"><i class="fa fa-calendar"></i> Год</label>
				<select id="year" name="year" onchange="this.form.submit();" style="width: 60%;">
					<?php
						foreach ($years as $key => $value) {
								?>
								<option value="<?php echo $key?>"><?php echo $years[$key]; ?> гг.</option><?php
								}
						?>
				</select>
		    </form>
		</div>
		<div class="col-md-8"></div>
	</div>
	<div class="row">
	    <div class="col-md-8">
		    <h3 class="sidebar-header">Итоговые оценки</h3>
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
						<th >#</th>
						<th >Предметы</th>
						<th >I</th>
						<th >II</th>
						<th >III</th>
						<th>IV</th>
						<th >Год</th>
					</tr>
				</thead>
				<tbody>
						    <?php
							    $i = 1;
							    if (isset($result)) {
							    foreach ($result as $key => $value) {?>
								    <tr>
								    <td ><?php echo $i++;?></td>
								    <td><?php echo $result[$key]["subject"];?></td>
								   <!-- <td><?php echo $result[$key][1];?></td>-->
								    <td><?php if(isset($result[$key]["I четверть"])) setColor($result[$key]["I четверть"]); else echo "<span class='grey'>н/д</span>"?></td>
								   <td><?php if(isset($result[$key]["II четверть"])) setColor($result[$key]["II четверть"]); else echo "<span class='grey'>н/д</span>" ?></td>
								    <td><?php if(isset($result[$key]["III четверть"])) setColor($result[$key]["III четверть"]); else echo "<span class='grey'>н/д</span>" ?></td>
								    <td><?php if(isset($result[$key]["IV четверть"])) setColor($result[$key]["IV четверть"]); else echo "<span class='grey'>н/д</span>" ?></td>
								    <td><?php if(isset($result[$key]["Итоговая"])) setColor($result[$key]["Итоговая"]); else echo "<span class='grey'>н/д</span>" ?></td>
								    </tr>
								<?php }}
						    ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		if(!isset($result)) {
	?>
	<div class="alert alert-info" role="alert">Данных нет</div>
	<?php } ?>
</div>

<script type="text/javascript">

  document.getElementById('year').value = "<?php  echo $this->uri->segment(3);?>";
  $("#year").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});
</script>

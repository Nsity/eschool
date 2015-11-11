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
		    <h3 class="sidebar-header">Итоговый отчет</h3>
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
	<h3 class="sidebar-header">Гистограмма посещаемости</h3>
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-12">
			<div style="background:white;"><canvas id="myChart"></canvas></div>
		</div>
	</div>
	<table class="brand-table">
		<tr>
			<td><div class="color-swatch brand-warning"></div></td>
			<td>Пропуски по неуважительной причине</td>
		</tr>
		<tr>
			<td><div class="color-swatch brand-info"></div></td>
			<td>Пропуски по уважительной причине</td>
		</tr>
		<tr>
			<td><div class="color-swatch brand-success"></div></td>
			<td>Пропуски по болезни</td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	document.getElementById('period').value = "<?php  echo $this->uri->segment(3);?>";
	$("#period").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});

	var passes = document.getElementById("myChart").getContext("2d");
		   // alert("wefef");
    var base_url = '<?php echo base_url();?>';
    var period = $('#period').find("option:selected").val();
		//alert(period);
	    $.ajax({
		    type: "POST",
		    url: base_url + "api/getallpasses/" + period,
		    cache: false,
		    success: function(data){
			    //alert(data);
				//$('#answer').html(data);
				  var json_obj = JSON.parse(data);
				    var description = new Array();
				    var myvalues1 = new Array();
				    var myvalues2 = new Array();
				    var myvalues3 = new Array();

				    for (var i in json_obj) {
					    description.push(json_obj[i].name);
					    myvalues1.push(json_obj[i].pass[1]);
					    myvalues2.push(json_obj[i].pass[2]);
					    myvalues3.push(json_obj[i].pass[3]);
					}
					var data = {
						labels: description,
						datasets: [
						{
							label: "Пропуски по неуважительной причине",
							fillColor: "#fcf8e3",
							strokeColor: "#8a6d3b",
							data: myvalues1
						},
						{
							label: "Пропуски по уважительной причине",
							fillColor: "#d9edf7",
							strokeColor: "#31708f",
							data: myvalues2
					    },
					    {
						    label: "Пропуски по болезни",
						    fillColor: "#dff0d8",
						    strokeColor: "#3c763d",
						    data: myvalues3
						}
					]};
					var options = {
						animation: false,
						responsive: true,
						maintainAspectRatio: true
					};
					new Chart(passes).Bar(data, options);
					//legend(document.getElementById('placeholder'), data);


			    }
			});

</script>
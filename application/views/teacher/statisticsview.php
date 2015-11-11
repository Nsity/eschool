<div class="container">
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-4">
			<form method="post">
				<label for="class" class="control-label"><i class="fa fa-users"></i> Класс</label>
				<select id="class" name="class" onchange="this.form.submit();" style="width: 70%">
						<?php
							foreach ($classes as $class) {
								if(isset($class['YEAR_ID'])) $year_border = " (".date("Y",strtotime($class['YEAR_START']))." - ".date("Y",strtotime($class['YEAR_FINISH']))." гг.)"; else $year_border = '';
							?>
									<option value="<?php echo $class['CLASS_ID']?>"><?php echo $class['CLASS_NUMBER']." ".$class['CLASS_LETTER'].$year_border; ?></option>
									<?php
								}
						?>
				</select>
			</form>
		</div>
		<div class="col-md-8">
			<form method="post">
				<label for="subject" class="control-label"><i class="fa fa-book"></i> Предмет</label>
				<select id="subject" name="subject" onchange="this.form.submit();" style="width: 50%">
						<?php
							foreach ($subjects as $subject) {
									?>
									<option value="<?php echo $subject['SUBJECTS_CLASS_ID']?>"><?php echo $subject['SUBJECT_NAME']; ?></option>
									<?php
								}
						?>
				</select>
			</form>
		</div>
	</div>
	<h3 class="sidebar-header">Статистика</h3>
	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Период</th>
						<th>На "5"</th>
						<th>На "4"</th>
						<th>На "3"</th>
						<th>На "2"</th>
						<th>Усп. %</th>
						<th>Кач. %</th>
				   </tr>
				</thead>
				<tbody>
					<?php if(isset($stat)) {
							for($i = 0; $i < count($stat); $i++) { ?>
							<tr>
								<td><strong><?php echo $stat[$i]["period"]; ?></strong></td>
								<td><?php if(isset($stat[$i]["5"])) echo $stat[$i]["5"]; ?></td>
								<td><?php if(isset($stat[$i]["4"])) echo $stat[$i]["4"]; ?></td>
								<td><?php if(isset($stat[$i]["3"])) echo $stat[$i]["3"]; ?></td>
								<td><?php if(isset($stat[$i]["2"])) echo $stat[$i]["2"]; ?></td>
								<td><?php if(isset($stat[$i]["ach"])) echo $stat[$i]["ach"]; ?></td>
								<td><?php if(isset($stat[$i]["quality"])) echo $stat[$i]["quality"]; ?></td>
							</tr>
					<?php }} ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-4">
			<label for="period" class="control-label"><i class="fa fa-calendar"></i> Период</label>
			<select id="period" style="width: 60%;">
			<?php
			    foreach ($periods as $period) {
							?>
							<option value="<?php echo $period['PERIOD_ID']?>"><?php echo $period['PERIOD_NAME']; ?></option>
									<?php
								}
			?>
			</select>
		</div>
		<div class="col-md-8"></div>
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
	$(document).ready(function() {
		document.getElementById('class').value = "<?php echo $this->uri->segment(3);?>";
		document.getElementById('subject').value = "<?php echo $this->uri->segment(4);?>";

		$("#class").select2({
			language: "ru"
		});
		$("#subject").select2({
			language: "ru"
		});


		var passes = document.getElementById("myChart").getContext("2d");



	    $('#period').change(function(){
		   // alert("wefef");
		    var base_url = '<?php echo base_url();?>';
		    var period = $(this).find("option:selected").val();
		    var subject = $("#subject").find("option:selected").val();
		    var class_id = $("#class").find("option:selected").val();
		    $.ajax({
			    type: "POST",
			    url: base_url + "api/getpasses/" + period+ "/" + subject + "/" + class_id,
			    cache: false,
			    success: function(data){
				   // $('#answer').html(data);
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
		}).change();

	});

	$("#period").select2({
			minimumResultsForSearch: Infinity,
			language: "ru"
		});
</script>
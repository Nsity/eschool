<?php
	function showDate($date) {
		$day = date('d', strtotime($date));
		$mounth = date('m', strtotime($date));
		$year = date('Y', strtotime($date));
		$data = array('01'=>'Январь','02'=>'Февраль','03'=>'Март','04'=>'Апрель','05'=>'Май','06'=>'Июнь',
		'07'=>'Июль', '08'=>'Август','09'=>'Сентябрь','10'=>'Октябрь','11'=>'Ноябрь','12'=>'Декабрь');
		foreach ($data as $key=>$value) {
			if ($key==$mounth) echo "$value ".ltrim($day, '0').", $year";
		}
	}
	?>

<div class="container">
	<div class="row">
		<div class="col-md-4">
			<h3 class="sidebar-header"><i class="fa fa-clock-o"></i> <?php showDate(date('Y-m-d'));?></h3>
			<div class="panel panel-default">
			    <div class="table-responsive">
					<table name="timetable" class="table table-striped">
						<thead>
							<tr>
								<th>Время</th>
								<th>Предмет</th>
								<th>Каб.</th>
						    </tr>
						</thead>
						<tbody>
							<?php
								for ($k=0; $k < count($timetable); $k++)  {
								?>
							<tr>
							    <td id="time"><?php echo date("H:i", strtotime($timetable[$k]["start"]));?></td>
							    <td><?php echo $timetable[$k]["name"];?></td>
							    <td id="room"><?php echo $timetable[$k]["room"]; }?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="panel-body">
					<span id="show-timetable" onclick="location.href='<?php echo base_url();?>pupil/timetable';" class="a-block"
						title="Показать расписание">Смотреть расписание на всю неделю</span>
				</div>
			</div>
			<h3 class="sidebar-header"><i class="fa fa-bar-chart"></i> Средний балл по предметами на сегодня</h3>
			<div class="panel panel-default" id="todayaverages">
				<div class="panel-body">
					<div><canvas id="myChart1" hidden="true" style="width: 200px; height: 200px;" ></canvas></div>
					<span id="no-data1" style="display: block; text-align: center;"></span>
					<span onclick="location.href='<?php echo base_url();?>pupil/statistics';" class="a-block" title="Перейти в статистику">Перейти в статистику</a>
				</div>
			</div>
			<h3 class="sidebar-header"><i class="fa fa-pie-chart"></i> Полученные сегодня оценки</h3>
			<div class="panel panel-default" id="todaymarks">
				<div class="panel-body">
					<div><canvas id="myChart" hidden="true" ></canvas></div>
					<span id="no-data" style="display: block; text-align: center;"></span>
					<span onclick="location.href='<?php echo base_url();?>pupil/diary';" class="a-block" title="Перейти в дневник">Перейти в дневник</span>
				</div>
			</div>
		</div>



<script type="text/javascript">
	$(document).ready(function() {
		var marks = document.getElementById("myChart").getContext("2d");

		var base_url = '<?php echo base_url();?>';

		$.ajax({
			type: "POST",
			url: base_url + "api/todaymarks" ,
			cache: false,
			success: function(data){
				//alert(data);
				if(JSON.parse(data) == null || JSON.parse(data) == 'error') {
					$('#myChart').attr('hidden', true);
					$('#no-data').text("Нет данных");
				} else {
					$('#myChart').attr('hidden', false);
					$('#no-data').text("");

					var data = JSON.parse(data);
					var data = [
					{
						value: data[5],
						color:"#5cb85c",
						label: "Кол-во пятерок"
					},
					{
						value: data[4],
						color: "#ec971f",
						label: "Кол-во четверок"
					},
					{
						value: data[3],
						color: "#337ab7",
						label: "Кол-во троек"
					},
					{
						value: data[2],
						color: "#d9534f",
						label: "Кол-во двоек"
					}
					];
					var options = {
						animation: false,
						responsive: true,
						maintainAspectRatio: true
					};
					new Chart(marks).Pie(data, options);
				}
		    }
		});



		var averages = document.getElementById("myChart1").getContext("2d");
		$.ajax({
			type: "POST",
			url: base_url + "api/todayaverages" ,
			cache: false,
			success: function(data){

				if(JSON.parse(data) == null || JSON.parse(data) == 'error') {
					$('#myChart1').attr('hidden', true);
					$('#no-data1').text("Нет данных");
				} else {
					$('#myChart1').attr('hidden', false);
					$('#no-data1').text("");
					var data = JSON.parse(data);

					var description = new Array();
					var myvalues = new Array();

					for (i = 1; i <= Object.keys(data).length; i++) {
						//alert(Object.keys(data).length);
						//alert(data[i].subject);
						description.push(data[i].subject);
						myvalues.push(data[i].mark);
						//alert(data[i].mark);
					}
					var step  = 1;
					var max   = 5;
					var start = 0;
					var options = {
						animation: false,
						responsive: true,
						maintainAspectRatio: true/*,
						scaleOverride: true,
						scaleSteps: Math.ceil((max-start)/step),
						scaleStepWidth: step,
						scaleStartValue: start*/
					};

					var data = {
						labels: description,
						datasets: [
						{
							label: "Средние баллы",
							fillColor: "rgba(220,220,220,0.5)",
							strokeColor: "rgba(220,220,220,0.8)",
							data: myvalues
						},
					]};

					window.myObjBar = new Chart(averages).Bar(data, options);

					for(i = 0; i < myvalues.length; i++) {
						if (myvalues[i] >= 4.5) {
							myObjBar.datasets[0].bars[i].fillColor = "#5cb85c";
						}
						if (myvalues[i] < 4.5 && myvalues[i] >= 3.5){
							myObjBar.datasets[0].bars[i].fillColor = "#ec971f";
						}
						if(myvalues[i] < 3.5 && myvalues[i] >= 2.5) {
							myObjBar.datasets[0].bars[i].fillColor = "#337ab7";
						}
						if(myvalues[i] < 2.5 && myvalues[i] > 0) {
							myObjBar.datasets[0].bars[i].fillColor = "#d9534f";
						}
						if (myvalues[i] = 0) {
							myObjBar.datasets[0].bars[i].fillColor = "grey";
						}
					}
					myObjBar.update();
				}
		    }
		});

    });
</script>

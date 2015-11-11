<div class="container">
	<div class="row">
			<?php
				for ($i = 1; $i <= 6; $i++) {
				?>
		<div class="col-xs-12 col-md-4">
			<h3 class="sidebar-header"><i class="fa fa-calendar"></i> <?php echo $days[$i-1]?></h3>
			<div class="panel panel-default">
				<div class="table-responsive">
					<table class="table table-striped">
			    		<thead>
							<tr>
								<th style="width: 30%">Время</th>
								<th style="width: 50%">Предмет</th>
								<th style="width: 20%">Каб.</th>
							</tr>
						</thead>
						<tbody>
							<?php
								for ($k = 0; $k < count($timetable[$i-1]); $k++)  {
								?>
							<tr>
								<td id="time" class="timetable-time" style="vertical-align: middle;"><?php echo date("H:i", strtotime($timetable[$i-1][$k]["start"])).' - '
									.date("H:i",strtotime($timetable[$i-1][$k]["finish"]));?></td>
								<td><?php echo $timetable[$i-1][$k]["name"];?></td>
								<td id="room"><?php echo $timetable[$i-1][$k]["room"]; }?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
        </div>
			<?php if ($i==3) {?>
			<div class="clearfix visible-md visible-xs visible-lg"></div>
				<?php } ?>
					<?php }?>
	</div>
</div>
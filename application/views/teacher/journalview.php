<style type="text/css">
	td  {
		cursor: pointer; cursor: hand;
	}
	td:first-child, td:nth-child(2)  {
		cursor: default;
	}
	.highlighted {
    background-color: #f5f5f5 !important;
}
</style>
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
		<div class="col-md-4">
			<form method="post">
				<label for="subject" class="control-label"><i class="fa fa-book"></i> Предмет</label>
				<select id="subject" name="subject" onchange="this.form.submit();" style="width: 70%">
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
		<div class="col-md-4">
				<button onclick="location.href='<?php echo base_url();?>teacher/lessons/<?php echo $this->uri->segment(4);  ?>';" class="btn btn-sample btn-large btn-block"
		title="Список учебных занятий" style="margin-bottom: 20px;"><i class="fa fa-list"></i> Список учебных занятий</button>
		</div>
	</div>

    <?php echo $this->pagination->create_links(); ?>
    <div class="row">
	    <div class="col-md-8">
		    <h3 class="sidebar-header"><i class="fa fa-bookmark"></i> Журнальная страница</h3>
		</div>
	    <div class="col-md-4" >
		    <h5><span onclick="location.href='<?php echo base_url();?>teacher/lesson/<?php echo $this->uri->segment(4);?>';" class="a-block pull-right" title="Добавить учебное занятие"><i class="fa fa-plus"></i> Добавить занятие</span></h5>
	    </div>
    </div>
	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered numeric">
				<thead>
					<tr>
						<th>#</th>
						<th>ФИО учащегося</th>
						<?php foreach($lessons as $lesson) { ?>
						<th data-toggle="tooltip" data-placement="top" data-container="body" title="<?php echo $lesson['LESSON_THEME']; ?>" style="cursor: pointer; cursor: hand;" onclick="document.location.href = '<?php  echo base_url(); ?>teacher/lessonpage/<?php echo $this->uri->segment(4);?>/<?php echo $lesson['LESSON_ID']; ?>'"><?php echo date('d.m', strtotime($lesson['LESSON_DATE']))."</br>".date('H:i', strtotime($lesson['TIME_START']));?>
						</th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
						<?php
								for($i = 0; $i <count($result); $i++){
									?>
						<tr>
							<td><?php echo $i+1; ?></td>
							<td><?php echo $result[$i]["pupil_name"];?></td>
									<?php if(isset($result[$i]["lessons"])) {
										for($y = 0; $y < count($result[$i]["lessons"]); $y++) { ?>
							<td <?php if(isset($result[$i]["lessons"][$y]["pass"])) {
										switch($result[$i]["lessons"][$y]["pass"]) {
										    case 'н': {
										        ?>class="warning"<?php
										        break;
									        }
										    case 'б': {
											    ?>class="success"<?php
												break;
											}
											case 'у': {
											    ?>class="info"<?php
												break;
										    }
									    } } ?>><?php
										for($z = 0; $z < count($result[$i]["lessons"][$y]["marks"]); $z++) {
											//echo $result[$i]["lessons"][$y]["marks"][$z]["mark"];
											setColor($result[$i]["lessons"][$y]["marks"][$z]["mark"], $result[$i]["lessons"][$y]["marks"][$z]["type"]);
											echo " ";
										}
									?>
							</td>
									<?php }?>
							</tr>
									<?php
								}}
							?>
					</tbody>
				</table>
			</div>
		</div>
	<table style="margin-bottom: 20px;">
		<tr>
			<td><div class="color-swatch brand-success"></div></td>
			<td>Пропуск по болезни</td>
		</tr>
		<tr>
			<td><div class="color-swatch brand-info"></div></td>
			<td>Пропуск по уважительной причине</td>
		</tr>
		<tr>
			<td><div class="color-swatch brand-warning"></div></td>
			<td>Пропуск по неуважительной причине</td>
		</tr>
	</table>

			<!--Календарь
			<div id="datepicker" data-date="12/03/2012"></div>
		    <input type="hidden" id="my_hidden_input" />-->

</div>

<script type="text/javascript">
	$(document).ready(function() {
		document.getElementById('class').value = "<?php echo $this->uri->segment(3);?>";
		document.getElementById('subject').value = "<?php echo $this->uri->segment(4);?>";

		/*$('#datepicker').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    endDate: "2020-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    calendarWeeks: true,
		    todayHighlight: true
		});*/

		/*$("#datepicker").on("changeDate", function(event) {
			$("#my_hidden_input").val(
			$("#datepicker").datepicker('getFormattedDate'))
		});*/

		$("#class").select2({
			language: "ru"
		});
		$("#subject").select2({
			language: "ru"
		});

		$('table td:not(:first-child, :nth-child(2))').click(function() {
			$('table th').eq($(this).index()).click();
		});

//var period = $('table th').eq($(this).index()/2+1).text();
$('td:not(:first-child, :nth-child(2))').hover(function() {
    var t = parseInt($(this).index()) + 1;
    $(this).parents('table').find('td:nth-child(' + t + ')').addClass('highlighted');
},
function() {
    var t = parseInt($(this).index()) + 1;
    $(this).parents('table').find('td:nth-child(' + t + ')').removeClass('highlighted');
});
	});
</script>
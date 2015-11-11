<?php
	function setColor($mark) {

		if ($mark >= 4.5) {
			echo '<td class="green">'.$mark.'</td>';
		}
		if ($mark < 4.5 && $mark >=3.5) {
			echo '<td class="yellow">'.$mark.'</td>';
		}
		if ($mark < 3.5 && $mark >= 2.5) {
			echo '<td class="blue">'.$mark.'</td>';
		}
		if ($mark < 2.5 && $mark > 0) {
			echo '<td class="red">'.$mark.'</td>';
		}
		if ($mark == 0) {
			echo '<td class="grey">'.$mark.'</td>';
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
		<div class="col-md-8">
			<form method="post">
				<label for="subject" class="control-label"><i class="fa fa-book"></i> Предмет</label>
				<select id="subject" name="subject" onchange="this.form.submit();" style="width: 50%">
					<?php
						foreach ($subjects as $subject) {
								?>
						<option value="<?php echo $subject['SUBJECTS_CLASS_ID']?>"><?php echo $subject['SUBJECT_NAME']; ?></option>
							<?php } ?>
				</select>
			</form>
		</div>
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
			<table class="table table-striped table-hover table-bordered numeric" id="progress">
				<thead>
					<tr>
						<th rowspan="2">#</th>
						<th rowspan="2" hidden="true"></th>
						<th rowspan="2" >ФИО учащегося</th>
						<th colspan="2">I четверть</th>
						<th colspan="2">II четверть</th>
						<th colspan="2">III четверть</th>
						<th colspan="2">IV четверть</th>
						<th colspan="2">Итоговая</th>
					</tr>
					<tr>
						<th style="border-bottom-width: 1px;">Ср.</br>балл</th>
						<th style="border-bottom-width: 1px;">Оценка</th>
						<th style="border-bottom-width: 1px;">Ср.</br>балл</th>
						<th style="border-bottom-width: 1px;">Оценка</th>
						<th style="border-bottom-width: 1px;">Ср.</br>балл</th>
						<th style="border-bottom-width: 1px;">Оценка</th>
						<th style="border-bottom-width: 1px;">Ср.</br>балл</th>
						<th style="border-bottom-width: 1px;">Оценка</th>
						<th style="border-bottom-width: 1px;">Ср.</br>балл</th>
						<th style="border-bottom-width: 1px;">Оценка</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(isset($marks)) {
							for($i = 0; $i < count($marks); $i++) {
							?>
							<tr>
								<td data-editable='false'><?php echo $i+1;?></td>
								<td hidden="true"  data-editable='false' id="pupil_id"><?php echo $marks[$i]["pupil_id"];?></td>
								<td data-editable='false'><?php echo $marks[$i]["pupil_name"];?></td>
								<td class="grey" data-editable='false'><?php echo $marks[$i]["I четверть"]["average"];?></td>
								<?php if(isset($marks[$i]["I четверть"]["mark"])) setColor($marks[$i]["I четверть"]["mark"]); else echo "<td></td>";?>
								<td class="grey" data-editable='false'><?php echo $marks[$i]["II четверть"]["average"];?></td>
								<?php if(isset($marks[$i]["II четверть"]["mark"]))  setColor($marks[$i]["II четверть"]["mark"]); else echo "<td></td>";?>
								<td class="grey" data-editable='false'><?php  echo $marks[$i]["III четверть"]["average"];?></td>
								<?php if(isset($marks[$i]["III четверть"]["mark"])) setColor($marks[$i]["III четверть"]["mark"]); else echo "<td></td>";?>
								<td class="grey" data-editable='false'><?php  echo $marks[$i]["IV четверть"]["average"];?></td>
								<?php if(isset($marks[$i]["IV четверть"]["mark"])) setColor($marks[$i]["IV четверть"]["mark"]); else echo "<td></td>";?>
								<td class="grey" data-editable='false'><?php echo $marks[$i]["Итоговая"]["average"];?></td>
								<?php if(isset($marks[$i]["Итоговая"]["mark"]))  setColor($marks[$i]["Итоговая"]["mark"]); else echo "<td></td>";?>
							</tr>
							<?php
						}}
					?>

				</tbody>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {

		document.getElementById('class').value = "<?php echo $this->uri->segment(3);?>";
		document.getElementById('subject').value = "<?php echo $this->uri->segment(4);?>";

		$("#class").select2({
			minimumResultsForSearch: Infinity,
			language: "ru"
		});
		$("#subject").select2({
			minimumResultsForSearch: Infinity,
			language: "ru"
		});


		$('table#progress').editableTableWidget();

	    $('table td').focus(function(){
		    $(this).data('oldValue',$(this).text());
		});

	    $('table td').on('change', function(evt, newValue) {
		    var base_url = '<?php echo base_url();?>';
		    //старое значение
		    var oldValue = $(this).data('oldValue');

		    if (!(newValue == 5 || newValue == 4 || newValue == 3 || newValue == 2 || newValue == "")) {
			    return false; // reject change
			} else {
				$(this).removeClass();
				//можем редактировать
				if(newValue == 5) {
					$(this).addClass("green");
				}
				if(newValue == 4) {
					$(this).addClass("yellow");
				}
				if(newValue == 3) {
					$(this).addClass("blue");
				}
				if(newValue == 2) {
					$(this).addClass("red");
				}
				var class_id = $('#class').find("option:selected").val();
				var subject_id = $('#subject').find("option:selected").val();
				if (newValue != oldValue) {
					var pupil_id = $(this).parent().find('#pupil_id').html();
					var period = $('table th').eq($(this).index()/2+1).text();
					//alert(period);
					$.ajax({
						type: "POST",
						url: base_url + "table/changeprogress",
						data: "pupil_id=" + pupil_id + "&period=" + period + "&class_id=" + class_id + "&subject_id=" +
						subject_id + "&mark=" + newValue,
						timeout: 30000,
						async: false,
						error: function(xhr) {
							console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
						},
						success: function(response) {
							//location.reload();
					    }
					});
				}
		    }
		});

	});
</script>
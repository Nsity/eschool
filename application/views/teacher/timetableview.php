<?php
	$days = array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");
	 ?>
<div class="container">
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-6">
			<label for="day" class="control-label"><i class="fa fa-clock-o"></i> Расписание на</label>
			<select id="day" style="width: 50%;">
				<?php for ($i = 0; $i < count($days); $i++) {?>
				<option value="<?php echo $i+1; ?>"  <?php if($this->uri->segment(3) == $i+1) echo "selected"; ?>  ><?php echo $days[$i]; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-6"></div>
	</div>
	<div class="panel panel-default panel-table">
		<div class="panel-body">
			<button type="button" class="btn btn-menu" id="createButton" title="Добавить предмет в расписание"><i class="fa fa-plus fa-2x"></i>
			</br><span class="menu-item">Создать</span>
			</button>
		    <button href="" type="button" class="btn btn-menu disabled" id="editButton" title="Редактировать предмет в расписании"><i class="fa fa-pencil fa-2x"></i>
		    </br><span class="menu-item">Редактировать</span>
		    </button>
		    <button type="button" class="btn btn-menu disabled" id="deleteButton" data-toggle="modal" data-target="#myModal" title="Удалить предмет из расписания"><i class="fa fa-trash-o fa-2x"></i>
		    </br><span class="menu-item">Удалить</span>
		    </button>
		</div>
	</div>

    <!--<select id="day">
		<option value="1">Понедельник</option>
		<option value="2">Вторник</option>
		<option value="3">Среда</option>
		<option value="4">Четверг</option>
		<option value="5">Пятница</option>
		<option value="6">Суббота</option>
	</select>-->
   	<div class="panel panel-default">
	    <div class="table-responsive">
		    <table name="timetable" class="table table-striped table-hover table-bordered numeric">
			    <thead>
				    <tr>
					    <th></th>
					    <th>Время</th>
					    <th>Предмет</th>
					    <th>Кабинет</th>
					</tr>
				</thead>
				<tbody>
				<?php
					if(is_array($timetable) && count($timetable) ) {
					foreach($timetable as $row) {
				?>
					<tr>
					    <td><input type="radio" name="timetable_id" value="<?php echo $row['TIMETABLE_ID'];?>"></td>
						<td id="time"><?php echo date("H:i", strtotime($row["TIME_START"])).' - '
									.date("H:i",strtotime($row["TIME_FINISH"]));?></td>
						<td><?php if(isset($row['SUBJECT_NAME'])) echo $row['SUBJECT_NAME'];?></td>
						<td><?php if(isset($row['ROOM_NAME'])) echo $row['ROOM_NAME'];?></td>
					</tr>
					<?php } }?>
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $this->pagination->create_links(); ?>
	<?php
		if(count($timetable) == 0) {
	?>
	<div class="alert alert-info" role="alert">Расписание на выбранный день пусто. Начните заполнять его</div>
	<?php } ?>
</div>


<script type="text/javascript">
	$(document).ready(function() {


		$("#day").select2({
			minimumResultsForSearch: Infinity,
			language: "ru"
		});

		if($(":radio[name=timetable_id]").is(':checked')) {
			var value = $(this).filter(":checked").val();
			if(value == "") {
				$('#editButton').removeClass('disabled');
				$('#deleteButton').addClass('disabled');
			} else {
				$('#editButton').removeClass('disabled');
				$('#deleteButton').removeClass('disabled');
			}
		} else {
			$('#editButton').addClass('disabled');
			$('#deleteButton').addClass('disabled');
		}

		$(":radio[name=timetable_id]").change(function() {
			var value = $(this).filter(":checked").val();
			if(value == "") {
				$('#editButton').removeClass('disabled');
				$('#deleteButton').addClass('disabled');
			} else {
				$('#editButton').removeClass('disabled');
				$('#deleteButton').removeClass('disabled');
			}
		});

		$('#createButton').click(function() {
			var day = $('#day').find("option:selected").val();
			document.location.href = '<?php  echo base_url(); ?>teacher/timetableitem/' + day;
		});

		$('#editButton').click(function() {
			var day = $('#day').find("option:selected").val();
			var value = $(":radio[name=timetable_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>teacher/timetableitem/' + day + "/" + value;
		});


		$('#buttonDeleteTimetableModal').click(function() {
			var value = $(":radio[name=timetable_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/timetable/" + value,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(a) {
					location.reload();
				}
			});
		});
		$("tr:not(:first)").click(function() {
			$(this).children("td").find('input[type=radio]').prop('checked', true).change();
		});

		$("#day").change(function() {
			var val = $(this).find("option:selected").val();
			document.location.href = '<?php  echo base_url(); ?>teacher/timetable/' + val;
		});
	});
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Удаление предмета из расписания</h4>
      </div>
      <div class="modal-body">
        <p>Вы уверены, что хотите удалить этот предмет из расписания?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-sample" id="buttonDeleteTimetableModal">Удалить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

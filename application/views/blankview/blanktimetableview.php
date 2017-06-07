<script src="<?php echo base_url();?>bootstrap/js/jquery-2.1.1.min.js" type="text/javascript"></script>
<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputTime" class="col-sm-2 col-md-2 control-label">Время <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<select id="inputTime" name="inputTime" class="width-select">
						<?php
							if(isset($times)) {
									if($time_id == null && isset($id)) echo "<option value=''></option>";
								foreach($times as $time) {
									if ($time_id != "") {
										if($time['TIME_ID'] == $time_id) {
											echo "<option selected='selected' value='".$time['TIME_ID']."'>".date("H:i", strtotime($time["TIME_START"])).' - '
									.date("H:i",strtotime($time["TIME_FINISH"]))."</option>";
										} else {
											echo "<option value='".$time['TIME_ID']."'>".date("H:i", strtotime($time["TIME_START"])).' - '
									.date("H:i",strtotime($time["TIME_FINISH"]))."</option>";

										}
									} else {
										echo "<option value='".$time['TIME_ID']."'>".date("H:i", strtotime($time["TIME_START"])).' - '
									.date("H:i",strtotime($time["TIME_FINISH"]))."</option>";
									}
								}
							}
								?>
							</select>
							<div class="red" id="responseTimeError"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputSubject" class="col-sm-2 col-md-2 control-label">Предмет в</br>классе <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<select id="inputSubject" name="inputSubject" class="width-select">
						<?php
							if(isset($subjects)) {
									if($subject_id == null && isset($id)) echo "<option value=''></option>";
								foreach($subjects as $subject) {
									if ($subject_id != "") {
										if($subject['SUBJECTS_CLASS_ID'] == $subject_id) {
											echo "<option selected='selected' value='".$subject['SUBJECTS_CLASS_ID']."'>".$subject['SUBJECT_NAME']."</option>";
										} else {
											echo "<option value='".$subject['SUBJECTS_CLASS_ID']."'>".$subject['SUBJECT_NAME']."</option>";

										}
									} else {
										echo "<option value='".$subject['SUBJECTS_CLASS_ID']."'>".$subject['SUBJECT_NAME']."</option>";
									}
								}
							}
								?>
								</select>
						</div>
			        </div>
			        <div class="form-group">
				        <label for="inputRoom" class="col-sm-2 col-md-2 control-label">Кабинет</label>
				        <div class="col-sm-10 col-md-10">
					        <select id="inputRoom" name="inputRoom" class="width-select">
						        <option value=""></option>
						<?php
							if(isset($rooms)) {
								foreach($rooms as $room) {
									if ($room_id != "") {
										if($room['ROOM_ID'] == $room_id) {
											echo "<option selected='selected' value='".$room['ROOM_ID']."'>".$room['ROOM_NAME']."</option>";
										} else {
											echo "<option value='".$room['ROOM_ID']."'>".$room['ROOM_NAME']."</option>";

										}
									} else {
										echo "<option value='".$room['ROOM_ID']."'>".$room['ROOM_NAME']."</option>";
									}
								}
							}
								?>
							</select>
				        </div>
			        </div>
				</div>
			    <div class="grey">* - Обязательные поля</div>
		        <div id="error" class="red"></div>
				<div class="modal-footer" style="margin-bottom: -15px; padding-right: 0px;">
					<button type="button" class="btn btn-default" onclick="javascript:history.back();" title="Отменить">Отменить</button>
					<button type="submit" class="btn btn-sample" name="save" id="save" title="Сохранить">Сохранить</button>
				</div>
				</form>
			</div>
		</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {


		$("#inputSubject").select2({
			language: "ru"
		});

		$("#inputTime").select2({
			minimumResultsForSearch: Infinity,
			language: "ru"
		});
		$("#inputRoom").select2({
			language: "ru"
		});

	$('#save').click(function() {
		var base_url = '<?php echo base_url();?>';
		var s = 0;
		var error = 0;
		var day = '<?php echo $this->uri->segment(3);?>';
		var room = $('#inputRoom').find("option:selected").val();
		var subject = $('#inputSubject').find("option:selected").val();
		var time = $('#inputTime').find("option:selected").val();
		var id = $('#id').text();
		if (time == "") {
			s++;
		}
		if(subject == "") {
			s++;
		}
		$("#responseTimeError").text('');
		if(time != "" && subject != "") {
			$.ajax({
				type: "POST",
				url: base_url + "table/responsetimetable",
				data: "time=" + time + "&day=" + day + "&id=" + id,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
				//alert(response);
				if (response == true) {
					$("#responseTimeError").text('В расписании уже занято это время на этот день');
					error++;
				}
				if (response == false) {
					$("#responseTimeError").text('');
				}
			}
		});
		}


		if (s != 0) {
			$("#error").text('Не все обязательные поля заполнены');
		}
		else {
			$("#error").text('');
		}
		//alert(s + " " + error);

		if (s == 0 && error == 0) {
			/*if (id == "") {
				$.ajax({
					type: "POST",
					url: base_url + "table/addtimetable",
					data: "subject=" + subject + "&time=" + time + "&day=" + day + "&room=" + room,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'teacher/timetable/1';
					}
				});
			}
			else {
				$.ajax({
					type: "POST",
					url: base_url + "table/updatetimetable",
					data:  "subject=" + subject + "&time=" + time + "&day=" + day + "&room=" + room + "&id=" + id,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						//alert(response);
						document.location.href = base_url + 'teacher/timetable/1';
				    }
				});
			}*/
		} else return false;
	});

    });
</script>

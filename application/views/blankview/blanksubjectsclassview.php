<script src="<?php echo base_url();?>bootstrap/js/jquery-2.1.1.min.js" type="text/javascript"></script>
<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
				    <div class="form-group">
					<label for="inputSubject" class="col-sm-2 col-md-2 control-label">Общий предмет <span class="star">*</span></label>
					<div class="col-sm-10 col-md-10">
					<select id="inputSubject" name="inputSubject" class="width-select">
						<?php
							if(isset($subjects)) {
									if($subject_id == null && isset($id)) echo "<option value=''></option>";
								foreach($subjects as $subject) {
									if ($subject_id != "") {
										if($subject['SUBJECT_ID'] == $subject_id) {
											echo "<option selected='selected' value='".$subject['SUBJECT_ID']."'>".$subject['SUBJECT_NAME']."</option>";
										} else {
											echo "<option value='".$subject['SUBJECT_ID']."'>".$subject['SUBJECT_NAME']."</option>";

										}
									} else {
										echo "<option value='".$subject['SUBJECT_ID']."'>".$subject['SUBJECT_NAME']."</option>";
									}
								}
							}
								?>
					</select>
					</div>
			    </div>
				<div class="form-group">
					<label for="inputTeacher" class="col-sm-2 col-md-2 control-label">ФИО учителя <span class="star">*</span></label>
					<div class="col-sm-10 col-md-10">
					<select id="inputTeacher" name="inputTeacher" class="width-select">
						<?php
								if(isset($teachers)) {
									if($teacher_id == null && isset($id)) echo "<option value=''></option>";
								foreach($teachers as $teacher) {
									if ($teacher_id != "") {
										if($teacher['TEACHER_ID'] == $teacher_id) {
											echo "<option selected='selected' value='".$teacher['TEACHER_ID']."'>".$teacher['TEACHER_NAME']."</option>";
										} else {
											echo "<option value='".$teacher['TEACHER_ID']."'>".$teacher['TEACHER_NAME']."</option>";

										}
									} else {
										echo "<option value='".$teacher['TEACHER_ID']."'>".$teacher['TEACHER_NAME']."</option>";
									}
								}
							}
								?>
					</select>
					<div class="red" id="responseTeacherError"></div>
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
		$("#inputTeacher").select2({
			language: "ru"
		});
		$("#inputSubject").select2({
			language: "ru"
		});

	$('#save').click(function() {
		var base_url = '<?php echo base_url();?>';
		var s = 0;
		var error = 0;

		var teacher = $('#inputTeacher').find("option:selected").val();
		var subject = $('#inputSubject').find("option:selected").val();
		var id = $('#id').text();
		if (teacher == "") {
			s++;
		}
		if(subject == "") {
			s++;
		}
		$("#responseTeacherError").text('');
		if(teacher != "" && subject != "") {
		$.ajax({
			type: "POST",
			url: base_url + "table/responsesubjectsclass",
			data: "teacher=" + teacher + "&subject=" + subject + "&id=" + id,
			timeout: 30000,
			async: false,
			error: function(xhr) {
				console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
			},
			success: function(response) {
				//alert(response);
				if (response == true) {
					$("#responseTeacherError").text('В списке уже есть такой предмет в классе');
					error++;
				}
				if (response == false) {
					$("#responseTeacherError").text('');
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
					url: base_url + "table/addsubjectsclass",
					data: "teacher=" + teacher + "&subject=" + subject,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'teacher/subjects';
					}
				});
			}
			else {
				$.ajax({
					type: "POST",
					url: base_url + "table/updatesubjectsclass",
					data: "teacher=" + teacher + "&subject=" + subject + "&id=" + id,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						//alert(response);
						document.location.href = base_url + 'teacher/subjects';
				    }
				});
			}*/
		} else return false;
	});

    });
</script>

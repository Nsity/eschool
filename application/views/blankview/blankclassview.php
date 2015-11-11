<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputNumber" class="col-sm-2 col-md-2 control-label">Параллель <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="number" class="form-control" title="Значение задается в диапазоне от 1 до 11" id="inputNumber" name="inputNumber" required="true" autofocus min="1" max="11" value = "<?php if(isset($number)) { echo $number; } else echo "1";?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputLetter" class="col-sm-2 col-md-2 control-label">Буква <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputLetter" name="inputLetter" placeholder="Буква" required="true" maxlength="50" value="<?php if(isset($letter)) echo $letter;?>">
							<div class="red" id="responseClassError"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputYear" class="col-sm-2 col-md-2 control-label">Учебный год <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<select id="inputYear" name="inputYear" class="width-select"  <?php if(isset($status_allow) && $status_allow == true) echo 'disabled';?>>
						<?php
							if(isset($years)) {
								if($year_id == null && isset($id)) echo "<option value=''></option>";
								foreach($years as $year) {
									if ($year_id != "") {
										if($year['YEAR_ID'] == $year_id) {
											echo "<option selected='selected' value='".$year['YEAR_ID']."'>".date("Y", strtotime($year['YEAR_START'])).' - '.date("Y", strtotime($year['YEAR_FINISH']))." гг."."</option>";
										} else {
											echo "<option value='".$year['YEAR_ID']."'>".date("Y", strtotime($year['YEAR_START'])).' - '.date("Y", strtotime($year['YEAR_FINISH']))." гг."."</option>";
										}
									} else {
										echo "<option value='".$year['YEAR_ID']."'>".date("Y", strtotime($year['YEAR_START'])).' - '.date("Y", strtotime($year['YEAR_FINISH']))." гг."."</option>";
									}
								}
							}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 col-md-2 control-label">Текущий <span class="star">*</span></label>
		     		    <div class="col-sm-offset-2 col-sm-10" style="margin-top: -27.5px;">
			     		    <label class="radio-inline">
			     		    <input type="radio" name="inputStatus" <?php if(isset($status_allow) && $status_allow == true) echo 'disabled';?>
			        value="1" <?php if(isset($status) && $status == 1) { echo "checked='checked'";} else echo "checked='checked'";  ?> >Да
			     		    </label>
			     		    <label class="radio-inline">
			     		        <input type="radio" name="inputStatus" <?php if(isset($status_allow) && $status_allow == true) echo 'disabled';?>
				    value="0" <?php if(isset($status) && $status == 0) { echo "checked='checked'";}?>>Нет
			     		    </label>
		     		    </div>
		     		</div>
				<!--<label>Текущий *</label>
				<div class="radio" style="margin-top: 0px;">
			        <input type="radio" name="inputStatus" <?php if(isset($status_allow) && $status_allow == true) echo 'disabled';?>
			        value="1" <?php if(isset($status) && $status == 1) { echo "checked='checked'";} else echo "checked='checked'";  ?> >Да<br/>
				    <input type="radio" name="inputStatus" <?php if(isset($status_allow) && $status_allow == true) echo 'disabled';?>
				    value="0" <?php if(isset($status) && $status == 0) { echo "checked='checked'";}?>>Нет
				</div>-->
				    <div class="form-group">
					    <label for="inputTeacher"  class="col-sm-2 col-md-2 control-label">Классный руководитель <span class="star">*</span></label>
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
					<div class="form-group">
						<label for="inputPrevious" class="col-sm-2 col-md-2 control-label"><?php if(isset($previous)) echo "Переведен из класса"; else echo "Перевести из класса";?></label>
						<div class="col-sm-10 col-md-10">
							<select id="inputPrevious" name="inputPrevious" class="width-select" <?php if(isset($previous)) echo "disabled"; ?>>
								<option value=""></option>
						<?php
								foreach($classes as $class) {
									if(isset($class['YEAR_ID'])) $year_border = " (".date("Y",strtotime($class['YEAR_START']))." - ".date("Y",strtotime($class['YEAR_FINISH']))." гг.)"; else $year_border = '';
									if ($previous != "") {
										if($class['CLASS_ID'] == $previous) {
											echo "<option selected='selected' value='".$class['CLASS_ID']."'>".$class['CLASS_NUMBER']." ".$class['CLASS_LETTER'].$year_border."</option>";
										} else {
											echo "<option value='".$class['CLASS_ID']."'>".$class['CLASS_NUMBER']." ".$class['CLASS_LETTER'].$year_border."</option>";

										}
									} else {
										if(isset($id) && $class['CLASS_ID'] == $id) {

										} else
										echo "<option value='".$class['CLASS_ID']."'>".$class['CLASS_NUMBER']." ".$class['CLASS_LETTER'].$year_border."</option>";
									}
								}
								?>
							</select>
							<div class="red" id="responsePreviousError"></div>
						</div>
					</div>
					<div class="alert alert-warning" role="alert"><strong>Примечание:</strong> перевод класса осуществляется только один раз - отменить это действие уже будет нельзя. Проверяйте внимательно выбранный класс
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
				<!--<div class="panel-footer clearfix">
        <div class="pull-right">
	        <button type="button" class="btn btn-default" onclick="javascript:history.back();">Отменить</button>
					<button type="button" class="btn btn-sample" name="save" id="save">Сохранить</button>

        </div>
        </div>-->
		</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$("#inputYear").select2({
			minimumResultsForSearch: Infinity,
			language: "ru"
		});

		$("#inputTeacher").select2({
			language: "ru"
		});

		$("#inputPrevious").select2({
			language: "ru"
		});

	$("input[type='number']").change("input", function() {
		var number = $('#inputNumber').val();
		if (number > 11 || number < 1) {
			$('#inputNumber').val(1);
		}
	});

	$('#save').click(function() {
		var base_url = '<?php echo base_url();?>';
		var s = 0;
		var error = 0;


		var number = $.trim($('#inputNumber').val());
		var letter = $.trim($('#inputLetter').val());
		var year = $('#inputYear').find("option:selected").val();
		var teacher = $('#inputTeacher').find("option:selected").val();
		var status = $("input[name='inputStatus']:checked").val();
		var previous = $('#inputPrevious').find("option:selected").val();

		if ($('#inputPrevious').is(':disabled')) {
			previous = "";
		}

		$("#responsePreviousError").text('');

		try {
			var years1 = $('#inputYear').find("option:selected").text();
			var years2 = $('#inputPrevious').find("option:selected").text().split("(")[1].split(")")[0];
			if (years1 == years2) {
				error++;
				$("#responsePreviousError").text('Нельзя делать перевод в класс этого же года');
			} else {
				$("#responsePreviousError").text('');
			}
		}
		catch (e) {

		}
		if(error == 0) {
		$("#responsePreviousError").text('');
		$.ajax({
				type: "POST",
				url: base_url + "table/responseclassprevious",
				data: "previous=" + previous,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
					if (response == true) {
						$("#responsePreviousError").text('Из выбранного класса уже был сделан перевод');
						error++;
					}
					if (response == false) {
						$("#responsePreviousError").text('');
					}
				}
		});
		}


		var id = $('#id').text();

		if (letter.length == 0) {
			$('#inputLetter').parent().addClass("has-error");
			s++;
		} else {
			$('#inputLetter').parent().removeClass("has-error");
			$.ajax({
				type: "POST",
				url: base_url + "table/responseclass",
				data: "number=" + number + "&letter=" + letter + "&year=" + year + "&status=" + status + "&id=" + id,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
					if (response == true) {
						$("#responseClassError").text('В списке уже есть такой класс в выбранном году');
						$('#inputLetter').parent().addClass("has-error");
						$('#inputNumber').parent().addClass("has-error");
						error++;
					}
					if (response == false) {
						$("#responseClassError").text('');
						$('#inputLetter').parent().removeClass("has-error");
						$('#inputNumber').parent().removeClass("has-error");
					}
				}
			});
		}
		if (year == "") {
			s++;
		}
		//alert(teacher + year + id);
		if (teacher == "") {
			$("#responseTeacherError").text('');
			s++;
		} else {
			$("#responseTeacherError").text('');
			$.ajax({
				type: "POST",
				url: base_url + "table/responseclassteacher",
				data: "teacher=" + teacher + "&year=" + year + "&id=" + id,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
					//alert(response);
					if (response == true) {
						$("#responseTeacherError").text('Выбранный учитель уже является классным руководителем в выбранном году');
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
					url: base_url + "table/addclass",
					data: "number=" + number + "&letter=" + letter + "&year=" + year + "&status=" + status + "&teacher=" + teacher + "&previous=" + previous,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/classes';
					}
				});
			}
			else {
				$.ajax({
					type: "POST",
					url: base_url + "table/updateclass",
					data: "number=" + number + "&letter=" + letter + "&year=" + year + "&status=" + status + "&teacher=" + teacher + "&id=" + id + "&previous=" + previous,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						//alert(response);
						document.location.href = base_url + 'admin/classes';
				    }
				});
			}*/
		} else return false;
	});

    });
</script>





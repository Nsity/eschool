<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post" enctype="multipart/form-data">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputTheme" class="col-sm-2 col-md-2 control-label">Тема урока <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<textarea style="resize: vertical;" class="form-control" rows="2" maxlength="1000" name="inputTheme" id="inputTheme" placeholder="Тема урока" autofocus required="true"><?php if(isset($theme)) echo $theme;?></textarea>
							<div class="textareaFeedback"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputDate" class="col-sm-2 col-md-2 control-label">Дата урока <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputDate" name="inputDate" required="true" placeholder="гггг-мм-дд" value="<?php if(isset($date)) { echo $date; } else echo date('Y-m-d');?>" >
							<div id="responseDateError" class="red"></div>
						</div>
					</div>
					<div class="form-group" hidden="true">
						<label for="inputURL" class="col-sm-2 col-md-2 control-label">Предыдущая страница</label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputURL" name="inputURL" value="<?php if(isset($back)) { echo $back; }?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputTime" class="col-sm-2 col-md-2 control-label">Время урока <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<select id="inputTime" name="inputTime" style="width: 100%;">
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
						</div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 col-md-2 control-label">Статус <span class="star">*</span></label>
		     		    <div class="col-sm-offset-2 col-sm-10" style="margin-top: -27.5px;">
			     		    <label class="radio-inline">
			     		        <input type="radio" name="inputStatus" value="0" <?php if(isset($status) && $status == 0) { echo "checked='checked'";} else echo "checked='checked'";?>>Не проведен
			     		    </label>
			     		    <label class="radio-inline">
			     		    <input type="radio" name="inputStatus" value="1" <?php if(isset($status) && $status == 1) { echo "checked='checked'";}   ?> >Проведен
			     		    </label>
		     		    </div>
		     		</div>
					<div class="form-group">
						<label for="inputHomework" class="col-sm-2 col-md-2 control-label">Домашнее задание</label>
						<div class="col-sm-10 col-md-10">
							<textarea style="resize: vertical;" class="form-control" rows="10" maxlength="8000" id="inputHomework" name="inputHomework" placeholder="Текст домашнего задания"><?php if(isset($homework)) echo $homework; ?></textarea>
							<div class="textareaFeedback"></div>
						</div>
					</div>
				<!--<div class="form-group">
					<label for="inputFile" class="col-sm-2 col-md-2 control-label">Вложения (размер файла не более 10 Мб)</label>
					<div class="col-sm-10 col-md-10">
						<input type="file" id="inputFile1" name="inputFile1" style="padding-top: 15px;">
						<input type="file" id="inputFile2" name="inputFile2">
						<input type="file" id="inputFile3" name="inputFile3">
					</div>
				</div>-->
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


		$("#inputTime").select2({
			minimumResultsForSearch: Infinity,
			language: "ru"
		});


		$("#inputDate").mask("9999-99-99");

		$('#inputDate').datepicker({
		    format: 'yyyy-mm-dd',
		    startDate: "1993-01-01",
		    endDate: "2020-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true,
		});


	$('#save').click(function() {
		var base_url = '<?php echo base_url();?>';
		var s = 0;
		var error = 0;
		var theme = $.trim($('#inputTheme').val());
		var date = $('#inputDate').val();
		var time = $('#inputTime').find("option:selected").val();
		var text = $.trim($('#inputHomework').val());
		var id = $('#id').text();
		if (theme.length == 0) {
			$('#inputTheme').parent().addClass("has-error");
			s++;
		} else {
			$('#inputTheme').parent().removeClass("has-error");
		}
		if (date.length == 0) {
			$('#inputDate').parent().addClass("has-error");
			s++;
		} else {
			$('#inputDate').parent().removeClass("has-error");
			$("#responseDateError").text('');
			$.ajax({
				type: "POST",
				url: base_url + "table/responselesson",
				data: "date=" + date + "&time=" + time+ "&id=" + id + "&subject=" + "<?php echo $this->uri->segment(3);?>",
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
					if (response == 1) {
						$("#responseDateError").text('В списке уже есть такой урок на выбранное время');
						$('#inputDate').parent().addClass("has-error");
						error++;
					}
					if (response == 2) {
						$("#responseDateError").text('В расписании нет такого занятия');
						$('#inputDate').parent().addClass("has-error");
						error++;
					}
					if (response == 0) {
						$("#responseDateError").text('');
						$('#inputDate').parent().removeClass("has-error");
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
		/*alert(s + " " + error);*/
		if (s == 0 && error == 0) {} else return false;
	});

    });
</script>

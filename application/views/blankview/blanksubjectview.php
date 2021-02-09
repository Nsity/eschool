<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputSubject" class="col-sm-2 col-md-2 control-label">Предмет <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputSubject" name="inputSubject" placeholder="Наименование общего предмета" required="true" maxlength="100" autofocus value="<?php if(isset($subject)) echo $subject;?>">
							<div class="red" id="responseSubjectError"></div>
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
	$('#save').click(function() {
		var base_url = '<?php echo base_url();?>';
		var s = 0;
		var error = 0;

		var subject_name = $.trim($('#inputSubject').val());
		var id = $('#id').text();

		if (subject_name.length == 0) {
			$('#inputSubject').parent().addClass("has-error");
			$("#responseSubjectError").text('');
			s++;
		} else {
			$('#inputSubject').parent().removeClass("has-error");
			$.ajax({
				type: "POST",
				url: base_url + "table/responsesubject",
				data: "name=" + subject_name + "&id=" + id,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
					if (response == true) {
						$("#responseSubjectError").text('В списке уже есть такой общий предмет');
						$('#inputSubject').parent().addClass("has-error");
						error++;
					}
					if (response == false) {
						$("#responseSubjectError").text('');
						$('#inputSubject').parent().removeClass("has-error");
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
					url: base_url + "table/addsubject",
					data: "name=" + subject_name,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/subjects';
					}
				});
			}
			else {
				$.ajax({
					type: "POST",
					url: base_url + "table/updatesubject",
					data: "name=" + subject_name + "&id=" + id,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/subjects';
				    }
				});
			}*/
		} else {
			return false;
		}
	});

    });
</script>

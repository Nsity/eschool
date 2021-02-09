<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputTheme" class="col-sm-2 col-md-2 control-label">Тема новости <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<textarea style="resize: vertical;" class="form-control" rows="1" maxlength="150" id="inputTheme" name="inputTheme" placeholder="Тема новости" autofocus required="true"><?php if(isset($theme)) echo $theme;?></textarea>
							<div class="textareaFeedback"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputDate" class="col-sm-2 col-md-2 control-label">Дата новости <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputDate" name="inputDate" required="true" placeholder="гггг-мм-дд" value="<?php if(isset($date)) { echo $date; } else echo date('Y-m-d');?>" >
							<div id="responseDateError" class="red"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputText" class="col-sm-2 col-md-2 control-label">Текст новости <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<!--<div id="txtEditor"></div>-->
							<textarea style="resize: vertical;" class="form-control" rows="10" maxlength="5000" id="inputText" name="inputText" placeholder="Текст новости" required="true"><?php if(isset($text)) echo $text; ?></textarea>
							<div class="textareaFeedback"></div>
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

		//$("#txtEditor").Editor({'fonteffects':false, 'print':false, 'status_bar':false, 'togglescreen':false});

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
		var text = $.trim($('#inputText').val());
		var id = $('#id').text();
		if (theme.length == 0) {
			$('#inputTheme').parent().addClass("has-error");
			s++;
		} else {
			$('#inputTheme').parent().removeClass("has-error");
		}

		if (text.length == 0) {
			$('#inputText').parent().addClass("has-error");
			s++;
		} else {
			$('#inputText').parent().removeClass("has-error");
		}

		if (date.length == 0) {
			$('#inputDate').parent().addClass("has-error");
			s++;
		} else {
			$('#inputDate').parent().removeClass("has-error");
		}
		if (s != 0) {
			$("#error").text('Не все обязательные поля заполнены');
		}
		else {
			$("#error").text('');
		}

		//alert($("#txtEditor").val());
		//alert(s + " " + error);
		if (s == 0 && error == 0) {
			/*if (id == "") {
				$.ajax({
					type: "POST",
					url: base_url + "table/addnews",
					data: "theme=" + theme + "&date=" + date + "&text=" + text,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/news';
					}
				});
			}
			else {
				$.ajax({
					type: "POST",
					url: base_url + "table/updatenews",
					data: "theme=" + theme + "&date=" + date + "&text=" + text + "&id=" + id,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/news';
				    }
				});
			}*/
		} else return false;
	});

    });
</script>


<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputRoom" class="col-sm-2 col-md-2 control-label">Кабинет <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputRoom" name="inputRoom" placeholder="Наименование кабинета" required="true" maxlength="10" autofocus value="<?php if(isset($room)) echo $room;?>">
							<div class="red" id="responseRoomError"></div>
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

		var room_name = $.trim($('#inputRoom').val());
		var id = $('#id').text();

		if (room_name.length == 0) {
			$('#inputRoom').parent().addClass("has-error");
			$("#responseRoomError").text('');
			s++;
		} else {
			$('#inputRoom').parent().removeClass("has-error");
			$.ajax({
				type: "POST",
				url: base_url + "table/responseroom",
				data: "name=" + room_name + "&id=" + id,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
					if (response == true) {
						$("#responseRoomError").text('В списке уже есть такой кабинет');
						$('#inputRoom').parent().addClass("has-error");
						error++;
					}
					if (response == false) {
						$("#responseRoomError").text('');
						$('#inputRoom').parent().removeClass("has-error");
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
		} else {
			return false;
		}
	});

    });
</script>

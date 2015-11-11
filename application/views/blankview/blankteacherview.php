<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputName" class="col-sm-2 col-md-2 control-label">ФИО учителя <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputName" name="inputName" placeholder="ФИО учителя" required="true" maxlength="100" autofocus value="<?php if(isset($name)) echo $name;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputLogin" class="col-sm-2 col-md-2 control-label">Логин <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputLogin" name="inputLogin" placeholder="Логин" required="true" maxlength="20" value="<?php if(isset($login)) echo $login;?>">
						    <div class="red" id="responseLoginError"></div>
						</div>
					</div>
				    <div class="form-group">
						<label for="inputPassword" class="col-sm-2 col-md-2 control-label">Пароль <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
	    					<span class="passEye"><input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Пароль" required="true" maxlength="20" value="<?php if(isset($password)) echo $password;?>">
							</span>
						</div>
					</div>
				    <div class="form-group">
					    <label class="col-sm-2 col-md-2 control-label">Статус <span class="star">*</span></label>
		     		    <div class="col-sm-offset-2 col-sm-10" style="margin-top: -27.5px;">
			     		    <label class="radio-inline">
			     		    <input type="radio" name="inputStatus" value="1" <?php if(isset($status) && $status == 1) { echo "checked='checked'";} else echo "checked='checked'";  ?> >Активен
			     		    </label>
			     		    <label class="radio-inline">
			     		        <input type="radio" name="inputStatus" value="0" <?php if(isset($status) && $status == 0) { echo "checked='checked'";}?>>Не активен
			     		    </label>
		     		    </div>
		     		</div>
					    <!--<label class="col-sm-2 control-label">Статус *</label>
					    <div class="col-sm-offset-2 col-sm-10">
					    <div class="radio">

						    <input type="radio" name="inputStatus" value="1" <?php if(isset($status) && $status == 1) { echo "checked='checked'";} else echo "checked='checked'";  ?> >Активен<br/>
						    <input type="radio" name="inputStatus" value="0" <?php if(isset($status) && $status == 0) { echo "checked='checked'";}?>>Не активен
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
	$('#save').click(function() {
		var base_url = '<?php echo base_url();?>';
		var s = 0;
		var error = 0;

		var name = $.trim($('#inputName').val());
		var password = $.trim($('#inputPassword').val());
		var login = $.trim($('#inputLogin').val());
		var status = $("input[name='inputStatus']:checked").val();

		var id = $('#id').text();

		if (name.length == 0) {
			$('#inputName').parent().addClass("has-error");
			s++;
		} else {
			$('#inputName').parent().removeClass("has-error");
		}

		if (password.length == 0) {
			$('#inputPassword').parent().addClass("has-error");
			s++;
		} else {
			$('#inputPassword').parent().removeClass("has-error");
		}
		if (login.length == 0) {
			$('#inputLogin').parent().addClass("has-error");
			$("#responseLoginError").text('');
			s++;
		} else {
			$('#inputLogin').parent().removeClass("has-error");
			$.ajax({
				type: "POST",
				url: base_url + "table/responseteacherlogin",
				data: "login=" + login + "&id=" + id,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
					if (response == true) {
						$("#responseLoginError").text('Логин должен быть уникальным');
						$('#inputLogin').parent().addClass("has-error");
						error++;
					}
					if (response == false) {
						$("#responseLoginError").text('');
						$('#inputLogin').parent().removeClass("has-error");
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
					url: base_url + "table/addteacher",
					data: "name=" + name + "&login=" + login + "&password=" + password + "&status=" + status,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/teachers';
					}
				});
			}
			else {
				$.ajax({
					type: "POST",
					url: base_url + "table/updateteacher",
					data: "name=" + name + "&login=" + login + "&password=" + password + "&status=" + status + "&id=" + id,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/teachers';
				    }
				});
			}*/
		} else {
			return false;
		}
	});

    });
</script>




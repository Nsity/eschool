<script src="<?php echo base_url();?>bootstrap/js/jquery-2.1.1.min.js" type="text/javascript"></script>
<div class="container">
	<div class="row">
	<!--Написать сообщение-->
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $title; ?></div>
		<div class="panel-body">
			<form method="post">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="inputСontact" class="col-sm-1 col-md-1 control-label">Кому</label>
					<div class="col-sm-11 col-md-11">
						<input type="text" class="form-control" id="inputСontact" required="true" placeholder="Получатель">
						<div id="responseContactError" class="red"></div>
						<div id="contacts" style="margin-top: 5px; margin-left: 15px;"></div>
						<div hidden="true" id="id"></div>
						<input hidden="true" type="text" id="contact" name="contact"></input>
					</div>
				</div>
			</div>
			<div class="form-group">
				<textarea style="resize: vertical;" class="form-control" rows="10" name ="inputText"
				maxlength="1000" id ="inputText" placeholder="Текст сообщения" required="true"></textarea>
				<div class="textareaFeedback"></div>
				<div id="responseTextError" class="red"></div>
			</div>
			<div class="modal-footer" style="margin-bottom: -15px; padding-right: 0px;">
				<button type="button" class="btn btn-default" onclick="javascript:history.back();" title="Отменить">Отменить</button>
				<button type="submit" class="btn btn-sample" name="send" id="send" title="Отправить">Отправить</button>
			</div>
			</form>
		</div>
	</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

//		 $('#inputText').autoResize();


		$("#inputСontact").focus(function() {
			$('#inputСontact').parent().removeClass("has-error");
			$("#responseContactError").text('');
			$("#contacts").html('Начните вводить запрос');
		});
		$("#inputСontact").focusout(function() {
			if($(this).val() == "") {
				$("#contacts").html('');
			}
			if($("#contacts").html() == "Поиск не дал результатов"){
				$("#contacts").html('');
				$(this).val('');
			}
		});

		$("#inputСontact").keyup(function() {
			var search = $(this).val();
			if(search == "") {
				$("#contacts").html('Начните вводить запрос');
			} else {
				var base_url = '<?php echo base_url();?>';
				$.ajax({
					type: "POST",
					url: base_url + "table/search",
					data: {"search": search},
					cache: false,
					success: function(response){
						//alert(response);
						$("#contacts").html(response);
					}
				});
			}
		});

		$(document).on('click', "a", function(){
			$("#inputСontact").val($(this).find("#name").text());
			$("#contact").val($(this).find("#id").text());
			$('#contact').hide();
			$("#contacts").html('');
		});

	$('#send').click(function() {
		var base_url = '<?php echo base_url();?>';
		var error = 0;

		var contact = $('#inputСontact').val();
		var text = $.trim($('#inputText').val());
		var id = $('#contact').val();
		if (contact.length == 0 || id.length == 0) {
			$('#inputСontact').parent().addClass("has-error");
			$("#responseContactError").text('Выберите кому написать письмо');
			error++;
		} else {
			$('#inputСontact').parent().removeClass("has-error");
			$("#responseContactError").text('');
			if(text.length == 0) {
				$('#inputText').parent().addClass("has-error");
			    $("#responseTextError").text('Начните писать сообщение');
			    error++;
			} else {
				$('#inputText').parent().removeClass("has-error");
				$("#responseTextError").text('');
			}

		}
		if (error == 0) {
			/*$.ajax({
					type: "POST",
					url: base_url + "table/addmessage",
					data:  "id=" + id + "&text=" + text,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'messages/sent';
					}
			});*/
		} else {
			return false;
		}
	});

    });
</script>

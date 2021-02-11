<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<form method="post">
				<div hidden="true" id="id"><?php if(isset($id)) echo $id;?></div>
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputYearStart" class="col-sm-2 col-md-2 control-label">Начало учебного года <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputYearStart" name="inputYearStart" placeholder="гггг-мм-дд" required="true" value="<?php if(isset($info["fifth"]["start"])) echo $info["fifth"]["start"]; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputYearFinish" class="col-sm-2 col-md-2 control-label">Окончание учебного года <span class="star">*</span></label>
						<div class="col-sm-10 col-md-10">
							<input type="text" class="form-control" id="inputYearFinish" name="inputYearFinish" placeholder="гггг-мм-дд" required="true" value="<?php if(isset($info["fifth"]["finish"])) echo $info["fifth"]["finish"]; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputFirstStart">Начало I четверти <span class="star">*</span></label>
							<input readonly="true" type="text" class="form-control" id="inputFirstStart" name="inputFirstStart" placeholder="гггг-мм-дд"  required="true" value="<?php if(isset($info["first"]["start"])) echo $info["first"]["start"]; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputFirstFinish">Конец I четверти <span class="star">*</span></label>
							<input type="text" class="form-control" id="inputFirstFinish" name="inputFirstFinish" placeholder="гггг-мм-дд" required="true" value="<?php if(isset($info["first"]["finish"])) echo $info["first"]["finish"]; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputSecondStart">Начало II четверти <span class="star">*</span></label>
							<input type="text" class="form-control" id="inputSecondStart" name="inputSecondStart" placeholder="гггг-мм-дд"  required="true" value="<?php if(isset($info["second"]["start"])) echo $info["second"]["start"]; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputSecondFinish">Конец II четверти <span class="star">*</span></label>
							<input type="text" class="form-control" id="inputSecondFinish" name="inputSecondFinish" placeholder="гггг-мм-дд" required="true" value="<?php if(isset($info["second"]["finish"])) echo $info["second"]["finish"]; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputThirdStart">Начало III четверти <span class="star">*</span></label>
							<input type="text" class="form-control" id="inputThirdStart" name="inputThirdStart" placeholder="гггг-мм-дд" required="true" value="<?php if(isset($info["third"]["start"])) echo $info["third"]["start"]; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputThirdFinish">Конец III четверти <span class="star">*</span></label>
							<input type="text" class="form-control" id="inputThirdFinish" name="inputThirdFinish" placeholder="гггг-мм-дд"  required="true" value="<?php if(isset($info["third"]["finish"])) echo $info["third"]["finish"]; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputForthStart">Начало IV четверти <span class="star">*</span></label>
							<input type="text" class="form-control" id="inputForthStart" name="inputForthStart" placeholder="гггг-мм-дд" required="true" value="<?php if(isset($info["forth"]["start"])) echo $info["forth"]["start"]; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputForthFinish">Конец IV четверти <span class="star">*</span></label>
							<input readonly="true" type="text" class="form-control" id="inputForthFinish" name="inputForthFinish" placeholder="гггг-мм-дд"  required="true" value="<?php if(isset($info["forth"]["finish"])) echo $info["forth"]["finish"]; ?>">
						</div>
					</div>
				</div>
				<div class="red" id="responseDateError"></div>
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
		$('#inputYearStart').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#inputYearFinish').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#inputFirstFinish').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#inputSecondStart').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#inputSecondFinish').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#inputThirdStart').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#inputThirdFinish').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#inputForthStart').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#inputForthFinish').datepicker({
			format: 'yyyy-mm-dd',
			startDate: "1993-01-01",
		    language: "ru",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});

		$("#inputYearStart").mask("9999-99-99");
		$("#inputYearFinish").mask("9999-99-99");

		$("#inputFirstStart").mask("9999-99-99");
		$("#inputFirstFinish").mask("9999-99-99");

		$("#inputSecondStart").mask("9999-99-99");
		$("#inputSecondFinish").mask("9999-99-99");

		$("#inputThirdStart").mask("9999-99-99");
		$("#inputThirdFinish").mask("9999-99-99");

		$("#inputForthStart").mask("9999-99-99");
		$("#inputForthFinish").mask("9999-99-99");


		/*$('#inputYearStart').focus(function() {
			$(this).data('oldValue',$(this).val());
		});*/
		$('#inputYearStart').change(function(){
			/*var date = $(this).val();
			var oldValue = $(this).data('oldValue');
			if(isValidDate($.trim(date)) && date.length == 10) {
				//trigger focus to set new oldValue
				$(this).trigger('focus');
				$('#inputFirstStart').val(date);
			} else {
				$('#inputFirstStart').val(oldValue);
				$(this).val(oldValue);
				$(this).trigger('focus');
			}*/
			$('#inputFirstStart').val($(this).val());
		});
		$('#inputYearFinish').change(function(){
			/*var date = $(this).val();
			var oldValue = $(this).data('oldValue');
			if(isValidDate($.trim(date)) && date.length == 10) {
		    //trigger focus to set new oldValue
		    $(this).trigger('focus');
		    $('#inputForthFinish').val(date);
		    } else {
			    $('#inputForthFinish').val(oldValue);
			    $(this).val(oldValue);
			    $(this).trigger('focus');
			   }*/
			$('#inputForthFinish').val($(this).val());
	    });

	$('#save').click(function() {
		var base_url = '<?php echo base_url();?>';
		var s = 0;
		var error = 0;

		var year_start = $('#inputYearStart').val();
		var year_finish = $('#inputYearFinish').val();

		var first_start = $('#inputFirstStart').val();
		var first_finish = $('#inputFirstFinish').val();

		var second_start = $('#inputSecondStart').val();
		var second_finish = $('#inputSecondFinish').val();

		var third_start = $('#inputThirdStart').val();
		var third_finish = $('#inputThirdFinish').val();

		var forth_start = $('#inputForthStart').val();
		var forth_finish = $('#inputForthFinish').val();

		var id = $('#id').text();


		if (year_start.length == 0) {
			$('#inputYearStart').parent().addClass("has-error");
			$('#inputFirstStart').parent().addClass("has-error");
			s++;
		} else {
			$('#inputYearStart').parent().removeClass("has-error");
			$('#inputFirstStart').parent().removeClass("has-error");
		}

		if (year_finish.length == 0) {
			$('#inputYearFinish').parent().addClass("has-error");
			$('#inputForthFinish').parent().addClass("has-error");
			s++;
		} else {
			$('#inputForthFinish').parent().removeClass("has-error");
			$('#inputYearFinish').parent().removeClass("has-error");
		}


		if (first_finish.length == 0) {
			$('#inputFirstFinish').parent().addClass("has-error");
			s++;
		} else {
			$('#inputFirstFinish').parent().removeClass("has-error");
		}

		if (second_finish.length == 0) {
			$('#inputSecondFinish').parent().addClass("has-error");
			s++;
		} else {
			$('#inputSecondFinish').parent().removeClass("has-error");
		}

		if (second_start.length == 0) {
			$('#inputSecondStart').parent().addClass("has-error");
			s++;
		} else {
			$('#inputSecondStart').parent().removeClass("has-error");
		}


		if (third_start.length == 0) {
			$('#inputThirdStart').parent().addClass("has-error");
			s++;
		} else {
			$('#inputThirdStart').parent().removeClass("has-error");
		}

		if (third_finish.length == 0) {
			$('#inputThirdFinish').parent().addClass("has-error");
			s++;
		} else {
			$('#inputThirdFinish').parent().removeClass("has-error");
		}

		if (forth_start.length == 0) {
			$('#inputForthStart').parent().addClass("has-error");
			s++;
		} else {
			$('#inputForthStart').parent().removeClass("has-error");
		}

		if (forth_finish.length == 0) {
			$('#inputForthFinish').parent().addClass("has-error");
			s++;
		} else {
			$('#inputForthFinish').parent().removeClass("has-error");
		}


        $("#responseDateError").text('');
		if (s != 0) {
			$("#error").text('Не все обязательные поля заполнены');
		}
		else {
			$("#error").text('');
			if((year_start < year_finish) && (first_start < first_finish) && (second_start >= first_finish) &&
			(second_start < second_finish) && (second_finish <= third_start) && (third_start < third_finish) &&
			(third_finish <= forth_start) && (forth_start< forth_finish)) {
				$("#responseDateError").text('');
				$.ajax({
					type: "POST",
					url: base_url + "table/responseyear",
					data: "id=" + id + "&yearstart=" + year_start + "&yearfinish=" + year_finish,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						if (response == true) {
						$("#responseDateError").text('В списке уже есть учебный период с указанными годами');
						error++;
					}
					if (response == false) {
						$("#responseDateError").text('');
					}
					}
				});
			}
			else {
				error++;
				$("#responseDateError").text('Есть ошибки в заполнении границ периодов. Проверьте правильность заполнения');
			}
		}
		//alert(s + " " + error);
		if (s == 0 && error == 0) {
			/*if (id == "") {
				$.ajax({
					type: "POST",
					url: base_url + "table/addyear",
					data: "year_start=" + year_start + "&year_finish=" + year_finish +
					"&first_start=" + first_start + "&first_finish=" + first_finish +
					"&second_start=" + second_start + "&second_finish=" + second_finish +
					"&third_start=" + third_start + "&third_finish=" + third_finish +
					"&forth_start=" + forth_start + "&forth_finish=" + forth_finish,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/years';
					}
				});
			}
			else {
				$.ajax({
					type: "POST",
					url: base_url + "table/updateyear",
					data: "year_start=" + year_start + "&year_finish=" + year_finish +
					"&first_start=" + first_start + "&first_finish=" + first_finish +
					"&second_start=" + second_start + "&second_finish=" + second_finish +
					"&third_start=" + third_start + "&third_finish=" + third_finish +
					"&forth_start=" + forth_start + "&forth_finish=" + forth_finish + "&id=" + id,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						document.location.href = base_url + 'admin/years';
				    }
				});
			}*/
		} else return false;
	});


    });
</script>

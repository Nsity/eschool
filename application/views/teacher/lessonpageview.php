<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">Учебное занятие по предмету <strong><?php if(isset($subject)) echo $subject;  ?></strong></div>
				<div class="table-responsive">
					<table  class="table table-striped table-hover ">
						<tbody>
							<tr>
								<td class="col-md-4">Дата</td>
								<td><?php if(isset($date)) echo $date;?></td>
							</tr>
							<tr>
								<td class="col-md-4">Время</td>
								<td><?php if(isset($time)) echo $time;?></td>
							</tr>
							<tr>
								<td class="col-md-4">Тема</td>
								<td><?php if(isset($theme)) echo  $theme;?></td>
							</tr>
							 <tr>
							    <td class="col-md-4">Домашнее задание</td>
							    <td><?php if(isset($homework) && $homework != "")  { ?>
							    <button class="btn btn-sample btn-xs" title="Показать домашнее задание" type="button" data-toggle="modal" data-target="#myModal<?php echo $id ?>"><i class="fa fa-home"></i> Домашнее задание
							    </button>
							    <div class="modal fade" id="myModal<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								    <div class="modal-dialog">
									    <div class="modal-content">
										    <div class="modal-header">
											    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											    <h4 class="modal-title" id="myModalLabel">Домашнее задание</h4>
											</div>
											<div class="modal-body">
												<?php echo $homework ?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							    </td>
					        </tr>
					        <tr>
							    <td class="col-md-4">Урок проведен</td>
							    <td><input type="checkbox" name="my-checkbox" <?php if(isset($status) && $status == 1) echo "checked"; ?>></td>
					        </tr>
					    </tbody>
					</table>
			    </div>
			</div>
	   </div>
	   <div class="col-md-3">
		   <span onclick="location.href='<?php echo base_url();?>teacher/lesson/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4);?>';" class="a-block pull-right" title="Редактировать учебное занятие"><i class="fa fa-pencil"></i> Редактировать занятие</span>
	   </div>
	</div>
	<div class="row">
	    <div class="col-md-8">
		    <h3 class="sidebar-header"><i class="fa fa-users"></i> Список <strong><?php if(isset($class)) echo $class; ?></strong></h3>
		</div>
	    <div class="col-md-4" >
		    <h5><span onclick="print();" class="a-block pull-right" title="Печать"><i class="fa fa-print"></i> Печать</span></h5>
	    </div>
    </div>
	<div class="panel panel-default">
	    <div class="table-responsive">
			<table id="lesson" class="table table-striped table-hover table-bordered numeric">
				<thead>
					<tr>
						<th>#</th>
						<th hidden="true">ID учащегося</th>
						<th style="width: 30%;">ФИО учащегося</th>
						<th hidden="true">Пропуск</th>
						<th style="width: 10%;">Пропуск</th>
						<th>Замечания</th>
						<th>Оценки</th>
						<th>Добавить</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for($i = 0; $i < count($info); $i++) {
						 ?>
						<tr>
							<td data-editable='false'><?php echo $i+1; ?></td>
							<td data-editable='false' hidden="true" id="pupil_id"><?php echo $info[$i]['pupil_id'];?></td>
						    <td data-editable='false' id="pupil_name"><?php echo $info[$i]['pupil_name'];?></td>
						    <td data-editable='false' hidden="true" id="attendance_id"><?php if(isset($info[$i]['pass_id'])) echo $info[$i]['pass_id'];
						    ?></td>
						    <td class="pass <?php if(isset($info[$i]['pass'])) {
							    switch($info[$i]['pass']) {
								    case 'н': {
									    echo "warning";
									    break;
								    }
								    case 'б': {
									    echo "success";
									    break;
								    }
								    case 'у': {
									    echo "info";
									    break;
								    }
								    }
							    }
							    ?>">
								    <?php if(isset($info[$i]['pass']))  echo $info[$i]['pass'];?></td>
						    <td class="note" data-id="<?php echo $info[$i]['note_id']; ?>"><?php echo $info[$i]['note']; ?></td>
						    <td data-editable='false'><?php
							    for($y = 0; $y < count($info[$i]['marks']); $y++) {
								    ?><span data-target="#context-menu" style="cursor: pointer; cursor: hand;"
								    data-toggle="tooltip" data-placement="top" title="<?php echo $info[$i]['marks'][$y]['type']; ?>"
								    data-type="<?php echo $info[$i]['marks'][$y]['type_id']; ?>"
								    data-mark ="<?php echo $info[$i]['marks'][$y]['mark']; ?>"
								    data-id="<?php echo $info[$i]['marks'][$y]['achievement']; ?>" class="btnMark
								    <?php
									    switch($info[$i]['marks'][$y]['mark']) {
										    case '2': {
										    ?> label label-danger <?php
											    break;
											}
											case '3': {
										    ?> label label-primary <?php
											    break;
											}
											case '4': {
										    ?> label label-warning <?php
											    break;
											}
											case '5': {
										    ?> label label-success<?php
											    break;
											}
									    }
									?>"
									><?php echo $info[$i]['marks'][$y]['mark']; ?></span>
								    <?php
							    }
						    ?></td>
						    <td data-editable='false'><button type="button" data-toggle="modal" class="btn btn-sample addMark  btn-xs">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
			                </td>
						</tr>
						 <?php } ?>
			    </tbody>
			</table>
	    </div>
	</div>
	<table style="margin-bottom: 20px;">
		<tr>
			<td><div class="color-swatch brand-success"></div></td>
			<td>Пропуск по болезни (б)</td>
		</tr>
		<tr>
			<td><div class="color-swatch brand-info"></div></td>
			<td>Пропуск по уважительной причине (у)</td>
		</tr>
		<tr>
			<td><div class="color-swatch brand-warning"></div></td>
			<td>Пропуск по неуважительной причине (н)</td>
		</tr>
	</table>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Выставление оценки</h4>
			</div>
			<div class="modal-body">
				<input type="text" id="id" hidden="true">
				<input type="text" id="pupil" hidden="true">
				<div class="form-horizontal">
					<div class="form-group">
						<label for="mark" class="col-sm-3 col-md-3 control-label">Оценка <span class="star">*</span></label>
						<div class="col-sm-9 col-md-9">
							<select id="mark"  class="width-select">
								<option value="5">5</option>
								<option value="4">4</option>
								<option value="3">3</option>
								<option value="2">2</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="type" class="col-sm-3 col-md-3 control-label">Тип оценки <span class="star">*</span></label>
						<div class="col-sm-9 col-md-9">
							<select id="type" class="width-select">
							<?php foreach($types as $type) {?>
							<option value="<?php echo $type['TYPE_ID']; ?>"><?php echo $type['TYPE_NAME']; ?></option>
						    <?php }?>
						    </select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-sample" id="buttonAddMarkModal">Сохранить</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="context-menu">
  <ul class="dropdown-menu" role="menu">
    <li id="editMark"><a tabindex="-1">Редактировать</a></li>
    <li id="deleteMark"><a tabindex="-1">Удалить</a></li>
  </ul>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Удаление оценки</h4>
      </div>
      <div class="modal-body">
        <p>Вы уверены, что хотите удалить эту оценку?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-sample" id="buttonDeleteMarkModal">Удалить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
	$(document).ready(function() {
		$('#lesson').editableTableWidget();

		$('#lesson td.pass').focus(function(){
			$(this).data('oldValue',$(this).text());
		});

		$('#lesson td.pass').on('change', function(evt, newValue) {
			var base_url = '<?php echo base_url();?>';
			//старое значение
		    var oldValue = $(this).data('oldValue');
		    newValue = $.trim(newValue);


		    if (!(newValue == 'н' || newValue == 'у' || newValue == 'б' || newValue == "")) {
			    return false; // reject change
			} else {

				$(this).removeClass();
				//можем редактировать
				if(newValue == 'н') {
					$(this).addClass("warning");
				}
				if(newValue == 'б') {
					$(this).addClass("success");
				}
				if(newValue == 'у') {
					$(this).addClass("info");
				}
				var pupil_id = $(this).parent().find('#pupil_id').html();
				var lesson_id = "<?php echo $this->uri->segment(4);?>";
				var attendance_id = $(this).parent().find('#attendance_id').html();
				if (newValue != oldValue) {
					$.ajax({
						type: "POST",
						url: base_url + "table/changeattendance",
						data: "pupil_id=" + pupil_id + "&lesson_id=" +lesson_id + "&attendance=" + attendance_id + "&pass=" + newValue,
						timeout: 30000,
						async: false,
						error: function(xhr) {
							console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
						},
						success: function(response) {
					    }
					});
				}
		    }
		});

		$('#lesson td.note').focus(function(){
			$(this).data('oldValue',$(this).text());
		});


		$('#lesson td.note').on('change', function(evt, newValue) {

			newValue = $.trim(newValue);
			var base_url = '<?php echo base_url();?>';
			//старое значение
		    var oldValue = $(this).data('oldValue');
			var pupil_id = $(this).parent().find('#pupil_id').html();
			var lesson_id = "<?php echo $this->uri->segment(4);?>";
			var note_id = $(this).attr("data-id");
			if (newValue != oldValue) {
				$.ajax({
					type: "POST",
					url: base_url + "table/changenote",
					data: "pupil_id=" + pupil_id + "&lesson_id=" +lesson_id + "&note_id=" + note_id + "&note=" + newValue,
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
				    }
		    	});
			}
		});

		$("[name='my-checkbox']").bootstrapSwitch();

		$('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
			var base_url = '<?php echo base_url();?>';
			var lesson_id = "<?php echo $this->uri->segment(4);?>";
			if(state == true) {
				var flag = 1;
			} else {
				var flag = 0;
			}
			$.ajax({
				type: "POST",
				url: base_url + "table/changelessonstatus",
				data: "lesson_id=" +lesson_id + "&status=" + flag,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(response) {
			    }
			});
        });


        $('.addMark').click(function() {
		    var pupil_name = $(this).parent().parent().find('#pupil_name').html();
		    var pupil_id = $(this).parent().parent().find('#pupil_id').html();
		    $("#pupil").val(pupil_id);
		    $('#myModal .modal-title').text("Новая оценка для " + pupil_name );
			$('#myModal').modal('show');
		});

		//кнопка редактирования или добавления оценки
		$("#buttonAddMarkModal" ).on('click',function() {
		    var lesson_id = "<?php echo $this->uri->segment(4);?>";
		    var base_url = '<?php echo base_url();?>';
		    var mark = $("#mark").find("option:selected").val();
		    var type = $("#type").find("option:selected").val();
		    var id = $("#id").val();
		    var pupil_id = $("#pupil").val();
		    $.ajax({
				type: "POST",
				url: base_url + "table/changemark",
				data: "pupil_id=" + pupil_id + "&lesson_id=" +lesson_id + "&achievement=" + id + "&mark=" + mark + "&type=" + type,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(a) {
					//alert(a);

					location.reload();
				}
			});
	        $('#myModal').modal('hide');
		});

		//закрытие формы
		$('#myModal').on('hide.bs.modal', function() {
			$("#mark").val($("#mark option:first").val()).trigger('change');
			$("#type").val($("#type option:first").val()).trigger('change');
			$("#pupil").val("");
			$("#id").val("");
		});

		var achievement = null;
		var type = null;
		var mark = null;

		$('.btnMark').on( 'click', function( e ) {
			e.stopPropagation();
			$(this).contextmenu( 'show', e );
			achievement = $(this).attr("data-id");
			mark = $(this).attr("data-mark");
			type = $(this).attr("data-type");
		} )
		.contextmenu();

		//кнопка удаления контекстного меню
		$('#deleteMark').click(function() {
			$('#deleteModal').modal('show');
		});


		//кнопка редактирования контекстного меню
		$('#editMark').click(function() {
			$("#id").val(achievement);
			$("#mark option[value='" + mark + "']").prop("selected", true).trigger('change');
			$("#type option[value='" + type + "']").prop("selected", true).trigger('change');
		    $('#myModal .modal-title').text("Редактирование оценки");
			$('#myModal').modal('show');
		});

		//кнопка удаления на модальном окне
		$('#buttonDeleteMarkModal').click(function() {
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/mark/" + achievement,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(a) {
					location.reload();
				}
			});
	    });


	    $("#type").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});
	 $("#mark").select2({
		minimumResultsForSearch: Infinity,
		language: "ru"
	});

});
</script>


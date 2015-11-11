<?php
	function showDate($date) {
			$day = date('d', strtotime($date));
			$mounth = date('m', strtotime($date));
			$year = date('Y', strtotime($date));
			$data = array('01'=>'января','02'=>'февраля','03'=>'марта','04'=>'апреля','05'=>'мая','06'=>'июня',
			'07'=>'июля', '08'=>'августа','09'=>'сентября','10'=>'октября','11'=>'ноября','12'=>'декабря');
			foreach ($data as $key=>$value) {
				if ($key==$mounth) echo "".ltrim($day, '0')." $value $year года";
			}
	}
?>
<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-list"></i> Список учебных занятий по <strong><?php echo $subject; ?></strong> в <strong><?php echo $class; ?></strong></h3>
	<div class="panel panel-default panel-table">
		<div class="panel-body">
			<button type="button" class="btn btn-menu" id="createButton" title="Добавить учебное занятие"><i class="fa fa-plus fa-2x"></i>
			</br><span class="menu-item">Создать</span>
			</button>
		    <button href="" type="button" class="btn btn-menu disabled" id="editButton" title="Редактировать учебное занятие"><i class="fa fa-pencil fa-2x"></i>
		    </br><span class="menu-item">Редактировать</span>
		    </button>
		    <button type="button" class="btn btn-menu disabled" id="deleteButton" data-toggle="modal" data-target="#myModal" title="Удалить учебное заниятие"><i class="fa fa-trash-o fa-2x"></i>
		    </br><span class="menu-item">Удалить</span>
		    </button>
		    <button href="" type="button" class="btn btn-menu disabled" id="showButton" title="Посмотреть учебное занятие"><i class="fa fa-eye fa-2x"></i>
		    </br><span class="menu-item">Cмотреть</span>
		    </button>
		</div>
	</div>
    <div class="panel panel-default">
	    <div class="panel-body">
		    <form method="get">
			    <div class="input-group">
				    <input type="text" class="form-control" placeholder="Поиск по дате, теме урока и домашнему заданию" id="search" name="search" value="<?php if(isset($search)) echo $search;?>" >
				    <span class="input-group-btn">
				    <button class="btn btn-default" type="submit" name="submit" id="searchButton" title="Поиск"><i class="fa fa-search"></i></button>
				    </span>
				</div><!-- /input-group -->
			</form>
		</div>
	    <div class="table-responsive">
		    <table name="timetable" class="table table-striped table-hover table-bordered numeric" data-sort-name="name" data-sort-order="desc">
			    <thead>
				    <tr>
					    <th></th>
					    <th>Дата урока</th> <!--1-->
					    <th>Время урока</th> <!--1-->
					    <th>Тема урока</th> <!--2-->
					    <th>Статус урока</th>
					    <th>Домашнее задание</th> <!--3-->
					    <!--<th>Загруженные файлы</th>-->
					</tr>
				</thead>
				<tbody>
				<?php
					if(is_array($lessons) && count($lessons) ) {
					foreach($lessons as $lesson) {
				?>
					<tr>
					    <td><input type="radio" name="lesson_id" value="<?php echo $lesson['LESSON_ID'];?>"></td>
						<td ><?php echo $lesson['LESSON_DATE'];?></td>
						<td ><?php echo date("H:i", strtotime($lesson['TIME_START'])).' - '.date("H:i", strtotime($lesson['TIME_FINISH']));?></td>
						<td><?php echo $lesson['LESSON_THEME'];?></td>
						<td><?php if($lesson['LESSON_STATUS'] == 1) echo "Проведен"; else echo "Не проведен";?></td>
						<td>
							<?php if (isset($lesson['LESSON_HOMEWORK']) && $lesson['LESSON_HOMEWORK'] != "") {
							    ?>
							    <button class="btn btn-sample btn-xs" title="Показать домашнее задание" type="button" data-toggle="modal" data-target="#myModal<?php echo $lesson['LESSON_ID'] ?>"><i class="fa fa-home"></i> Домашнее задание
							    </button>
							    <div class="modal fade" id="myModal<?php echo $lesson['LESSON_ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								    <div class="modal-dialog">
									    <div class="modal-content">
										    <div class="modal-header">
											    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											    <h4 class="modal-title" id="myModalLabel">Домашнее задание по уроку за <?php showDate($lesson['LESSON_DATE']);?></h4>
											</div>
											<div class="modal-body">
												<?php echo $lesson['LESSON_HOMEWORK']; ?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
											</div>
										</div>
									</div>
								</div>
							    <?php
						    } ?>
						</td>
						<!--<td>
							<?php
								foreach($files[$lesson['LESSON_ID']] as $file) {
									?>
									<a href="<?php  echo base_url()."files/".$file['FILE_ID'].".".$file['FILE_EXTENSION']; ?>"><span class="glyphicon glyphicon-file" aria-hidden="true"><?php echo $file['FILE_NAME'].".".$file['FILE_EXTENSION'];  ?></a></br>
									<?php
								}
								?>
						</td>-->
					</tr>
					<?php }} ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $this->pagination->create_links(); ?>
	<?php
		if(count($lessons) == 0 && isset($search) && $search != "") {
	?>
	<div class="alert alert-info" role="alert">Поиск не дал результатов. Попробуйте другой запрос</div>
	<?php } ?>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		if($(":radio[name=lesson_id]").is(':checked')) {
			$('#editButton').removeClass('disabled');
			$('#showButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		} else {
			$('#editButton').addClass('disabled');
			$('#deleteButton').addClass('disabled');
			$('#showButton').addClass('disabled');
		}
		$(":radio[name=lesson_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#showButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		});
	    $('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>teacher/lesson/' + '<?php  echo $this->uri->segment(3); ?>';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=lesson_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>teacher/lesson/' + '<?php  echo $this->uri->segment(3); ?>' + '/' + value;
		});


		$('#buttonDeleteLessonModal').click(function() {
			var value = $(":radio[name=lesson_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/lesson/" + value,
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

		$("tr:not(:first)").click(function() {
			$(this).children("td").find('input[type=radio]').prop('checked', true).change();
		});

		$('#showButton').click(function() {
			var value = $(":radio[name=lesson_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>teacher/lessonpage/' + '<?php  echo $this->uri->segment(3); ?>' + '/' + value;
		});

    });
</script>




<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Удаление учебного занятия</h4>
      </div>
      <div class="modal-body">
        <p>Вы уверены, что хотите удалить это учебное занятие?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-sample" id="buttonDeleteLessonModal">Удалить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



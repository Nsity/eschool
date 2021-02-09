<?php
	function hidePassword($password) {
		$s = "";
		for($i = 0; $i < strlen($password); $i++) {
			$s = $s."*";
		}
		echo $s;
	}
?>
<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-user"></i> Список учащихся</h3>
	<div class="panel panel-default panel-table">
		<div class="panel-body">
			<button type="button" class="btn btn-menu" id="createButton" title="Добавить учащегося"><i class="fa fa-plus fa-2x"></i>
			</br><span class="menu-item">Создать</span>
			</button>
		    <button href="" type="button" class="btn btn-menu disabled" id="editButton" title="Редактировать учащегося"><i class="fa fa-pencil fa-2x"></i>
		    </br><span class="menu-item">Редактировать</span>
		    </button>
		    <button type="button" class="btn btn-menu disabled" id="deleteButton" data-toggle="modal" data-target="#myModal" title="Удалить учащегося"><i class="fa fa-trash-o fa-2x"></i>
		    </br><span class="menu-item">Удалить</span>
		    </button>
		    <button href="" type="button" class="btn btn-menu disabled" id="progressButton" title="Успеваемость учащегося"><i class="fa fa-line-chart fa-2x"></i></i>
		    </br><span class="menu-item">Успеваемость</span>
		    </button>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<form method="get">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Поиск по ФИО, логину, дате рождения, адресу и номеру телефона" id="search" name="search" value="<?php if(isset($search)) echo $search;?>" >
					<span class="input-group-btn">
					<button class="btn btn-default" type="submit" name="submit" id="searchButton" title="Поиск"><i class="fa fa-search"></i></button>
					</span>
				</div><!-- /input-group -->
			</form>
		</div>
	    <div class="table-responsive">
		    <table name="timetable" class="table table-striped table-hover table-bordered numeric">
			    <thead>
				    <tr>
					    <th></th>
					    <th>ФИО учащегося</th>
					    <th>Логин</th>
					    <th>Пароль</th>
					    <th>Статус</th>
					    <th>Дата рождения</th>
					    <th>Домашний адрес</th>
					    <th>Телефон</th>
					</tr>
				</thead>
				<tbody>
				<?php
					if(is_array($pupils) && count($pupils) ) {
					foreach($pupils as $pupil) {
				?>
					<tr>
					    <td><input type="radio" name="pupil_id" value="<?php echo $pupil['PUPIL_ID'];?>"></td>
						<td><?php echo $pupil['PUPIL_NAME'];?></td>
						<td><?php echo $pupil['PUPIL_LOGIN'];?></td>
						<td><span data-toggle="tooltip" data-placement="top" title="<?php echo $pupil['PUPIL_PASSWORD']; ?>"><?php hidePassword($pupil['PUPIL_PASSWORD']);?></span></td>
						<td><?php if($pupil['PUPIL_STATUS'] == 0) echo "Не активен"; else echo "Активен";?></td>
						<td><?php if(isset($pupil['PUPIL_BIRTHDAY'])) echo $pupil['PUPIL_BIRTHDAY'];?></td>
						<td><?php echo $pupil['PUPIL_ADDRESS'];?></td>
						<td><?php echo $pupil['PUPIL_PHONE'];?></td>
					</tr>
					<?php }} ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $this->pagination->create_links(); ?>
		<?php
		if(count($pupils) == 0 && isset($search) && $search != "") {
	?>
	<div class="alert alert-info" role="alert">Поиск не дал результатов. Попробуйте другой запрос</div>
	<?php } ?>
</div>


<script type="text/javascript">
	$(document).ready(function() {

		if($(":radio[name=pupil_id]").is(':checked')) {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
			$('#progressButton').removeClass('disabled');
		} else {
			$('#editButton').addClass('disabled');
			$('#deleteButton').addClass('disabled');
			$('#progressButton').addClass('disabled');
		}

		$(":radio[name=pupil_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
			$('#progressButton').removeClass('disabled');
		});

		$('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>teacher/pupil';
		});

		$('#progressButton').click(function() {
			var value = $(":radio[name=pupil_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>teacher/pupil/'+value+'/progress';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=pupil_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>teacher/pupil/' + value;
		});


		$('#buttonDeletePupilModal').click(function() {
			var value = $(":radio[name=pupil_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/pupil/" + value,
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
    });
</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Удаление учащегося</h4>
      </div>
      <div class="modal-body">
        <p>Вы уверены, что хотите удалить этого учащегося?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-sample" id="buttonDeletePupilModal">Удалить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

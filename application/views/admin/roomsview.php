<script src="<?php echo base_url();?>bootstrap/js/jquery-2.1.1.min.js" type="text/javascript"></script>
<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-building"></i> Список кабинетов</h3>
	<div class="panel panel-default panel-table">
		<div class="panel-body">
			<button type="button" class="btn btn-menu" id="createButton" title="Добавить кабинет"><i class="fa fa-plus fa-2x"></i>
			</br><span class="menu-item">Создать</span>
			</button>
		    <button href="" type="button" class="btn btn-menu disabled" id="editButton" title="Редактировать кабинет"><i class="fa fa-pencil fa-2x"></i>
		    </br><span class="menu-item">Редактировать</span>
		    </button>
		    <button type="button" class="btn btn-menu disabled" id="deleteButton" data-toggle="modal" data-target="#myModal" title="Удалить кабинет"><i class="fa fa-trash-o fa-2x"></i>
		    </br><span class="menu-item">Удалить</span>
		    </button>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<form method="get">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Поиск по наименованию" id="search" name="search" value="<?php if(isset($search)) echo $search;?>" >
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
					    <th class="col-md-1"></th>
					    <th>Наименование</th> <!--1-->
					</tr>
				</thead>
				<tbody>
				<?php
					if(is_array($rooms) && count($rooms) ) {
					foreach($rooms as $room) {
				?>
					<tr>
					    <td><input type="radio" name="room_id" value="<?php echo $room['ROOM_ID'];?>"></td>
						<td><?php echo $room['ROOM_NAME'];?></td>
					</tr>
					<?php }} ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $this->pagination->create_links(); ?>
		<?php
		if(count($rooms) == 0 && isset($search) && $search != "") {
	?>
	<div class="alert alert-info" role="alert">Поиск не дал результатов. Попробуйте другой запрос</div>
	<?php } ?>
</div>


<script type="text/javascript">
	$(document).ready(function() {

		if($(":radio[name=room_id]").is(':checked')) {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		} else {
			$('#editButton').addClass('disabled');
			$('#deleteButton').addClass('disabled');
		}



		$(":radio[name=room_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		});

		$('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>admin/room';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=room_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>admin/room/' + value;
		});


		$('#buttonDeleteRoomModal').click(function() {
			var value = $(":radio[name=room_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/room/" + value,
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
        <h4 class="modal-title">Удаление кабинета</h4>
      </div>
      <div class="modal-body">
        <p>Вы уверены, что хотите удалить этот кабинет?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-sample" id="buttonDeleteRoomModal">Удалить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

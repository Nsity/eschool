<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-calendar"></i> Список учебных годов</h3>
	<div class="panel panel-default panel-table">
		<div class="panel-body">
			<button type="button" class="btn btn-menu" id="createButton" title="Добавить учебный год"><i class="fa fa-plus fa-2x"></i>
			</br><span class="menu-item">Создать</span>
			</button>
		    <button href="" type="button" class="btn btn-menu disabled" id="editButton" title="Редактировать учебный год"><i class="fa fa-pencil fa-2x"></i>
		    </br><span class="menu-item">Редактировать</span>
		    </button>
		    <button type="button" class="btn btn-menu disabled" id="deleteButton" data-toggle="modal" data-target="#myModal" title="Удалить учебный год"><i class="fa fa-trash-o fa-2x"></i>
		    </br><span class="menu-item">Удалить</span>
		    </button>
		</div>
	</div>
   	<div class="panel panel-default">
	    <div class="table-responsive">
		    <table name="timetable" class="table table-striped table-hover table-bordered numeric">
			    <thead>
				    <tr>
					    <th></th>
					    <th colspan="2">Учебный год</th> <!--1-->
					    <th colspan="2">I четверть</th> <!--1-->
					    <th colspan="2">II четверть</th> <!--1-->
					    <th colspan="2">III четверть</th> <!--1-->
					    <th colspan="2">IV четверть</th> <!--1-->
					</tr>
					<tr>
						<th style="border-bottom-width: 1px;"></th>
					    <th style="border-bottom-width: 1px;">Начало</th>
					    <th style="border-bottom-width: 1px;">Конец</th>
					    <th style="border-bottom-width: 1px;">Начало</th>
					    <th style="border-bottom-width: 1px;">Конец</th>
					    <th style="border-bottom-width: 1px;">Начало</th>
					    <th style="border-bottom-width: 1px;">Конец</th>
					    <th style="border-bottom-width: 1px;">Начало</th>
					    <th style="border-bottom-width: 1px;">Конец</th>
					    <th style="border-bottom-width: 1px;">Начало</th>
					    <th style="border-bottom-width: 1px;">Конец</th>
					</tr>

				</thead>
				<tbody>
				<?php
					if(is_array($periods) && count($periods) ) {
					for($i =0; $i < count($periods); $i++){
				?>
					<tr>
					    <td><input type="radio" name="year_id" value="<?php echo $periods[$i]["id"];?>"></td>
						<td><?php echo $periods[$i]["fifth"]["start"];?></td>
						<td><?php echo $periods[$i]["fifth"]["finish"];?></td>
						<td><?php if(isset($periods[$i]["first"]["start"])) echo $periods[$i]["first"]["start"];?></td>
						<td><?php if(isset($periods[$i]["first"]["finish"])) echo $periods[$i]["first"]["finish"];?></td>
						<td><?php if(isset($periods[$i]["second"]["start"])) echo $periods[$i]["second"]["start"];?></td>
						<td><?php if(isset($periods[$i]["second"]["finish"])) echo $periods[$i]["second"]["finish"];?></td>
						<td><?php if(isset($periods[$i]["third"]["start"]))echo $periods[$i]["third"]["start"];?></td>
						<td><?php if(isset($periods[$i]["third"]["finish"]))echo $periods[$i]["third"]["finish"];?></td>
						<td><?php if(isset($periods[$i]["forth"]["start"])) echo $periods[$i]["forth"]["start"];?></td>
						<td><?php if(isset($periods[$i]["forth"]["finish"])) echo $periods[$i]["forth"]["finish"];?></td>
					</tr>
					<?php }} ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $this->pagination->create_links(); ?>
		<?php
		if(is_array($periods) && count($periods) == 0 && isset($search) && $search != "") {
	?>
	<div class="alert alert-info" role="alert">Поиск не дал результатов. Попробуйте другой запрос</div>
	<?php } ?>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$(":radio[name=year_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		});

		$('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>admin/year';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=year_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>admin/year/' + value;
		});

		$('#searchButton').click(function() {
			//$('#search').slideToggle("fast");
		});

		$('#buttonDeleteYearModal').click(function() {
			var value = $(":radio[name=year_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/year/" + value,
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
        <h4 class="modal-title">Удаление учебного года</h4>
      </div>
      <div class="modal-body">
        <p>Вы уверены, что хотите удалить этот учебный год?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-sample" id="buttonDeleteYearModal">Удалить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

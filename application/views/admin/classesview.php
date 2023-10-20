<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-users"></i> Список классов</h3>
	
	<?php $this->load->view('common/editpanel'); ?>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<?php $this->load->view('common/searchform', array('placeholder' => "Поиск по параллели, номеру класса и классному руководителю")); ?>
		</div>
			<div class="table-responsive">
				<table name="timetable" class="table table-striped table-hover table-bordered numeric">
					<thead>
						<tr>
							<th></th>
							<th>Параллель</th>
							<th>Буква</th>
							<th>Учебный год</th>
							<th>Текущий</th>
							<th>Классный руководитель</th>
						 <!-- <th>Переведен из</br>другого класса</th>-->
					</tr>
				</thead>
				<tbody>
				<?php
					if(is_array($classes) && count($classes) ) {
						foreach($classes as $class) {
				?>
					<tr>
						<td>
							<input type="radio" name="class_id" value="<?php echo $class['CLASS_ID'];?>">
						</td>
						<td><?php echo $class['CLASS_NUMBER'];?></td>
						<td><?php echo $class['CLASS_LETTER'];?></td>
						<td><?php if(isset($class['YEAR_ID'])) echo date("Y",strtotime($class['YEAR_START']))." - ".date("Y",strtotime($class['YEAR_FINISH']))." гг.";?></td>
						<td><?php if($class['CLASS_STATUS'] == 0) {echo "Нет";} else echo "Да";?></td>
						<td><?php if(isset($class['TEACHER_ID'])) echo $class['TEACHER_NAME'];?></td>
						<!--<td><?php if(isset($class['CLASS_PREVIOUS'])) echo "Да"; else echo "Нет";?></td>-->
					</tr>
				<?php 
					}} 
				?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		echo $this->pagination->create_links(); 
		if(is_array($classes) && count($classes) == 0 && isset($search) && $search != "") {
			$this->load->view('common/searchalert');
		}
	?>
</div>


<script type="text/javascript">
	$(document).ready(function() {


		if($(":radio[name=class_id]").is(':checked')) {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		} else {
			$('#editButton').addClass('disabled');
			$('#deleteButton').addClass('disabled');
		}

		$(":radio[name=class_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		});

		$('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>admin/classitem';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=class_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>admin/classitem/' + value;
		});


		$('#buttonDeleteModal').click(function() {
			var value = $(":radio[name=class_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/class/" + value,
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

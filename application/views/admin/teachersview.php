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
	<h3 class="sidebar-header"><i class="fa fa-user"></i> Список учителей</h3>
	
	<?php $this->load->view('common/editpanel'); ?>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<?php $this->load->view('common/searchform', array('placeholder' => "Поиск по ФИО и логину")); ?>
		</div>
		<div class="table-responsive">
			<table name="timetable" class="table table-striped table-hover table-bordered numeric">
				<thead>
					<tr>
						<th></th>
						<th data-sortable="true">ФИО учителя</th> <!--1-->
						<th>Логин</th> <!--2-->
						<th>Пароль</th> <!--3-->
						<th>Статус</th> <!--5-->
					</tr>
				</thead>
				<tbody>
				<?php foreach($teachers as $teacher) : ?>
					<tr>
						<td><input type="radio" name="teacher_id" value="<?php echo $teacher['TEACHER_ID'];?>"></td>
						<td ><?php echo $teacher['TEACHER_NAME'];?></td>
						<td><?php echo $teacher['TEACHER_LOGIN'];?></td>
						<td><span data-toggle="tooltip" data-placement="top" title="<?php echo $teacher['TEACHER_PASSWORD']; ?>">
							<?php hidePassword($teacher['TEACHER_PASSWORD']);?></span></td>
						<td><?php if($teacher['TEACHER_STATUS'] == 0) echo "Не активен"; else echo "Активен";?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		echo $this->pagination->create_links(); 

		if(count($teachers) == 0 && isset($search) && $search != "") {
			$this->load->view('common/searchalert');
		}
	?>
</div>


<script type="text/javascript">
	$(document).ready(function() {

		if($(":radio[name=teacher_id]").is(':checked')) {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		} else {
			$('#editButton').addClass('disabled');
			$('#deleteButton').addClass('disabled');
		}
		$(":radio[name=teacher_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		});
		$('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>admin/teacher';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=teacher_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>admin/teacher/' + value;
		});


		$('#buttonDeleteModal').click(function() {
			var value = $(":radio[name=teacher_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/teacher/" + value,
				//data: "id=" + value + "&from=subjects",
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






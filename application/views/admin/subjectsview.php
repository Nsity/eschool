<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-book"></i> Список общих предметов</h3>
	
	<?php $this->load->view('common/editpanel'); ?>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<?php $this->load->view('common/searchform'); ?>
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
				<?php foreach($subjects as $subject) : ?>
					<tr>
						<td><input type="radio" name="subject_id" value="<?php echo $subject['SUBJECT_ID'];?>"></td>
						<td><?php echo $subject['SUBJECT_NAME'];?></td>
					</tr>
				<?php  endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		echo $this->pagination->create_links(); 

		if(count($subjects) == 0 && isset($search) && $search != "") {
			$this->load->view('common/searchalert');
		}
	?>
</div>


<script type="text/javascript">
	$(document).ready(function() {

		if($(":radio[name=subject_id]").is(':checked')) {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		} else {
			$('#editButton').addClass('disabled');
			$('#deleteButton').addClass('disabled');
		}


		$(":radio[name=subject_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		});

		$('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>admin/subject';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=subject_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>admin/subject/' + value;
		});


		$('#buttonDeleteModal').click(function() {
			var value = $(":radio[name=subject_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/subject/" + value,
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







<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-paperclip"></i> Список типов оценок</h3>
	
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
							<th>Наименование</th> 
						</tr>
					</thead>
					<tbody>
					<?php foreach($types as $type) : ?>
						<tr>
							<td><input type="radio" name="type_id" value="<?php echo $type['TYPE_ID'];?>"></td>
							<td><?php echo $type['TYPE_NAME'];?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		echo $this->pagination->create_links();
		
		if(count($types) == 0 && isset($search) && $search != "") {
			$this->load->view('common/searchalert');
		} 
	?>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$(":radio[name=type_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		});

		$('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>admin/type';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=type_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>admin/type/' + value;
		});

		$('#searchButton').click(function() {
			//$('#search').slideToggle("fast");
		});

		$('#buttonDeleteModal').click(function() {
			var value = $(":radio[name=type_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/type/" + value,
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
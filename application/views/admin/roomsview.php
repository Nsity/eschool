<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-building"></i> Список кабинетов</h3>
	
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
				<?php foreach($rooms as $room) : ?>
					<tr>
						<td><input type="radio" name="room_id" value="<?php echo $room['ROOM_ID'];?>"></td>
						<td><?php echo $room['ROOM_NAME'];?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php 
		echo $this->pagination->create_links(); 
		
		if(count($rooms) == 0 && isset($search) && $search != "") {
			$this->load->view('common/searchalert');
		} 
	?>
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

		$('#buttonDeleteModal').click(function() {
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

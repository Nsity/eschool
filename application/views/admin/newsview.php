<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-newspaper-o"></i> Список новостей</h3>
	
	<?php $this->load->view('common/editpanel'); ?>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<?php $this->load->view('common/searchform', array('placeholder' => "Поиск по дате, теме и тексту новости")); ?>
		</div>
		<div class="table-responsive">
			<table name="timetable" class="table table-striped table-hover table-bordered numeric" id="news">
				<thead>
					<tr>
						<th></th>
						<th style="width: 15%;">Дата</th>
						<th>Тема</th> <!--1-->
						<th>Текст</th> <!--1-->
					</tr>
				</thead>
				<tbody>
				<?php foreach($news as $newsitem) : ?>
					<tr>
						<td>
							<input type="radio" name="news_id" value="<?php echo $newsitem['NEWS_ID'];?>">
						</td>
						<td><?php echo $newsitem['NEWS_TIME'];?></td>
						<td><?php echo $newsitem['NEWS_THEME'];?></td>
						<td><?php echo $newsitem['NEWS_TEXT'];?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		echo $this->pagination->create_links(); 
		
		if(count($news) == 0 && isset($search) && $search != "") {
			$this->load->view('common/searchalert');
		} 
	?>
</div>


<script type="text/javascript">
	$(document).ready(function() {

		//$("#news").tablesorter();
		//$("#news").tablesorter( {sortList: [[0,0], [1,0]]} );

		if($(":radio[name=news_id]").is(':checked')) {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		} else {
			$('#editButton').addClass('disabled');
			$('#deleteButton').addClass('disabled');
		}

		$(":radio[name=news_id]").change(function() {
			$('#editButton').removeClass('disabled');
			$('#deleteButton').removeClass('disabled');
		});

		$('#createButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>admin/newsitem';
		});

		$('#editButton').click(function() {
			var value = $(":radio[name=news_id]").filter(":checked").val();
			document.location.href = '<?php  echo base_url(); ?>admin/newsitem/' + value;
		});


		$('#buttonDeleteModal').click(function() {
			var value = $(":radio[name=news_id]").filter(":checked").val();
			var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/news/" + value,
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

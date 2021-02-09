<?php
	function showDate($date) {
		$day = date('d', strtotime($date));
		$mounth = date('m', strtotime($date));
		$year = date('Y', strtotime($date));
		$hours = date('H', strtotime($date));
		$minutes = date('i', strtotime($date));
		$data = array('01'=>'января','02'=>'февраля','03'=>'марта','04'=>'апреля','05'=>'мая','06'=>'июня',
		'07'=>'июля', '08'=>'августа','09'=>'сентября','10'=>'октября','11'=>'ноября','12'=>'декабря');

		$today_year = date('Y');
		$today_day = date('d');

		foreach ($data as $key=>$value) {
			if ($key==$mounth)  {
				if ($year < $today_year) {
					echo ltrim($day, '0')." $value $year года";
				} else {
					if ($day != $today_day) {
						echo ltrim($day, '0')." $value"." в ".$hours.":".$minutes;
					}
					else {
						echo "в ".$hours.":".$minutes;
					}
				}
			}
		}
	}
?>
<div class="container">
	<h3 class="sidebar-header"><i class="fa fa-envelope-o"></i> Общение</h3>
	<div class="panel panel-default panel-table">
		<div class="panel-body">
			<button type="button" class="btn btn-menu" id="writeButton" title="Написать сообщение"><i class="fa fa-plus fa-2x"></i></i>
			</br><span class="menu-item">Написать</span>
		    </button>
		    <button type="button" class="btn btn-menu disabled" id="readButton" title="Отметить прочитано"><i class="fa fa-check-square-o fa-2x"></i>
		    </br><span class="menu-item">Прочитано</span>
		    </button>
		    <button type="button" class="btn btn-menu disabled" id="deleteButton" data-toggle="modal" data-target="#myModal" title="Удалить переписку"><i class="fa fa-trash-o fa-2x"></i>
		    </br><span class="menu-item">Удалить</span>
		    </button>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<form method="get">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Поиск по собеседникам" id="search" name="search" value="<?php if(isset($search)) echo $search;?>" >
				 	<span class="input-group-btn">
				 	<button class="btn btn-default" type="submit" name="submit" id="searchButton" title="Поиск"><i class="fa fa-search"></i></button>
				 	</span>
				</div><!-- /input-group -->
		    </form>
		</div>
		<div class="table-responsive">
			<table name="timetable" class="table table-striped table-hover numeric">
				<thead>
					<tr>
						<th><input type="checkbox" id="all"></th>
						<th>Собеседник</th>
						<th style="text-align: center; width: 20%;">Сообщений</th>
						<th style="text-align: center; width: 20%;">Новых</th>
					</tr>
				</thead>
		    	<tbody>
							<?php if(is_array($messages) && count($messages) ) {
								$i = 0;
								foreach($messages as $message){ ?>
					<tr style="cursor: pointer; cursor: hand;">
						<td><input type="checkbox" name="users[]" value="<?php echo $message['USER_ID']; ?>"</td>
						<td><?php echo $message['USER_NAME']; ?></br>
										 <span style="font-size: 12px; color: grey; font-style: italic;">Последнее сообщение
										 <?php showDate($message['MAX']); ?></span></td>
						<td style="vertical-align: middle; text-align: center;"><?php echo $message['COUNT']; ?></td>
						<td style="vertical-align: middle; text-align: center;"><?php if(isset($result[$i]["new"])) {?><span class="green"><?php echo $result[$i]["new"];?></span><?php } else echo "-";  ?></td>
					</tr>
								<?php $i++; }
									} ?>
			    </tbody>
			</table>
		</div>
	</div>
	<?php echo $this->pagination->create_links(); ?>
	<?php
		if(count($messages) == 0 && isset($search) && $search != "") {
	?>
	<div class="alert alert-info" role="alert">Поиск не дал результатов. Попробуйте другой запрос</div>
	<?php } ?>
</div>


<script type="text/javascript">
    $(document).ready(function() {
	    $("#all").change(function(){
		    $("input[name='users[]']").prop('checked', this.checked);
		   	if(this.checked == true) {
		    	$('#deleteButton').removeClass('disabled');
		    	$('#readButton').removeClass('disabled');
	    	} else {
		    	$('#deleteButton').addClass('disabled');
		    	$('#readButton').addClass('disabled');
		    }
		});

		$('#writeButton').click(function() {
			document.location.href = '<?php  echo base_url(); ?>messages/message';
		});


		$('table tbody td input[type=checkbox]').click( function (e) {
			var s = 0;
			$("input[name='users[]']:checked").each(function () {
				s++;
			});
			if(s != 0) {
				$('#deleteButton').removeClass('disabled');
		    	$('#readButton').removeClass('disabled');
	    	} else {
		    	$('#deleteButton').addClass('disabled');
		    	$('#readButton').addClass('disabled');
		    }
			e.stopPropagation();
		});


		$('#buttonDeleteMessageModal').click(function() {
			var base_url = '<?php echo base_url();?>';
			var checked = [];
			$("input[name='users[]']:checked").each(function () {
				checked.push($(this).val());
			});

			for(var i = 0; i < checked.length; i++ ) {
				$.ajax({
					type: "POST",
					url: base_url + "table/del/conversation/" + checked[i],
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(a) {
						//alert(a);
					}
				});
			}
			location.reload();
		});

		$('#readButton').click(function() {
			var base_url = '<?php echo base_url();?>';
			var checked = [];
			$("input[name='users[]']:checked").each(function () {
				checked.push($(this).val());
			});

			for(var i = 0; i < checked.length; i++ ) {
				$.ajax({
					type: "POST",
					url: base_url + "table/readconversation/" + checked[i],
					timeout: 30000,
					async: false,
					error: function(xhr) {
						console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(a) {
						//alert(a);
					}
				});
			}
			location.reload();
		});

		$("tr:not(:first)").click(function(e) {
			var base_url = '<?php echo base_url();?>';
			var id = $(this).children("td").find("input[name='users[]']").val();
			/*$.ajax({
				type: "POST",
				url: base_url + "table/readconversation/" + id,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(a) {
					//alert(a);
				}
			});*/
			window.location.href = '<?php  echo base_url(); ?>messages/conversation/'+ id;
		});
    });
</script>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Удаление переписок</h4>
      </div>
      <div class="modal-body">
        <p>Вы уверены, что хотите удалить эти переписки?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-sample" id="buttonDeleteMessageModal">Удалить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
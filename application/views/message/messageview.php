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
						echo ltrim($day, '0')." $value";
					}
					else {
						echo $hours.":".$minutes;
					}
				}
			}
		}
	}
?>
<!--<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="list-group">
				<a href="<?php echo base_url();?>messages/inbox" class="list-group-item <?php if ($active == 1) echo 'active'; ?>">Входящие <?php if ($badge != 0) {?> <span class="badge"><?php echo $badge;?></span> <?php } ?></a>
				<a href="<?php echo base_url();?>messages/sent" class="list-group-item <?php if ($active == 2) echo 'active'; ?>">Исходящие</a>
			</div>
		</div>-->
	    <div class="col-md-9">
		    <div class="panel panel-default">
			    <div class="panel-heading">
				    <button type="button" class="btn btn-menu" id="writeButton" >
				        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></br>Написать
				    </button>
				    <button type="button" class="btn btn-menu disabled" id="readButton" >
				        <span class="glyphicon glyphicon-check" aria-hidden="true"></span></br>Прочитано
				    </button>
				    <button type="button" class="btn btn-menu disabled" id="deleteButton" data-toggle="modal" data-target="#myModal" title="Удалить сообщение">
				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></br>Удалить
		    </button>
				</div>
				<div class="panel-body">
     <form method="get">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Поиск..." id="search" name="search" value="<?php if(isset($search)) echo $search;?>" >
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit" name="submit" id="searchButton" title="Поиск"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
      </span>
    </div><!-- /input-group -->
	 </form>
  </div>
				<div class="table-responsive">
					<table name="timetable" class="table table-striped table-bordered table-hover numeric">
						<thead>
							<tr>
								<th><input type="checkbox" id="all"></th>
								<th><?php if ($active == 'inbox') echo 'От кого'; else echo 'Кому';  ?></th>
								<th>Текст сообщения</th>
								<th>Дата</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($messages) && count($messages) ) {
								foreach($messages as $message){ ?>
								<?php if($active == 'inbox' && $message['MESSAGE_READ'] == 0) { ?><tr class="info"><?php } else { ?><tr><?php }?>
								<td><input type="checkbox" name="messages[]" value="<?php echo $message['USER_MESSAGE_ID']; ?>"></td>
								<td class="col-md-5"><?php echo $message['USER_NAME'];?></td>
								<td class="col-md-5"><?php echo $message['MESSAGE_TEXT']; ?></td>
								<td class="col-md-2"><?php showDate($message['MESSAGE_DATE']);?></td>
								</tr>
			<?php }}?>
			            </tbody>
					</table>
				</div>
			</div>
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
	    $("#all").change(function(){
		    $("input[name='messages[]']").prop('checked', this.checked);
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

		$("table tbody td input[name='messages[]']").click(function(e){
			var s = 0;
			$("input[name='messages[]']:checked").each(function () {
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
			$("input[name='messages[]']:checked").each(function () {
				checked.push($(this).val());
			});

			for(var i = 0; i < checked.length; i++ ) {
				$.ajax({
					type: "POST",
					url: base_url + "table/del/message/" + checked[i],
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
			$("input[name='messages[]']:checked").each(function () {
				checked.push($(this).val());
			});

			for(var i = 0; i < checked.length; i++ ) {
				$.ajax({
					type: "POST",
					url: base_url + "table/readmessage/" + checked[i],
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


		$("tr:not(:first)").click(function() {
			if ($(this).children("td").find("input[name='messages[]']").is(":checked")) {
				var attr = false;
			} else {
				var attr = true;
			}
			$(this).children("td").find("input[name='messages[]']").prop('checked', attr).change();
		});
    });
</script>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Удаление сообщений</h4>
      </div>
      <div class="modal-body">
        <p>Вы уверены, что хотите удалить эти сообщения?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-sample" id="buttonDeleteMessageModal">Удалить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



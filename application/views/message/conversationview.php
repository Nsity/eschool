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
						echo ltrim($day, '0')." $value $year года в ".$hours.":".$minutes;
					}
					else {
						echo "Сегодня в ".$hours.":".$minutes;
					}
				}
			}
		}
	}
?>
<div class="container">
	<div class="row">
    <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
		<div class="panel-body">
			<div class="form-group">
				<textarea style="resize: vertical;" class="form-control" rows="3" maxlength="500" id="inputText" name="inputText" placeholder="Текст сообщения"></textarea>
			</div>
			<div class="modal-footer" style="margin-bottom: -15px; padding-right: 0px;">
				<button type="button" class="btn btn-sample" name="send" id="send" title="Отправить">Отправить</button>
			</div>
		</div>
	</div>
	<h3 class="sidebar-header"><i class="fa fa-comments"></i> Общение с <strong><?php echo $user; ?></strong></h3>
    <div class="panel panel-default">
		<div class="panel-body">
			<form method="get">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Поиск по сообщениям" id="search" name="search" value="<?php if(isset($search)) echo $search;?>" >
					<span class="input-group-btn">
					<button class="btn btn-default" type="submit" name="submit" id="searchButton" title="Поиск"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					</span>
				</div><!-- /input-group -->
			</form>
		</div>
		<div class="table-responsive">
		    <table name="timetable" class="table table-hover table-striped  numeric" >
			    <tbody>
						<?php if(is_array($messages) && count($messages) ) {
								foreach($messages as $message){ ?>
								<?php if($message['MESSAGE_READ'] == 0 && $message['MESSAGE_FOLDER'] == 1) { ?><tr class="info"><?php } else { ?><tr><?php }?>
									<td hidden="true"><input type="radio" name="message_id" value="<?php echo $message['USER_MESSAGE_ID'];?>"></td>
									<td>
										<button hidden="true" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<strong><?php if($message['MESSAGE_FOLDER'] == 1) echo $message['USER_NAME']; else echo "Я"; ?></strong> <span style="font-size: 12px; font-style: italic;" class="time"><?php showDate($message['MESSAGE_DATE']); ?></span></br>
									<span style="display: block; padding-top: 10px;"><?php echo $message['MESSAGE_TEXT']; ?></span>
									</td>
								</tr>
								<?php }
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
	</div></div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
	    $('.close').click(function() {
		    var value = $(this).closest("tr").find(':radio[name=message_id]').val();
		    var base_url = '<?php echo base_url();?>';
			$.ajax({
				type: "POST",
				url: base_url + "table/del/message/" + value,
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

		$('#send').click(function() {
		    var id = "<?php  echo $this->uri->segment(3);?>";
		    var text = $.trim($('#inputText').val());
		    var base_url = '<?php echo base_url();?>';
		    if(text.length != "") {
			    $.ajax({
				    type: "POST",
				    url: base_url + "table/addmessage",
				    data:  "id=" + id + "&text=" + text,
				    timeout: 30000,
				    async: false,
				    error: function(xhr) {
					    console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
					},
					success: function(response) {
						location.reload();
				    }
				});
		    } else {
				return false;
			}
		});

		$('#inputText').on('keyup', function(e) {
			if (e.which == 13 && ! e.shiftKey) {
				$('#send').click();
			}
	    });

		$('table tr').mouseover(function() {
			var tr = $(this);
			var base_url = '<?php echo base_url();?>';
			$(this).find('.close').attr('hidden', false);
			var value = $(this).find(':radio[name=message_id]').val();
			//alert(value);
			$.ajax({
				type: "POST",
				url: base_url + "table/readmessage/" + value,
				timeout: 30000,
				async: false,
				error: function(xhr) {
					console.log('Ошибка!' + xhr.status + ' ' + xhr.statusText);
				},
				success: function(a) {
					tr.removeClass();
				}
			});

		});
		$('table tr').mouseout(function() {
			 $(this).find('.close').attr('hidden', true);
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
    });
</script>

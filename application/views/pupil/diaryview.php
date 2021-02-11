<link href="<?php echo base_url()?>css/btn-sample.css" rel="stylesheet">
<?php
	function showDate($date) {
			$day = date('d', strtotime($date));
			$mounth = date('m', strtotime($date));
			$year = date('Y', strtotime($date));
			$data = array('01'=>'января','02'=>'февраля','03'=>'марта','04'=>'апреля','05'=>'мая','06'=>'июня',
			'07'=>'июля', '08'=>'августа','09'=>'сентября','10'=>'октября','11'=>'ноября','12'=>'декабря');
			foreach ($data as $key=>$value) {
				if ($key==$mounth) echo "<b>".ltrim($day, '0')." $value $year года</b>";
			}
		}
	function setColor($mark, $tooltip) {
			switch ($mark) {
				case 5: echo '<span data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="label label-success">'.$mark.'</span>'; break;
				case 4: echo '<span data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="label label-warning">'.$mark.'</span>'; break;
				case 3: echo '<span data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="label label-primary">'.$mark.'</span>';  break;
				case 2: echo '<span data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="label label-danger">'.$mark.'</span>'; break;
			}
	}
?>
<div class="container">
	<div class="well well-sm"><span>
		<i class="fa fa-bookmark"></i>
		</span> Учебная неделя с <?php echo showDate($monday);?> по <?php echo showDate(date('Y-m-d', strtotime($monday . ' + 6 day')));?>
		</span>
	</div>

	<ul class="pager" id="diary-navigation">
		<li class="previous" title="Назад на одну неделю">
			<a href="<?php echo base_url();?>pupil/diary/<?php echo date('Y-m-d', strtotime($monday . ' - 7 day')); ?>"><i class="fa fa-chevron-left"></i> Назад</a>
		</li>
		<li title="Показать текущую неделю">
					<a href="<?php echo base_url();?>pupil/diary/<?php echo date('Y-m-d', strtotime(date('Y-m-d'). " - " . (date('N', strtotime(date('Y-m-d'))) - 1) . " days"));  ?>">Текущая неделя</a>
		</li>
		<li class="next"  title="Вперед на одну неделю">
			<a href="<?php echo base_url();?>pupil/diary/<?php echo date('Y-m-d', strtotime($monday . ' + 7 day'));?>">Вперед <i class="fa fa-chevron-right"></i></a>
		</li>
	</ul>

	<?php
		if (isset($error)) : ?>
			<div class="alert alert-info" role="alert"><?php echo $error;?></div>
	<?php else : ?>
	<?php
		$date = $monday;
		if(is_array($diary)) :
		for($i = 1; $i <= count($diary); $i++) :
	?>
	
	<h4 class="sidebar-header">
	<?php
		echo $days[$i-1]. " ";
		echo showDate($date);
		$date = date('Y-m-d', strtotime($date . ' + 1 day'));
	?>
	</h4>
	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<th style="width: 20%;">Предмет</th>
						<th style="width: 25%;">Оценки</th>
						<th style="width: 15%;">Домашнее задание</th>
						<th style="width: 25%;">Замечания</th>
						<th style="width: 15%;">Статус урока</th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach ($diary[$i] as $diaryForDay) :
						switch ($diaryForDay["pass"]) {
							case 'н':?><tr class="warning"><?php break;
							case 'б':?><tr class="success"><?php break;
							case 'у':?><tr class="info"><?php break;
							default:?><tr><?php break;
						}
			  	?>
						<td><?php echo $diaryForDay["subject"]; ?></td>
						<td>
						<?php
							if(isset($diaryForDay["marks"])) {
								foreach($diaryForDay["marks"] as $marks) {
									setColor($marks["mark"], $marks["type"]);
									echo " ";
								}
							}
						?>
						</td>
						<td>
						<?php if (isset($diaryForDay["homework"]) && ($diaryForDay['homework'] != "" /*|| count($diaryForDay['files']) > 0*/)) : ?>
							<button class="btn btn-sample btn-xs" title="Показать домашнее задание" type="button" data-toggle="modal" data-target="#myModal<?php echo $diaryForDay["lesson_id"];?>"><i class="fa fa-home"></i> Домашнее задание
							</button>
							<div class="modal fade" id="myModal<?php echo $diaryForDay["lesson_id"];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Домашнее задание по предмету <strong><?php echo $diaryForDay["subject"]; ?></strong></h4>
										</div>
										<div class="modal-body">
											<?php echo $diaryForDay['homework']; ?>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						</td>
						<td>
							<?php echo $diaryForDay["note"]; ?>	
						</td>
						<td>
						<?php
							if (isset($diaryForDay["lesson_status"]) && $diaryForDay["lesson_status"] == 1) 
								echo "Проведен"; 
						?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php 
			endfor;
		endif;
	endif;
?>

	<ul class="pager" id="diary-navigation">
		<li class="previous" title="Назад на одну неделю">
			<a href="<?php echo base_url();?>pupil/diary/<?php echo date('Y-m-d', strtotime($monday . ' - 7 day')); ?>"><i class="fa fa-chevron-left"></i> Назад</a>
		</li>
		<li title="Показать текущую неделю">
					<a href="<?php echo base_url();?>pupil/diary/<?php echo date('Y-m-d', strtotime(date('Y-m-d'). " - " . (date('N', strtotime(date('Y-m-d'))) - 1) . " days"));  ?>">Текущая неделя</a>
		</li>
		<li class="next"  title="Вперед на одну неделю">
			<a href="<?php echo base_url();?>pupil/diary/<?php echo date('Y-m-d', strtotime($monday . ' + 7 day'));?>">Вперед <i class="fa fa-chevron-right"></i></a>
		</li>
	</ul>

	<table class="brand-table">
		<tr>
			<td><div class="color-swatch brand-success"></div></td>
			<td>Пропуск по болезни</td>
		</tr>
		<tr>
			<td><div class="color-swatch brand-info"></div></td>
			<td>Пропуск по уважительной причине</td>
		</tr>
		<tr>
			<td><div class="color-swatch brand-warning"></div></td>
			<td>Пропуск по неуважительной причине</td>
		</tr>
	</table>
</div>
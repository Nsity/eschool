<link href="<?php echo base_url()?>css/btn-sample.css" rel="stylesheet">
<?php
		/*	$string_date = '08-03-2015';
			$day_of_week = date('N', strtotime($string_date));
			$week_first_day = date('Y-m-d', strtotime($string_date . " - " . ($day_of_week - 1) . " days"));
			//$week_last_day = date('d-m-Y', strtotime($string_date . " + " . (7 - $day_of_week) . " days"));
			$nextMonday = date('Y-m-d',strtotime("next Monday"));*/
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
				case 5: echo '<span data-toggle="tooltip" data-placement="left" title="'.$tooltip.'"  class="green">'.$mark.'</span>'; break;
				case 4: echo '<span data-toggle="tooltip" data-placement="left" title="'.$tooltip.'" class="yellow">'.$mark.'</span>'; break;
				case 3: echo '<span data-toggle="tooltip" data-placement="left" title="'.$tooltip.'" class="blue">'.$mark.'</span>';  break;
				case 2: echo '<span data-toggle="tooltip" data-placement="left" title="'.$tooltip.'" class="red">'.$mark.'</span>'; break;
			}
	}
?>
<div class="container">
	<div class="well well-sm" style="background: #563d7c;"><span style="color: white;">
		<span class="glyphicon glyphicon-bookmark" aria-hidden="true">
		</span> Учебная неделя с <?php echo showDate($monday);?> по <?php echo showDate(date('Y-m-d', strtotime($monday . ' + 6 day')));?>
		</span>
	</div>

	<ul class="pager" id="diary-navigation">
		<li class="previous" data-toggle="tooltip" data-placement="left" title="Назад на одну неделю">
		    <a href="<?php echo base_url();?>pupil/diary?monday=<?php echo date('Y-m-d', strtotime($monday . ' - 7 day')); ?>">&larr; Назад</a>
		</li>
		<li data-toggle="tooltip" data-placement="left" title="Показать текущую неделю">
		    <a href="<?php echo base_url();?>pupil/diary?monday=<?php echo date('Y-m-d', strtotime(date('Y-m-d'). " - " . (date('N', strtotime(date('Y-m-d'))) - 1) . " days"));  ?>">Текущая неделя</a>
		</li>
		<li class="next"  data-toggle="tooltip" data-placement="left" title="Вперед на одну неделю">
		    <a href="<?php echo base_url();?>pupil/diary?monday=<?php echo date('Y-m-d', strtotime($monday . ' + 7 day'));?>">Вперед &rarr;</a>
		</li>
	</ul>

	<?php

		if (isset($error)) {
			?>
			<div class="alert alert-info" role="alert"><?php echo $error;?></div>
			<?
		} else {
	?>

    <div class="row" id="diary">
	    <div class="col-md-6">
		    <?php
			    $date = $monday;
			    for($i = 1; $i <= count($diary); $i++) {
			    ?>
		        <div class="panel panel-default"><div class="panel-heading">
			        <?php
				        echo $days[$i-1]. " ";
				        echo showDate($date);
				        $date = date('Y-m-d', strtotime($date . ' + 1 day'));
			        ?>
			        </div> <div class="table-responsive">
				        <table name="diarytable" class="table table-striped table-hover ">
					        <thead>
							<tr>
								<th>Предмет</th>
								<th>Оценки</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								for($y = 1; $y <= count($diary[$i]); $y++) {
									//echo $diary[$i][$y]["start"] <= date("Y-m-d");
									if ($diary[$i][$y]["pass"] == 1) {
										?>
										<tr class="warning">
											<?php
										} else {
											?>
											<tr>
										<?php }
							?>
							<td class="col-xs-4 col-md-4" style="vertical-align:middle"><?php echo $diary[$i][$y]["subject"]; ?></td>
							<td class="mark col-xs-4 col-md-5" style="vertical-align:middle">
								<?php

									if(isset($diary[$i][$y]["marks"])) {
										for($z = 1; $z <= count($diary[$i][$y]["marks"]); $z++) {
											setColor($diary[$i][$y]["marks"][$z]["mark"], $diary[$i][$y]["marks"][$z]["type"]);
											echo " ";
										}
									}
							    ?>
							</td>
						    <td  class="col-xs-4 col-md-3"><a href="<?php echo base_url();?>pupil/lesson?id=<?php echo $diary[$i][$y]["lesson_id"]; ?>" role="button" class="btn btn-sample btn-sm btn-block <?php
							    if (!isset($diary[$i][$y]["lesson_id"])) { echo "disabled";}
							    ?>" data-toggle="tooltip" data-placement="left" title="Посмотреть учебное занятие">Подробнее</a></td></tr>
						    <?php
							    }
							    for($y = count($diary[$i]); $y < 6; $y++) {
								    ?>
								    <tr style="height: 47px;"><td></td><td></td><td></td></tr>
								    <?php
									    }?>
							    </tbody>
						</table>
					</div>
				</div>
							<?php
								if ($i == 3) {
									echo '</div><div class="col-md-6">';
								}
								if ($i == 6) {
									echo '</div>';
								}
							}
						    ?>
		</div>
	</div>
	<?php }?>
</div>

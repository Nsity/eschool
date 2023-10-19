<?php $this->load->view('menu/teachermenu'); ?>  
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Класс <span class="caret"></span></a>
	<ul class="dropdown-menu" role="menu">
		<li><a href="<?php echo base_url();?>teacher/pupils"><i class="fa fa-user"></i> Учащиеся</a></li>
		<li><a href="<?php echo base_url();?>teacher/subjects"><i class="fa fa-book"></i> Предметы</a></li>
		<li><a href="<?php echo base_url();?>teacher/timetable/1"><i class="fa fa-clock-o"></i> Расписание</a></li>
		<li><a href="<?php echo base_url();?>teacher/classreport"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Итоговый отчет</a></li>
	</ul>
</li>
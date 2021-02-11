<!DOCTYPE html>
<html lang = "ru">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="Сайт электронного дневника учащегося">
	<meta name="keywords" content="diary, school, pupil, дневник, школа, информационная система">
	<meta name="author" content="Федорова А.П.">
	<title> <?
	if(isset($title)) echo $title." | Электронный дневник учащегося";
	else echo "Электронный дневник учащегося";
	?></title>
	<link rel="shortcut icon" href="<?php echo base_url();?>images/school-new2.png">
	<!--Bootstrap-->
	
	<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
	<script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/Chart.min.js" type="text/javascript"></script>

	<script src="<?php echo base_url();?>js/tooltip.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/passEye.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/charRemaining.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/jquery.maskedinput.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/bootstrap-datepicker.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/bootstrap-datepicker.ru.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
	<!--<script src="<?php echo base_url();?>js/ru.js" type="text/javascript"></script>-->
	<script src="<?php echo base_url();?>js/mindmup-editabletable.js" type="text/javascript"></script>
	<!--<script src="<?php echo base_url();?>js/bootstrap-editable.min.js" type="text/javascript"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-switch.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-contextmenu.js"></script>
	<!--<script type="text/javascript" src="<?php echo base_url();?>js/legend.js"></script>-->




	<link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
	<link href="<?php echo base_url();?>css/navbar.css" rel="stylesheet">
	<!--<link href="<?php echo base_url();?>css/btn-menu.css" rel="stylesheet">-->
	<link href="<?php echo base_url();?>css/main-style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/bootstrap-datepicker3.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/select2.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/select2-bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/bootstrap-switch.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/font-awesome.min.css" rel="stylesheet">

	 <!--<link href="<?php echo base_url();?>css/bootstrap-editable.css" rel="stylesheet">-->
	<style media='print' type='text/css'>
		body {
			padding: 10px;
		}
	</style>

  </head>
  <body>
<!--Header-->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Навигация</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url();?>">
					<img alt="Иконка" src="<?php echo base_url();?>images/schoollogo.png" width="40" height="40">
					</a>
		   <?php
			  /* if ($role != 4) echo '<a class="navbar-brand pull-left" href="teacher"><img src="'.base_url().'images/schoollogo.png" width="35" height="35">Электронный журнал</a>
';
else echo '<a class="navbar-brand pull-left" href="../pupil/news"><img src="'.base_url().'images/schoollogo.png" width="35" height="35">Электронный дневник</a>';*/
		   ?>


					</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  <ul class="nav navbar-nav">


<?php
	if ($role == 4) {
?>
	<li><a href="<?php echo base_url();?>pupil/news">Новости</a></li>
	<li><a href="<?php echo base_url();?>pupil/timetable">Расписание</a></li>
	<!--<li><a href="<?php echo base_url();?>pupil/diary">Дневник</a></li>-->
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Дневник <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo base_url();?>pupil/diary"><i class="fa fa-graduation-cap"></i> Традиционный</a></li>
			<li><a href="<?php echo base_url();?>pupil/marks"><i class="fa fa-book"></i> Оценки</a></li>
		</ul>
	</li>
	<li><a href="<?php echo base_url();?>pupil/progress">Итоговые оценки</a></li>
	<li><a href="<?php echo base_url();?>pupil/statistics">Статистика</a></li>
	<li><a href="<?php echo base_url();?>messages/conversations">Общение</a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $mainlogin;?> <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo base_url();?>files/guide.pdf"><i class="fa fa-question-circle"></i> Помощь</a></li>
			<li><a href="<?php echo base_url();?>auth/logout"><i class="fa fa-sign-out fa-fw"></i> Выйти</a></li>
		</ul>
		</li>

	  </ul>
	   <?php }?>

	   <?php

		   if ($role == 2) { ?>



			   <li class="dropdown">
			   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Списки <span class="caret"></span></a>
			   <ul class="dropdown-menu" role="menu">
				   <li><a href="<?php echo base_url();?>admin/teachers"><i class="fa fa-user"></i> Учителя</a></li>
				   <li><a href="<?php echo base_url();?>admin/classes"><i class="fa fa-users"></i> Классы</a></li>
				   <li><a href="<?php echo base_url();?>admin/subjects"><i class="fa fa-book"></i> Общие предметы</a></li>
				   <li><a href="<?php echo base_url();?>admin/rooms"><i class="fa fa-building"></i> Кабинеты</a></li>
				   <li><a href="<?php echo base_url();?>admin/types"><i class="fa fa-paperclip"></i> Типы оценок</a></li>
				   <li><a href="<?php echo base_url();?>admin/years"><i class="fa fa-calendar"></i> Учебные годы</a></li>
			   </ul>
			   </li>

				<li><a href="<?php echo base_url();?>admin/news">Новости</a></li>
				<li><a href="<?php echo base_url();?>admin/statistics">Анализ</a></li>

			</ul>
		 <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $mainlogin;?> <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo base_url();?>files/guide.pdf"><i class="fa fa-question-circle"></i> Помощь</a></li>
			<li><a href="<?php echo base_url();?>auth/logout"><i class="fa fa-sign-out fa-fw"></i> Выйти</a></li>
		</ul>
		</li>

	  </ul>


		<?php
			}
			if ($role == 3) { ?>
			 <li><a href="<?php echo base_url();?>teacher/journal">Журнал</a></li>
			 <li><a href="<?php echo base_url();?>teacher/progress">Итоговые оценки</a></li>
			 <li><a href="<?php echo base_url();?>messages/conversations">Общение</a></li>
			 <li><a href="<?php echo base_url();?>teacher/statistics">Анализ</a></li>
				<li><a href="<?php echo base_url();?>teacher/news">Новости</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $mainlogin;?> <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo base_url();?>files/guide.pdf"><i class="fa fa-question-circle"></i> Помощь</a></li>
			<li><a href="<?php echo base_url();?>auth/logout"><i class="fa fa-sign-out fa-fw"></i> Выйти</a></li>
		</ul>
		</li>

	  </ul>		        <?php
					}


					if ($role == 1) { ?>

					  <li><a href="<?php echo base_url();?>teacher/journal">Журнал</a></li>
					  <li><a href="<?php echo base_url();?>teacher/progress">Итоговые оценки</a></li>
					   <li><a href="<?php echo base_url();?>messages/conversations">Общение</a></li>
						<li><a href="<?php echo base_url();?>teacher/statistics">Анализ</a></li>
						   <li><a href="<?php echo base_url();?>teacher/news">Новости</a></li>
					  <li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Класс <span class="caret"></span></a>
					  <ul class="dropdown-menu" role="menu">
						  <li><a href="<?php echo base_url();?>teacher/pupils"><i class="fa fa-user"></i> Учащиеся</a></li>
				   <li><a href="<?php echo base_url();?>teacher/subjects"><i class="fa fa-book"></i> Предметы</a></li>
				   <li><a href="<?php echo base_url();?>teacher/timetable/1"><i class="fa fa-clock-o"></i> Расписание</a></li>
				   <li><a href="<?php echo base_url();?>teacher/classreport"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Итоговый отчет</a></li>

			   </ul>
			   </li>

				</ul>
				<ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $mainlogin;?> <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo base_url();?>files/guide.pdf"><i class="fa fa-question-circle"></i> Помощь</a></li>
			<li><a href="<?php echo base_url();?>auth/logout"><i class="fa fa-sign-out fa-fw"></i> Выйти</a></li>
		</ul>
		</li>

	  </ul>		        <?php
					}


	   ?>


	  </div>
	  </div>
	</nav>
	<!--Header-->


<script>
/*$(document).ready(function () {
		//var url = window.location;
		var myParam = (window.location.search.split('page=')[1]||'').split('&')[0];
		var url = window.location.href.split('?')[0];
		url = url + '?page=' + myParam;
		//alert(myParam);
		$('ul.nav a[href="' + url + '"]').parent().addClass('active');

		$('ul.nav a').filter(function () {
			return this.href == url;
		}).parent().addClass('active').parent().parent().addClass('active');
	});*/


   $(document).ready(function() {
	   var splits = location.href.split('/');
	   var url = splits[0] +"/"+ splits[1]+"/"+splits[2]+"/"+splits[3]+"/"+splits[4]+"/"+splits[5].split('?')[0];
	 //  alert(url);
		$('ul.nav a[href="' + url + '"]').parent().addClass('active');

		$('ul.nav a').filter(function () {
			return this.href == url;
		}).parent().addClass('active').parent().parent().addClass('active');

	});
</script>

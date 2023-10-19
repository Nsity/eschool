<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="description" content="Сайт электронного дневника учащегося">
		<meta name="keywords" content="diary, school, pupil, дневник, школа, информационная система">
		<meta name="author" content="Федорова А.П.">
		<title> <?php echo isset($title) ? $title . " | Электронный дневник учащегося" : "Электронный дневник учащегося"; ?></title>
		<link rel="shortcut icon" href="<?php echo base_url();?>images/school-new2.png">
		<?php 
			$this->load->view('scripts'); 
			$this->load->view('styles');
		?>
	</head>
	<body>
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
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
				<?php 
					switch($role) {
						case Roleenum::Pupil: 
							$this->load->view('menu/pupilmenu'); 
							break;
						case Roleenum::Admin: 
							$this->load->view('menu/adminmenu'); 
							break;
						case Roleenum::Teacher: 
							$this->load->view('menu/teachermenu'); 
							break;
						case Roleenum::ClassTeacher:
							$this->load->view('menu/classteachermenu'); 
							break;
					}
				?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $mainlogin; ?> <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo base_url();?>files/guide.pdf"><i class="fa fa-question-circle"></i> Помощь</a></li>
								<li><a href="<?php echo base_url();?>auth/logout"><i class="fa fa-sign-out fa-fw"></i> Выйти</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>


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

<!DOCTYPE html>
<html lang = "ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/school-new2.png">
    <title>Электронный дневник учащегося</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <link href="css/singin.css" rel="stylesheet">
  </head>
<body>
	<div class="bs-docs-header">
		<div class="container">
			<h1 style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;"><strong>Электронный дневник учащегося</strong></h1>
			<p>Электронный дневник учащегося — это уникальная разработка, создающая единое информационное пространство, которое объединяет всех участников образовательного процесса</p>
			<form class="form-signin" method="POST" action="auth">
				<input name="login" type="login" class="form-control" placeholder="Логин" required autofocus>
				<input name="password" type="password" class="form-control" placeholder="Пароль" required>
				<?php
					if (isset($error)) {?>
				<!--alert-->
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Ошибка!</strong> <?php echo $error;?>
				</div>
				<!--alert-->
				<?php }?>

				<button name="singin" class="btn btn-lg btn-block btn-sample" type="submit">Авторизоваться</button>
			</form>
		</div>
    </div>
</body>
</html>
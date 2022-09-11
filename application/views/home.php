<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>XML RPS</title>	
	
    <link rel="stylesheet" href="<?= base_url("css/bootstrap.min.css") ?>" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url("css/custom.css") ?>">

</head>
<body>

	<div class="jumbotron full-height">
	<div class="container text-center">
		<h1>Bem-vindo</h1>
		<p><?=$_SESSION['usuario_logado'][0]['fantasia']?></p>
	</div>
	</div>

	<script src="<?= base_url("js/jquery-3.3.1.slim.min.js") ?>" crossorigin="anonymous"></script>
	<script src="<?= base_url("js/popper.min.js") ?>" crossorigin="anonymous"></script>
	<script src="<?= base_url("js/bootstrap.min.js") ?>" crossorigin="anonymous"></script>
</body>
</html>

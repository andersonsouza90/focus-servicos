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

	<?php 
		if(isset($_SESSION['valida_file'])){ 
			print_r('<div class="alert alert-danger">');
			print_r($_SESSION['valida_file']);
			print_r('</div><br>');
		}
	?>
	
		<form action="<?= base_url("upload/arquivo") ?>" method="post" name="upload_excel" enctype="multipart/form-data">

			<input type="file" name="arquivo_field" size="20" class="form-group" />

			<button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit" id="submit" name="Import">
				Enviar
			</button>

			<h4 id="linkArquivo">
                                <a href="download" target="_blank">Arquivo de Exemplo</a></h4>

		</form>

	</div>

	<script src="<?= base_url("js/jquery-3.3.1.slim.min.js") ?>" crossorigin="anonymous"></script>
	<script src="<?= base_url("js/popper.min.js") ?>" crossorigin="anonymous"></script>
	<script src="<?= base_url("js/bootstrap.min.js") ?>" crossorigin="anonymous"></script>
</body>
</html>




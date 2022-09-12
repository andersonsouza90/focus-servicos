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

<div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">

          <div class="form-floating mb-3">
		  <img style="width: 130px" src="<?= base_url("images/LogoFocusConsultoriaHorizontal.jpg") ?>">
          </div>

            <h5 class="card-title text-center mb-5 fw-light fs-5">Novo Cadastro</h5>

            <?php echo validation_errors(); ?>

			<?php 
					if(isset($_SESSION['new_user_nok'])){ 
						print_r('<div class="alert alert-danger" style="display:inline-block;">');
						print_r($_SESSION['new_user_nok']);
						print_r('</div><br>');
					}
				?>

            <form method="post" action="<?php echo base_url() ?>cadastro/cadastrar">
              
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" >
                <label for="razaoSocial">Razão Social</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="fantasia" placeholder="Fantasia" >
                <label for="fantasia">Fantasia</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="cnpj" placeholder="CNPJ">
                <label for="cnpj">CNPJ</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="enderecoCompleto" placeholder="Endereço completo" >
                <label for="enderecoCompleto">Endereço completo</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="telefone" placeholder="Telefone" >
                <label for="telefone">Telefone</label>
              </div>
              <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
                <label for="email">Email</label>
              </div>

              <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" placeholder="Senha">
                <label for="password">Senha</label>
              </div>

              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" id="btnEntrar" type="submit">Cadastrar</button>
                <a href="<?php echo base_url() ?>" class="btn fw-bold">Cancelar</a>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

	<script src="<?= base_url("js/jquery-3.3.1.slim.min.js") ?>" crossorigin="anonymous"></script>
	<script src="<?= base_url("js/popper.min.js") ?>" crossorigin="anonymous"></script>
	<script src="<?= base_url("js/bootstrap.min.js") ?>" crossorigin="anonymous"></script>
</body>
</html>

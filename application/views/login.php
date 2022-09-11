<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>XML RPS</title>

        <!-- Fonts -->
        <link href="<?= base_url("css/fonts-gooleapis.css") ?>" rel="stylesheet">


        <link rel="stylesheet" href="<?= base_url("css/bootstrap.min.css") ?>" crossorigin="anonymous">

        <script src="<?= base_url("js/bootstrap.min.js") ?>" crossorigin="anonymous"></script>

        <script src="<?= base_url("js/jquery.min.js") ?>"></script>

        <script>

            $(function(){

                /*$("#btnEntrar").click(function(){
                    alert($("#cnpj").val());
                });*/



            });

        </script>

        <style>
                body {
                    background: #1a202c;
                }

                .btn-login {
                    font-size: 0.9rem;
                    letter-spacing: 0.05rem;
                    padding: 0.75rem 1rem;
                }
        </style>
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

            <h5 class="card-title text-center mb-5 fw-light fs-5">Login</h5>

            <?php
                //dd($cadastroRealizado);

            ?>

			<?php echo validation_errors(); ?>

			
				<?php 
					if(isset($_SESSION['login_invalido'])){ 
						print_r('<div class="alert alert-danger" style="display:inline-block;">');
						print_r($_SESSION['login_invalido']);
						print_r('</div><br>');
					}
				?>

				<?php 
					if(isset($_SESSION['new_user_ok'])){ 
						print_r('<div class="alert alert-success" style="display:inline-block;">');
						print_r('Seus dados foram gravados com sucesso! Entre com seu CNPJ e Senha. ');
						print_r('</div><br>');
					}
				?>


            <form method="post" action="<?php echo base_url() ?>login/validaLogin">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="cnpj" placeholder="CNPJ">
                <label for="cnpj">CNPJ</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" placeholder="Senha">
                <label for="password">Senha</label>
              </div>

              <div class="d-grid">

                <button class="btn btn-primary btn-login text-uppercase fw-bold" id="btnEntrar" type="submit">Entrar</button>
                <a href="<?php echo base_url() ?>cadastro" class="btn fw-bold">Novo Cadastro</a>

              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>



</html>

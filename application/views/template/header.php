<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">
  <img style="width: 130px" src="<?= base_url("images/LogoFocusConsultoriaHorizontal.jpg") ?>">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="home">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Meus Dados</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="upload">Upload</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contato</a>
      </li>
	  <li class="nav-item">
	  	<a class="nav-link" href="<?= base_url("login/logout") ?>"><span class="glyphicon glyphicon-log-out"></span> Sair</a>
		</li>
    </ul>
	
  </div>
</nav>

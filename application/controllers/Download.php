<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

	
	public function index()
	{

		if(!$this->session->userdata("usuario_logado")){
			redirect(base_url());
		}
		force_download('./arquivos/exemploNew.xlsx', NULL);
	}
}

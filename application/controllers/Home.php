<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{	
		if(!$this->session->userdata("usuario_logado")){
			redirect(base_url());
		}

		$this->load->view('template/header');
		$this->load->view('home');
	}
}

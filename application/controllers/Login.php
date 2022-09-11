<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('login');
	}

	public function validaLogin(){

		if(!$this->input->post()){
			print_r('aaa');die;
			//$this->load->view('login');
		}
			
		$configValidation = array(
			array(
				'field' => 'cnpj',
				'label' => 'CNPJ',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Informe o %s.',
				)
			),
			array(
				'field' => 'password',
				'label' => 'Senha',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Informe a %s.',
				)
			)
		);

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules($configValidation);
		
		//print_r($this->form_validation->run()); die;

		if ($this->form_validation->run() == FALSE){
			//echo validation_errors(); die;
			$this->load->view('login');
		}else{

			$this->load->model("LoginModel");

			$cnpj = $this->input->post("cnpj");
			$password = $this->input->post("password");
			
	
			$retorno = $this->LoginModel->validaLogin($cnpj, $password);
	
			//var_dump($retorno); die;
	
			if($retorno){
				$this->session->set_userdata(array("usuario_logado" => $retorno));   
				redirect(base_url().'home');        
	
			}else{
				$this->session->set_flashdata("login_invalido", "Usuário e/ou senha inválidos.");
				redirect(base_url());
			}  

		}
		
     	  

	}

	public function logout()
	{
		$this->session->unset_userdata("usuario_logado");
		redirect(base_url());
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends CI_Controller {

	
	public function index()
	{

		$this->load->view('cadastro/cadastro_form');
		
	}

	public function cadastrar(){

		if(!$this->input->post()){
			print_r('cadastr');die;
		}

		$configValidation = array(
			array(
				'field' => 'razaoSocial',
				'label' => 'Razao Social',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Informe o %s.',
				)
			),
			array(
				'field' => 'fantasia',
				'label' => 'Fantasia',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Informe o %s.',
				)
			),
			array(
				'field' => 'enderecoCompleto',
				'label' => 'Endereço Completo',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Informe o %s.',
				)
			),
			array(
				'field' => 'cnpj',
				'label' => 'CNPJ',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Informe o %s.',
				)
			),
			array(
				'field' => 'telefone',
				'label' => 'Telefone',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Informe o %s.',
				)
			),
			array(
				'field' => 'email',
				'label' => 'E-mail',
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

			$this->load->view('cadastro/cadastro_form');

		}else{

			$dadosUsuario = array(
	            "razao_social"=> $this->input->post("razaoSocial"),
	            "fantasia"      => $this->input->post("fantasia"),
	            "endereco"     => $this->input->post("enderecoCompleto"),	            
	            "cnpj"  => $this->input->post("cnpj"),
	            "telefone"     => $this->input->post("telefone"),
	            "email"     => $this->input->post("email"),
	            "password"     => $this->input->post("password"),
	            //"aceite"     => "1"
	        );    

			$this->load->model("FormularioModel");

			$validaCnpj = $this->FormularioModel->findUserByCnpj($this->input->post("cnpj"));

			if($validaCnpj > 0){
				$this->session->set_flashdata("new_user_nok", "O CNPJ (".$this->input->post("cnpj").") já está cadastrado!");	        
				$this->load->view('cadastro/cadastro_form');

			}else{

				$retornoUser = $this->FormularioModel->salvar($dadosUsuario);		
			
				if($retornoUser){
					$this->load->model("AdesaoModel");

					$dadosAdesao = array(
						"id_usuario"=> $retornoUser,
						"id_plano" => "1",
						"dt_termino" => date('Y/m/d', strtotime('+7 day', time())) //1 semana de teste 
					);
					$retornoAdesao = $this->AdesaoModel->salvar($dadosAdesao);

					if($retornoAdesao){

						//$dadosUsuario = $this->Formulario_model->getParticipante($retorno);
		
						$this->session->set_flashdata("new_user_ok", "Dados gravados.");
						
						redirect('/');
		
					}else{
						$this->session->set_flashdata("new_user_nok", "Erro ao gravar Adesão.");	        
						$this->load->view('cadastro/cadastro_form');
						
					}

				}else{

					$this->session->set_flashdata("new_user_nok", "Erro ao gravar Dados.");	        
					$this->load->view('cadastro/cadastro_form');
					
				}

			}
			

		}
	}

}

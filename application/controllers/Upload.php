<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function index()
	{
		if(!$this->session->userdata("usuario_logado")){
			redirect(base_url());
		}

		$this->load->view('template/header');
		$this->load->view('upload/upload_form');
	}

	public function arquivo(){

		if ($_FILES['arquivo_field']['size'] == 0){
			$this->session->set_flashdata("valida_file", "Informe um arquivo xls para upload.");
			redirect(base_url('upload'));
		}

		if(!$this->session->userdata("usuario_logado")){
			redirect(base_url());
		}

		if(!$this->input->post()){
			print_r('Upload');die;
			//$this->load->view('login');
		}

		
		$this->load->library('excel');

		//print_r(); die;

		$diretorio = "diretorio-".$this->session->userdata("usuario_logado")[0]["id_usuario"]."/arquivos";

		if (!is_dir('uploads/'.$diretorio)) {
			mkdir('./uploads/' . $diretorio, 0777, TRUE);			
		}

		$config['allowed_types'] = "*";
		$config['upload_path'] = "./uploads/".$diretorio;
		$config['encryp_name'] = true;

		$new_name = md5(uniqid(rand(), true));
		$config['file_name'] = $new_name;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('arquivo_field')) {
			//print_r($this->upload->data());
		} else {
			print_r($this->upload->display_errors());
		}

		//load the excel library
		$this->load->library('excel');

		$arquivo = $config['upload_path'].'/'.$config['file_name'].'.xlsx';
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($arquivo);
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		
			//The header will/should be in row 1 only. of course, this can be modified to suit your need.
			if ($row == 1) {
				$header[$row][$column] = $data_value;
			} else {
				$arr_data[$row][$column] = $data_value;
			}
		}
		
		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = $arr_data;

		print_r($arr_data);
	
		
		

	}
}

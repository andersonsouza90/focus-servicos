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

		$filename = $_FILES['arquivo_field']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$allowed = array('xls', 'xlsx');

		if ($_FILES['arquivo_field']['size'] == 0 || !in_array($ext, $allowed) ){
			$this->session->set_flashdata("valida_file", "Informe um arquivo excel para upload.");
			redirect(base_url('upload'));
		}

		if(!$this->session->userdata("usuario_logado")){
			redirect(base_url());
		}

		if(!$this->input->post()){
			print_r('Upload');die;
			//$this->load->view('login');
		}
		
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
			print_r($this->upload->display_errors()); die;
		}

		$arquivo = $config['upload_path'].'/'.$config['file_name'].'.'.$ext;

		$dadosArray = $this->ExcelToArray($arquivo);

		//print_r($dadosArray["values"]); die;

		$retornoValidaColunas = $this->validaColunas($dadosArray['header']);

		if($retornoValidaColunas["countErro"] > 0){
			$this->session->set_flashdata("valida_colunas", $retornoValidaColunas);
			redirect(base_url('upload'));
		}	
		
		//valida dados
		$returnValidaDados = $this->validarDados($dadosArray);

		if($returnValidaDados["countErro"] > 0){
			$this->session->set_flashdata("valida_dados", $returnValidaDados);
			redirect(base_url('upload'));
		}

		print_r("Agora Gerar o XML");
		
		

	}

	public function validarDados($assoc_array){

		//print_r($assoc_array["header"]); print_r("<br><br>");

        $l = 0;
		$linha_erro = 2;
        $m = [];
        $retorno = [];

        foreach ($assoc_array["values"] as $key => $dadoValidar) {

            //if($assoc_array[$key][array_search('PrestadorCNPJ', $assoc_array[0])] != "PrestadorCNPJ"){

                $PrestadorCNPJ = str_pad($dadoValidar[$this->getIndiceHeader($assoc_array["header"], "PrestadorCNPJ")] , 14 , '0' , STR_PAD_LEFT);
                if(!$this->validaCNPJ($PrestadorCNPJ)){
                    array_push($m, "CNPJ inválido ".$PrestadorCNPJ." {PrestadorCNPJ} linha ". ($linha_erro++) );
                    $l++;

                    // var_dump(array_search('PrestadorCNPJ', $assoc_array[0]));
                    // dd($dadoValidar);
                    // dd($dadoValidar[array_search('PrestadorCNPJ', $assoc_array[0])]);
                }

                $InscricaoMunicipal = $dadoValidar[$this->getIndiceHeader($assoc_array["header"], "InscricaoMunicipal")];

                if(!$this->dados($InscricaoMunicipal)){
                    array_push($m, "Dados inválido ".$InscricaoMunicipal." {InscricaoMunicipal} linha ".($linha_erro++) );
                    $l++;
                }

                $CpfCnpjTomador = str_pad($dadoValidar[$this->getIndiceHeader($assoc_array["header"], "CpfCnpjTomador")] , 11 , '0' , STR_PAD_LEFT);
                if(!$this->validaCPF($CpfCnpjTomador)){
                    array_push($m, "CPF inválido ".$CpfCnpjTomador." {CpfCnpjTomador} linha ".($linha_erro++) );
                    $l++;
                }

                $DataEmissao = $dadoValidar[$this->getIndiceHeader($assoc_array["header"], "DataEmissao")];
                //$DataEmissao = $this->converte_data($DataEmissao);

                if(!$this->valida_data($DataEmissao)){
                    array_push($m, "Data inválida ".$DataEmissao." {DataEmissao} linha ".($linha_erro++)." Padrão (Ano)-(Mẽs)-(Dia)");
                    $l++;
                }

                $ValorIss = $dadoValidar[$this->getIndiceHeader($assoc_array["header"], "ValorIss")];
                //$ValorIss = $this->dados($ValorIss);
                if(!$this->dados($ValorIss)){
                    array_push($m, "Dados inválido ".$ValorIss." {ValorIss} linha ".($linha_erro++)." Padrão 0.00");
                    $l++;
                }

                $Aliquota = $dadoValidar[$this->getIndiceHeader($assoc_array["header"], "Aliquota")];
                //$Aliquota = $this->dados($Aliquota);
                if(!$this->dados($Aliquota)){
                    array_push($m, "Dados inválido ".$Aliquota." {Aliquota} linha ".($linha_erro++)." Padrão 0.00");
                    $l++;
                }


                $Competencia = $dadoValidar[$this->getIndiceHeader($assoc_array["header"], "Competencia")];
                //$Competencia = $this->converte_data($Competencia);

                if(!$this->valida_data($Competencia)){
                    array_push($m, "Data inválida ".$Competencia." {Competencia} linha ".($linha_erro++)." Padrão (Ano)-(Mẽs)-(Dia)");
                    $l++;
                }

            //}

        }

        $retorno['msg'] = $m;
        $retorno['countErro'] = $l;

        return $retorno;

    }

	/////fim Valida Dados

	public function getIndiceHeader($cabecalho, $coluna){

		$key = 0;

		foreach ($cabecalho[1] as $key => $value) {

			// print_r($cabecalho[1]["U"] == $coluna );
			// die;
			
			if($value == $coluna){
				// print_r("<br>aquiiii<br>");
				// print_r($key); 
				// print_r("<br>");
				// print_r($value); die;
				return $key;
			}
			
		}

		return $key;
	}

	public function ExcelToArray($arquivo){
		//load the excel library
		$this->load->library('excel');		
		
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

		return $data;

	}

	public function validaColunas($assoc_array){

		$msg = [];
		$countErro = 0;
		$erro = array();

		if(count($assoc_array) > 0){

			foreach ($assoc_array as $key => $value) {
				$renomer = "Renomear conforme texto";

				if(!in_array("NumeroRPS", $value)){
					//$msg .= "Não existe a coluna {NumeroRPS} - ". $renomer ." 'NumeroRPS';</li>";
					array_push($msg, "Não existe a coluna {NumeroRPS} - ". $renomer ." 'NumeroRPS';");
                    $countErro++;
				}

				if(!in_array("DataEmissao", $value)){
					//$msg .= "Não existe a coluna {DataEmissao} - ". $renomer ." 'DataEmissao';";
                    array_push($msg, "Não existe a coluna {DataEmissao} - ". $renomer ." 'DataEmissao';");
					$countErro++;
				}

				if(!in_array("Competencia", $value)){
					array_push($msg, "Não existe a coluna {Competencia} - ". $renomer ." 'Competencia';");
					$countErro++;
				}

				if(!in_array("ValorServicos", $value)){
					array_push($msg, "Não existe a coluna {ValorServicos} - ". $renomer ." 'ValorServicos';");
					$countErro++;
				}

				if(!in_array("ValorIss", $value)){
					array_push($msg, "Não existe a coluna {ValorIss} - ". $renomer ." 'ValorIss';");
					$countErro++;
				}

				if(!in_array("Aliquota", $value)){
					array_push($msg, "Não existe a coluna {Aliquota} - ". $renomer ." 'Aliquota';");
					$countErro++;
				}

				if(!in_array("RazaoSocialTomador", $value)){
					array_push($msg, "Não existe a coluna {RazaoSocialTomador} - ". $renomer ." 'RazaoSocialTomador';");
					$countErro++;
				}

				if(!in_array("CpfCnpjTomador", $value)){
					array_push($msg, "Não existe a coluna {CpfCnpjTomador} - ". $renomer ." 'CpfCnpjTomador';");
					$countErro++;
				}

				//if(!array_key_exists("Discriminacao", $value)){
				//	$msg .= "<h5>Não existe a coluna [08]{Discriminacao} - ". $renomer ." 'Discriminacao';</h5>";
				//	$countErro++;
				//}

	            $erro['msg']=$msg;
	            $erro['countErro']=$countErro;   

	            return $erro;
			}

	    }

	    $erro['msg']=$msg;
	    $erro['countErro']=$countErro;

	    return $erro;

	}

	function validaCNPJ($cnpj){
		
		$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
		
		// Valida tamanho
		if (strlen($cnpj) != 14)
			return false;

		// Verifica se todos os digitos são iguais
		if (preg_match('/(\d)\1{13}/', $cnpj))
			return false;	

		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}

		$resto = $soma % 11;

		if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
			return false;

		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
		{
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}

		$resto = $soma % 11;

		return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
		
	}

	function dados($dado){
		$r = false;
		if($dado==''){
		   $r = false;
		}else{
		   $r = true;
		}
		return $r;
	}

	function validaCPF($cpf) {

	    // Extrai somente os números
	    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

	    // Verifica se foi informado todos os digitos corretamente
	    if (strlen($cpf) != 11) {
	        return false;
	    }
	    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
	    if (preg_match('/(\d)\1{10}/', $cpf)) {
	        return false;
	    }
	    // Faz o calculo para validar o CPF
	    for ($t = 9; $t < 11; $t++) {
	        for ($d = 0, $c = 0; $c < $t; $c++) {
	            $d += $cpf[$c] * (($t + 1) - $c);
	        }
	        $d = ((10 * $d) % 11) % 10;
	        if ($cpf[$c] != $d) {
	            return false;
	        }
	    }
	    return true;
	}

	function valida_data($data){
		if( strstr($data,"-")){
		  $data = explode('-', $data);
		}else{
		  $data = explode('/', $data);
		}

		$data0 = (int) $data[0];
		$data1 = (int) $data[1];
		$data2 = (int) $data[2];

		if(!checkdate($data1, $data0, $data2) and !checkdate($data1, $data2, $data0)) {
		  return false;
		}

		//if(!checkdate($data[1], $data[0], $data[2]) and !checkdate($data[1], $data[2], $data[0])) {
		  //return false;
		//}

		return true;
	}

	function converte_data($data){
	  if(valida_data($data)) {
	    return implode(!strstr($data, '/') ? "/" : "-", array_reverse(explode(!strstr($data, '/') ? "-" : "/", $data)));
	  }
	}



}

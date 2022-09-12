<?php

class FormularioModel extends CI_Model{

    function salvar($dados){

				$this->db->trans_start();
				$this->db->insert("users", $dados);
				$last_id = $this->db->insert_id();

				if ($this->db->trans_status() === false) {
						$this->db->trans_rollback();
				} else {
						$this->db->trans_commit();
				}
				
				return $last_id;
		}

		function findUserByCnpj($cnpj){
			$query = '
							select * from users
							where cnpj = "'.$cnpj.'"';
			return $this->db->query($query)->num_rows();
		}

}

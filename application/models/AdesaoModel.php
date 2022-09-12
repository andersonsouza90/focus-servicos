<?php

class AdesaoModel extends CI_Model{

    function salvar($dados){

		$this->db->trans_start();
		$this->db->insert("adesao", $dados);
		$last_id = $this->db->insert_id();

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
		} else {
				$this->db->trans_commit();
		}
				
		return $last_id;
	}

}

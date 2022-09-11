<?php

class FormularioModel extends CI_Model{

    function salvar($dados){
		$this->db->insert("users", $dados);
        $last_id = $this->db->insert_id();
        return $last_id;
	}

}

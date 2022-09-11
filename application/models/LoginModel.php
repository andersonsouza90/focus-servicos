<?php

class LoginModel extends CI_Model{

    public function validaLogin($cnpj, $password){        
        $query = "
            select 
                *
            from users
            where cnpj = '".$this->db->escape_str($cnpj)."' and password = '" .$this->db->escape_str($password)."' limit 1"; 

        //$retorno = array();
        //print_r($query);
        //var_dump($this->db->query($query));die;
        $retorno = $this->db->query($query)->result_array();        
        return $retorno;
    }

}

<?php

  class Usuario {

    private $id_usuario;
    private $email_usuario;
    private $senha_usuario;
    private $nome_usuario;
    private $fk_id_tipousuario;

    public function __set($attr, $value){
      return $this->$attr = $value;
    }

    public function __get($attr){
      return $this->$attr;
    }
  }

?>
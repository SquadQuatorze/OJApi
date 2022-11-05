<?php

  class UsuarioService {

    private $conexao;
    private $usuario;

    public function __construct($conexao, $usuario){
      $this->conexao = $conexao->conectar();
      $this->usuario = $usuario;
    }

    public function cadastrar(){

      $query = "insert into tb_usuarios 
              (nome_usuario, email_usuario, senha_usuario) values 
              (:nome_usuario, :email_usuario, :senha_usuario)";
      $stmt = $this->conexao->prepare($query);
      $stmt->bindValue('nome_usuario', $this->usuario->__get('nome_usuario'));
      $stmt->bindValue('email_usuario', $this->usuario->__get('email_usuario'));
      $stmt->bindValue('senha_usuario', $this->usuario->__get('senha_usuario'));
      $stmt->execute();

      return "Cadastro realizado com sucesso";

    }

    public function buscar(){

      $query = "select * from tb_usuarios";
      $stmt = $this->conexao->prepare($query);
      $stmt->execute();
      $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $usuarios;
    }


  }
?>
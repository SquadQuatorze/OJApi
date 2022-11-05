<?php

class Conexao {

  private $host = 'localhost';
  private $dbname = 'db_orange';
  private $user = 'geraldo';
  private $password = '140912';

  public function conectar(){

    try{

      $conexao = new PDO(
        "mysql:host=$this->host;dbname=$this->dbname",
        "$this->user",
        "$this->password"
      );

      return $conexao;

    }catch(PDOException $e){
      echo '<p>'.$e->getMessage().'</p>';
    }
  }
}


?>
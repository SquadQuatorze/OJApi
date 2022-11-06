<?php

  use \Psr\Http\Message\ServerRequestInterface as Request;
  use \Psr\Http\Message\ResponseInterface as Response;

  require '../OJ/vendor/autoload.php';

  // configurações do projeto
  $config['displayErrorDetails'] = true;

  // Instância do objeto API
  $app = new \Slim\App(['settings' => $config]);

  // injeção de dependências necessárias para o projeto
  $container = $app->getContainer();

  $container['conexao'] = function(){
    require '../private/Conexao.php';
    return new Conexao();
  };

  $container['usuario'] = function(){
    require '../private/usuarios/usuarios.model.php';
    return new Usuario();
  };

  $container['usuarioService'] = function($c){
    require '../private/usuarios/usuarios.service.php';
    return new UsuarioService($c['conexao'], $c['usuario']);
  };

  $app->post('/usuarios', function(Request $request, Response $response){
    
    $conexao = $this->get('conexao');
    $usuario = $this->get('usuario');

    $post = $request->getParsedBody();
    $usuario->__set('email_usuario', $post['email_usuario']);
    $usuario->__set('senha_usuario', $post['senha_usuario']);
    $usuario->__set('nome_usuario', $post['nome_usuario']);
    
    $usuarioService = $this->get('usuarioService');
    
    $usuarios = $usuarioService->buscarPorEmail();

    if(count($usuarios) == 0){
      $response->getBody()->write($usuarioService->cadastrar());
    } else {
      $response->getBody()->write('Email já cadastrado');
    }

    return $response;
    
  });

  $app->get('/usuarios', function(Request $request, Response $response){

    $conexao = $this->get('conexao');
    $usuario = $this->get('usuario');

    $post = $request->getParsedBody();
    $email = $post['email'];

    $usuarioService = $this->get('usuarioService');
    
    if($email != ''){
      $usuario->__set('email_usuario', $email);
      $usuarios = $usuarioService->buscarPorEmail();
    } else {
      $usuarios = $usuarioService->buscarUsuarios();
    }

    return $response->withJson($usuarios);
    
  });

  $app->run();


?>
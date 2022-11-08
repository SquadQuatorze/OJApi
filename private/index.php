<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Tuupola\Middleware\CorsMiddleware as CorsMiddleware;

require '../OJ/vendor/autoload.php';

// configurações do projeto
$config['displayErrorDetails'] = true;

// Instância do objeto API
$app = new \Slim\App(['settings' => $config]);

// injeção de dependências necessárias para o projeto
$container = $app->getContainer();

$container['conexao'] = function () {
  require '../private/Conexao.php';
  return new Conexao();
};

$container['usuario'] = function () {
  require '../private/usuarios/usuarios.model.php';
  return new Usuario();
};

$container['usuarioService'] = function ($c) {
  require '../private/usuarios/usuarios.service.php';
  return new UsuarioService($c['conexao'], $c['usuario']);
};

$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

$app->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->post('/usuarios', function (Request $request, Response $response) {

  $conexao = $this->get('conexao');
  $usuario = $this->get('usuario');

  $post = $request->getParsedBody();
  $usuario->__set('email_usuario', $post['email']);
  $usuario->__set('senha_usuario', $post['password']);
  $usuario->__set('nome_usuario', $post['nome']);

  $usuarioService = $this->get('usuarioService');

  $usuarios = $usuarioService->buscarPorEmail();

  if (count($usuarios) == 0) {
    $response->getBody()->write($usuarioService->cadastrar());
  } else {
    $response->getBody()->write('Email já cadastrado');
  }

  return $response;
});

$app->get('/usuarios', function (Request $request, Response $response) {

  $conexao = $this->get('conexao');
  $usuario = $this->get('usuario');

  $post = $request->getParsedBody();
  $email = $post['email'];

  $usuarioService = $this->get('usuarioService');

  if ($email != '') {
    $usuario->__set('email_usuario', $email);
    $usuarios = $usuarioService->buscarPorEmail();
  } else {
    $usuarios = $usuarioService->buscarUsuarios();
  }

  $response->getBody()->write(json_encode($usuarios));
  return $response->withHeader('Access-Control-Allow-Origin', '*')
    ->withAddedHeader('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE')
    ->withAddedHeader('Access-Control-Allow-Headers', '*')
    ->withAddedHeader('Access-Control-Max-Age', '86400')
    ->withAddedHeader('Content-Type', 'application/json');
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($req, $res) {
  $handler = $this->notFoundHandler;
  return $handler($req, $res);
});


$app->run();

<?php
require 'vendor/autoload.php';
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$response = new Zend\Diactoros\Response;
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    	);
$emitter = new Zend\Diactoros\Response\SapiEmitter;

$route = new League\Route\RouteCollection();

$route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write('<h1>Hello, World!</h1>');

    return $response;
});

$response = $route->dispatch($request, $response);

//exit; 
/*
cannot see xdebug error messages if the emitter::emit method runs
because it sends a content length header of only 21 characters
... which maybe causes the browser to only show that much in source
... or maybe it's something else happening internally in the emitter??
*/

$emitter->emit($response);


<?php
require 'vendor/autoload.php';

session_start();

require 'AcmeController.php';

/**
* See documentation of ServerRequest at:
* https://github.com/php-fig/http-message/blob/master/src/ServerRequestInterface.php
*/
$request = Zend\Diactoros\ServerRequestFactory
           ::fromGlobals( $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$response = new Zend\Diactoros\Response;
$route = new League\Route\RouteCollection();

require 'routes.php';

$emitter = new Zend\Diactoros\Response\SapiEmitter;
$emitter->emit($response);
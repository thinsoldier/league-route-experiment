<?php
require 'vendor/autoload.php';
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

//-----------------------------
class AcmeController
{
	function processRequest( $request, $response, $args )
	{
		ob_start();
		
		echo __method__;
		echo __file__;
		//var_dump($request->getRequestTarget());
		//var_dump( get_class_methods($request) );
		var_dump($args);
		
		if( !isset($args['cmd'] )){ echo '<b>orders index</b>'; }
		
		$response->getBody()->write( ob_get_clean() );
		
		// Route callables must return an instance of (Psr\Http\Message\ResponseInterface)
		return $response;
	} 
}
//-----------------------------

$response = new Zend\Diactoros\Response;

/**
* See documentation of ServerRequest at:
* https://github.com/php-fig/http-message/blob/master/src/ServerRequestInterface.php
*/
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    	);

$emitter = new Zend\Diactoros\Response\SapiEmitter;

$route = new League\Route\RouteCollection();

$route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write('<h1>Hello, World!</h1>');

    return $response;
});

$route->group('/orders', function ($route) {
	$route->map('GET' , '/', 'AcmeController::processRequest');
	$route->map('GET' , '/{cmd:new}', 'AcmeController::processRequest');
	$route->map('POST', '/{cmd:create}', 'AcmeController::processRequest');
	$route->map('GET' , '/{cmd:edit}/{id:number}', 'AcmeController::processRequest');
	$route->map('POST', '/{cmd:update}/{id:number}', 'AcmeController::processRequest');
	$route->map('GET' , '/{cmd:archives}', 'AcmeController::processRequest');
	$route->map('GET' , '/{cmd:archives}/{page:number}', 'AcmeController::processRequest');
});

try {
	$response = $route->dispatch($request, $response);
}
catch(League\Route\Http\Exception\NotFoundException $exception)
{
	// Show 404 page with proper 404 http status header.
	//https://github.com/zendframework/zend-diactoros/blob/master/doc/book/custom-responses.md#html-responses
	$htmlContent = '<h1>404 - Page Not Found!</h1>'; // Replace with actual template.
	$response = new Zend\Diactoros\Response\HtmlResponse($htmlContent, 404);
}


//exit; 
/*
Cannot see xdebug error messages if the emitter::emit method runs
Disable the next line (or exit before it) and look for error messages
if something isn't working.
*/

$emitter->emit($response);

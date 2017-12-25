<?php
class AcmeController extends SimpleController
{
	function respondToRoute( $request, $response, $args )
	{
		$this->processRequest( $args );

		ob_start();
		
		$this->run();
		
		$response->getBody()->write( ob_get_clean() );
		
		// Route callables must return an instance of (Psr\Http\Message\ResponseInterface)
		return $response;
	}
	
	function nav()
	{
		return '
		<a href="/">home</a>
		<a href="/orders">orders</a>
		<a href="/orders/new">new order</a>
		<a href="/orders/edit/4321">edit order</a>
		<a href="/logout">logout</a>
		';
	}
	
	function start_Action()
	{
		echo $this->nav();
		echo '<h1>Start - Index View</h1>';
	}
	
	function edit_Action()
	{
		echo $this->nav();
		echo '<h1>Edit Form</h1>';
	}
	
	function new_Action()
	{
		echo $this->nav();
		echo '<h1>New Form</h1>';
	}
}

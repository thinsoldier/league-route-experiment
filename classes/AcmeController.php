<?php
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
		//var_dump( get_class_methods($response) );
		
		if( !isset($args['cmd'] )){ echo '<b>orders index</b>'; }
		
		$response->getBody()->write( ob_get_clean() );
		
		// Route callables must return an instance of (Psr\Http\Message\ResponseInterface)
		return $response;
	} 
}

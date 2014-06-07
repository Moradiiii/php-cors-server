<?php
	
	include 'api/class.cors.php';
	
	/* 
	$config['AllowOrigin'] = 'https://example.com';
	$config['MaxAge'] = 3600;
	$config['AllowCredentials'] = true;
	$config['AllowMethods'] = array('GET','POST','PUT','DELETE');
	$config['AllowHeaders'] = true;
	$config['ExposeHeaders'] = array('My-Custom-Header');
	
	$cors = new PHP_CORS_SERVER($config);
	
	*/
	
	$cors = new PHP_CORS_SERVER(array(
	
		//the origin we want to support.
		'AllowOrigin' => 'https://example.com',
		
		//cache this response. if doing browser testing, clear cache and remove this will help you see preflights  properly
		//'MaxAge' => 3600,
		
		//allows us to use HTTP Authorization (Authorization header)
		'AllowCredentials' => true,
		
		//restrict to our API methods we want to support
		//we don't have to put OPTIONS on this
		'AllowMethods' => array(
			'GET',
			'POST',
			'PUT',
			'DELETE'
		),
		//mirror any headers sent, ok per spec
		'AllowHeaders' => true
	));
	
	$cors->respond();
	
	echo 'Content!';

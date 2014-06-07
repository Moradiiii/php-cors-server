<?php

	include 'class.cors.php';
	
	
	//===============================
	//	Setter style implementation
	//===============================
	$cors = new PHP_CORS_SERVER();
	
	 
	//required. 
	//* is allowed for a public resource.
	$cors->setAllowOrigin('https://app.example.com');
	
	//optional, number of seconds
	$cors->setMaxAge(86400);
	
	//optional, defaults to false, including if omitted.
	//* origin will always be false, regardless of what you set here
	$cors->setAllowCredentials(true);
	
	//optional, defaults to mirror browser request.
	//you don't need to put OPTIONS in this list
	$cors->setAllowMethods(array(
		'GET',
		'POST',
		'PUT',
		'DELETE'
	));
	
	//optional, defaults to mirror browser request.
	$cors->setAllowHeaders(array(
		'X-Requested-With',
		'Authorization'
	));
	
	//optional, additional headers beyond supported simple headers that you'll want access to in your app
	$cors->setExposeHeaders(array(
		'X-My-Custom-Header', //common example
		'Content-Length' //not a simple header
	));
	
	$cors->respond();
	
	
	
	//===============================
	//	Config based instantiation
	//===============================
	
	
	$cors = new PHP_CORS_SERVER(array(
		'AllowOrigin' => 'https://api.example.com',
		'MaxAge' => 86400,
		'AllowCredentials' => true,
		'ExposeHeaders' => array(
			'Content-Length'
		),
		'AllowMethods' => array(
			'GET',
			'POST',
			'PUT',
			'DELETE'
		),
		'AllowHeaders' => array(
			'X-Requested-With',
			'Authorization'
		)
	));
	
	$cors->respond();
	
	echo 'Content ' . uniqid();

#PHP CORS Server

Implements Cross-Origin Resource Sharing (CORS) on the server side
Based on http://www.w3.org/TR/cors/

I use it to allow AJAX requests to an API based on client domain. 

Include class.cors.php before you send any content (headers will be sent by this function) and call the respond() function of the object after setting basic options.

If you want to manage CORS by domain, simply store the configuration data in a database (or, other storage mechanism) and use the Origin header to lookup which config options to set.

##Example
```php
<?php
	include 'class.cors.php';
	
	$config['AllowOrigin'] = 'https://example.com';
	//$config['MaxAge'] = 3600; //how long to cache this response. 
	$config['AllowCredentials'] = true;
	$config['AllowMethods'] = array('GET','POST','PUT','DELETE');
	$config['AllowHeaders'] = true; //array of headers, or true to mirror what the browser sends
	$config['ExposeHeaders'] = array('My-Custom-Header'); //custom headers that the browser should expose to the calling function
	
	$cors = new PHP_CORS_SERVER($config);
	$cors->respond();
	
	//implement the rest of your app here. cors needs to send headers before *any* content is sent. 

```

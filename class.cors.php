<?php

	class PHP_CORS_SERVER{
		private $AllowOrigin;
		private $MaxAge;
		private $AllowCredentials;
		private $ExposeHeaders;
		private $AllowMethods;
		private $AllowHeaders;
		
		private $abortRequest;
	
		function __construct($config = false){
			if($config === false){
				//load our defaults.
				$this->setAllowOrigin();
				$this->setMaxAge();
				$this->setAllowCredentials();
				$this->setExposeHeaders();
				$this->setAllowMethods();
				$this->setAllowHeaders();
			}
			else{
				if(is_array($config)){
					foreach($config as $key => $val){
						if($key == 'AllowOrigin'){
							$this->setAllowOrigin($val);
						}
						elseif($key == 'MaxAge'){
							$this->setMaxAge($val);
						}
						elseif($key == 'AllowCredentials'){
							$this->setAllowCredentials($val);
						}
						elseif($key == 'ExposeHeaders'){
							$this->setExposeHeaders($val);
						}
						elseif($key == 'AllowMethods'){
							$this->setAllowMethods($val);
						}
						elseif($key == 'AllowHeaders'){
							$this->setAllowHeaders($val);
						}
						else{
							//ignore anything else
						}
						
					}
				}
			
			}
		}
		
		public function setAllowOrigin($url = false){
			if($url === false){
				$this->AllowOrigin = false;
			}
			else{
				$this->AllowOrigin = $url;
			}
			
		}
		
		public function setMaxAge($seconds = false){
			if($seconds === false){
				$this->MaxAge = false;
			}
			elseif(is_int($seconds)){
				$this->MaxAge = $seconds;
			}
			else{
				$this->MaxAge = false;
			}
		}
		
		public function setAllowCredentials($allowed = false){
			if(is_bool($allowed)){
				$this->AllowCredentials = $allowed;
			}
			else{
				$this->AllowCredentials = false;
			}
		}
		
		public function setExposeHeaders($headers = false){
			if(is_array($headers)){
				$this->ExposeHeaders = $headers;
			}
			else{
				$this->ExposeHeaders = false;
			}
		}
		
		public function setAllowMethods($methods = false){
			if(is_array($methods)){
				$this->AllowMethods = $methods;
			}
			else{
				$this->AllowMethods = true;
			
			}
		}
		
		public function setAllowHeaders($headers = false){
			if(is_array($headers)){
				$this->AllowHeaders = $headers;
			}
			else{
				$this->AllowHeaders = true;
			}
				
		}
		
		private function createResponse(){
		
			if(isset($_SERVER['HTTP_ORIGIN'])){
			
				//re-sanitize our data
				$this->setAllowOrigin($this->AllowOrigin);
				$this->setMaxAge($this->MaxAge);
				$this->setAllowCredentials($this->AllowCredentials);
				$this->setExposeHeaders($this->ExposeHeaders);
				$this->setAllowMethods($this->AllowMethods);
				$this->setAllowHeaders($this->AllowHeaders);
				
				if($this->AllowOrigin === false){
					return false;
				}
				else{
					$response['Access-Control-Allow-Origin'] = $this->AllowOrigin;
				}
				
				if($this->AllowCredentials){
					$response['Access-Control-Allow-Credentials'] = 'true';
				}
				else{
					if (isset($_SERVER['PHP_AUTH_USER']) || isset($_SERVER['HTTP_AUTHENTICATION'])){
						$response['Access-Control-Allow-Credentials'] = 'true';
					}
					else{
						$response['Access-Control-Allow-Credentials'] = 'false';
					}
				}
				
				if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
					if (!isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
						return false;
					}
					else{
						if($this->AllowMethods === false){
							return false;
						}
						elseif($this->AllowMethods === true){
							$response["Access-Control-Allow-Methods"] = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'];
						}
						elseif(is_array($this->AllowMethods)){
							foreach($this->AllowMethods as $hdr){
								$allow_methods_header .= "$hdr, ";
							}
							
							$allow_methods_header = rtrim($allow_methods_header, ',');
							$response["Access-Control-Allow-Methods"] = $allow_methods_header;	
						}
						else{
							return false;
						}
					}
					
					if (!isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
					}
					else{
						if($this->AllowHeaders === false){
						}
						elseif($this->AllowHeaders === true){
							$response["Access-Control-Allow-Headers"] = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'];
						}
						elseif(is_array($this->AllowHeaders)){
							foreach($this->AllowHeaders as $hdr){
								$allow_headers_header .= "$hdr, ";
							}
							
							$allow_headers_header = rtrim($allow_headers_header, ',');
							$response["Access-Control-Allow-Headers"] = $allow_headers_header;
							
						}
						else{
						}
					}
					
					if($this->MaxAge === false){
					}
					else{
						$response['Access-Control-Max-Age'] = $this->MaxAge;
					}
				}
				else{
					if($this->ExposeHeaders === false){
					}
					else{

						if(is_array($this->ExposeHeaders)){
							foreach($this->ExposeHeaders as $expose){
								$expose_headers_header .= "$expose, ";
							}
							
							$expose_headers_header = rtrim($expose_headers_header, ',');
							
							$response['Access-Control-Expose-Headers'] = $expose_headers_header;
						}
					}
				}
				
				if($this->AllowOrigin == '*'){
					$response['Access-Control-Allow-Credentials'] = 'false';
				}
				
				return $response;
			}
			else{
				return false;
			}
			
		}
		
		
		
		public function respond(){
		
			$response = $this->createResponse();
			if($response === false){
				//not a cors request
				return true;
			}
			elseif(is_array($response)){
				foreach($response as $key => $val){
					header("$key: $val");
				}
				
				if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
					die();
				}
			}
			else{
				//some kind of error, we bail.
				return false;
			}
			

		}
		
	
	}
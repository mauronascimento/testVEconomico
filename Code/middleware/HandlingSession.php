<?php

class HandlingSession {

	private $ini_array = array();
	private $origin = 'app';
	private $serverParams;

	public function __construct($request, $ini_array){
		$this->setIni($ini_array);
		$this->setserverParams($request->getserverParams());
		$this->checkOrigin();
	}

	public function setIni($ini_array){
		$this->ini_array = $ini_array;
	}

	public function setserverParams($serverParams){
		$this->serverParams = $serverParams;
	}

	private function checkOrigin(){
		$listaWeb = array('MSIE', 'Firefox', 'Chrome', 'Safari'); //somente mais utilizados
		foreach($listaWeb as $value){
			if(stripos($this->serverParams['HTTP_USER_AGENT'], $value) !== false)
				$this->origin = 'web';
		}
	}

	public function validate(){

		if(!isset($_SESSION[$this->origin])){
			if($this->origin == 'web'){
				header('WWW-Authenticate: Basic realm="My Realm"');
				if(!isset($this->serverParams['PHP_AUTH_USER']))
					return false;

				if($this->serverParams['PHP_AUTH_USER'] == $this->ini_array[$this->origin]['user'] 
					&& $this->serverParams['PHP_AUTH_USER'] == $this->ini_array[$this->origin]['pass']){
					session_start();
					$_SESSION[$this->origin] = true;
					return true;
				}
				return false;
			}
			if($this->origin == 'app'){
				if($this->serverParams['HTTP_TUNELKEY'] == $this->ini_array[$this->origin]['tunelKey'] 
					&& $this->serverParams['HTTP_SECRETKEY'] == $this->ini_array[$this->origin]['secretKey']){
					session_start();
					$_SESSION[$this->origin] = true;
					return true;
				}
				return false;
			}
			return false;
		}
		return true;
	}

}
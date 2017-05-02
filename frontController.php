<?php

// var_dump($_SERVER['CONTEXT_DOCUMENT_ROOT']);
// var_dump($_SERVER['CONTEXT_PREFIX']);
// var_dump(__DIR__);
define('SERVER_ROOT', __DIR__.'/');
// define('CLIENT_ROOT', __DIR__.'/');
define('CLIENT_ROOT', str_replace( $_SERVER['CONTEXT_DOCUMENT_ROOT'] , $_SERVER['CONTEXT_PREFIX'] , __DIR__).'/');
// define('CLIENT_ROOT', str_replace((array_key_exists('CONTEXT_DOCUMENT_ROOT', $_SERVER) ? $_SERVER['CONTEXT_DOCUMENT_ROOT'] : $_SERVER['DOCUMENT_ROOT']), (array_key_exists('CONTEXT_PREFIX', $_SERVER) ? $_SERVER['CONTEXT_PREFIX'] : null), __DIR__).'/');



spl_autoload_register(function($className){

	if(file_exists(SERVER_ROOT.'/core/'.$className.'.php')){
		include SERVER_ROOT.'/core/'.$className.'.php';
	}
	if(file_exists(SERVER_ROOT.'/controllers/'.$className.'.php')){
		include SERVER_ROOT.'/controllers/'.$className.'.php';
	}
	if(file_exists(SERVER_ROOT.'/models/'.$className.'.php')){
		include SERVER_ROOT.'/models/'.$className.'.php';
	}
});

$controllerName = ucfirst($_GET['controller']).'Controller';
$actionName = $_GET['action'].'Action';

if(class_exists($controllerName)){
	$controller = new $controllerName();

	if(method_exists($controller, $actionName))
	{
		$controller->$actionName();
	}
	else
	{
		exit ('page inexistante');
	}
}else{
	exit ('page inexistante');
}
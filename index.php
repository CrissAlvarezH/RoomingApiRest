<?php

require 'utilidades/constantes.php';
require 'utilidades/exceptionApi.php';
require 'vistas/vistaJson.php';

$vista = new VistaJson();
// definimos una funcion para manejar las excepciones
set_exception_handler(function($exception) use ($vista){
	$cuerpo = array(
		"estado" => $exception->estado,
		"mensaje" => $exception->getMessage()
	);

	if($exception->getCode()){
		// vistaJson pondrá el codigo en la cabecera
		$vista->estado = $exception->getCode();
	}else{// si el codigo es cero
		$vista->estado = 500;// 500 indica error del servidor
	}

	$vista->imprimir($cuerpo);// imprimimos el JSON y el codigo en la cabecera
});

// convertimos en array lo que redireccionamos con el archivo .htaccess
$peticionArray = explode("/", $_GET["RUTA_INFORMACION"]);

$recursosDisponibles  = array('docentes', 'alumnos');

if(!in_array($peticionArray[0], $recursosDisponibles)){
	throw new ExceptionApi(RECURSO_NO_ENCONTRADO, "recurso no disponible");
}

$metodo = strtolower($_SERVER['REQUEST_METHOD']);//: get,post,... (minusculas)

switch ($metodo) {
	case 'get':
		$vista->imprimir(array('estado' => 000, 'mensaje' => 'probando...'));
		break;
	case 'post':

		break;
	case 'put':

		break;
	case 'delete':

		break;
	default:
		throw new ExceptionApi(METODO_NO_SOPORTADO, "metodo no soportado");
}

?>

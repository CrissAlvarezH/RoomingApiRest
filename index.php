<?php
require_once 'controladores/alumnosControlador.php';
require_once 'controladores/bloquesControlador.php';
require_once 'controladores/docentesControlador.php';
require_once 'utilidades/constantes.php';
require_once 'utilidades/exceptionApi.php';
require_once 'vistas/vistaJson.php';

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

$recursosDisponibles  = array('docentes', 'alumnos', 'bloques');

$recurso = array_shift($peticionArray);

if(!in_array($recurso, $recursosDisponibles)){
	throw new ExceptionApi(RECURSO_NO_ENCONTRADO, "recurso no disponible");
}

$metodo = strtolower($_SERVER['REQUEST_METHOD']);// get, post,... (minusculas)

switch ($metodo) {
	case 'get':

		switch($recurso){
			case 'bloques':
				$vista->imprimir(BloquesControlador::get($peticionArray));
				break;
			case 'alumnos':
				$vista->imprimir(AlumnosControlador::get($peticionArray));
				break;
			case 'docentes':
				$vista->imprimir(DocentesControlador::get($peticionArray));
				break;
			default:
				throw new ExceptionApi(100, "error en la URL");
		}

		break;
	case 'post':
		switch($recurso){
			case 'bloques':
				break;
			case 'alumnos':
				$vista->imprimir(AlumnosControlador::post($peticionArray));
				break;
			case 'docentes':
				$vista->imprimir(AlumnosControlador::post($peticionArray));
				break;
		}

		break;
	case 'put':

		break;
	case 'delete':

		break;
	default:
		throw new ExceptionApi(METODO_NO_SOPORTADO, "metodo no soportado");
}

?>

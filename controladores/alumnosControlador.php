<?php
require_once 'modelos/alumnosModelo.php';
require_once 'utilidades/constantes.php';// para que no se redeclare
require_once 'utilidades/exceptionApi.php';

class AlumnosControlador {

	public static function get($peticion){
		if(empty($peticion[0])){
			return AlumnosModelo::getTodos();

		}else if(count($peticion) == 1){
			return AlumnosModelo::getPorId($peticion[0]);

		}else{
			switch ($peticion[1]) {
				case 'grupos':
					return AlumnosModelo::getGrupos($peticion[0]);

					break;
				default:
					throw new ExceptionApi(PARAMETROS_INCORRECTOS, "parametros incorrecta");
			}
		}
	}

	public static function post($peticion){
		// obtenemos el fichero que viene con la peticion POST
		$cuerpoPost = file_get_contents("php://input");
		$datosUsuario = json_decode($cuerpoPost);//parseamos a JSON

		if(!empty($peticion[0])){// URL: alumnos/login ó alumnos/registro
			switch ($peticion[0]) {
				case 'login':
					return AlumnosModelo::login($datosUsuario);

					break;
				case 'registro':
					return AlumnosModelo::insertar($datosUsuario);

					break;
				default:
					throw new ExceptionApi(PARAMETROS_INCORRECTOS, "parametros incorrecta");
			}
		}else{
			throw new ExceptionApi(PARAMETROS_INCORRECTOS, "parametros incorrecta");
		}
	}
}

?>

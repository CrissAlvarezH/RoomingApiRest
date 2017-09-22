<?php
require 'modelos/docentesModelo.php';
require 'utilidades/constantes.php';
require 'utilidades/exceptionApi.php';

class DocenteControlador {

	public static function get($peticion){
		if(empty($peticion[0])){// URL: docentes
			return DocentesModelo::getTodos();

		}else if(count($peticion) == 1){// URL: docentes/106753974
			return DocentesModelo::getPorId($peticion[0]);

		}else{
			switch ($peticion[1]) {// URL: docentes/1035453/grupos
				case 'grupos':
					return DocentesModelo::getGrupos($peticion[0]);

					break;

				default:
					throw new ExceptionApi(PARAMETrOS_INCORRECTOS, "parametros incorrectos");
			}
		}
	}

	public static function post($peticion){
		// sacamos la cabecera que viene por metodo POST
		$cuerpoCabecera = file_get_contents("php://input");
		$datosDocente = json_decode($cuerpoCabecera);// parseamos a JSON

		if(!empty($peticion[0])){
			switch ($peticion[0]) {
				case 'login':// URL: docentes/login
					return DocentesModelo::login($datosDocente);

					break;
				default:
					throw new ExceptionApi(PARAMETROS_INCORRECTOS,
					 	"parametros incorrectos");
			}
		}else{
			throw new ExceptionApi(PARAMETROS_INCORRECTOS, "parametros incorrectos");
		}
	}
}

?>

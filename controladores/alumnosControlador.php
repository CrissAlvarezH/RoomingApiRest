<?php
require 'modelos/alumnosModelo.php';
require 'utilidades/constantes.php';
require 'utilidades/exceptionApi.php';

class AlumnosControlador {

	public static GET($peticion){
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

	public static POST($peticion){
		if(!empty($peticion[0])){
			switch ($peticion[0]) {
				case 'login':

					break;
				case 'registro':

					break;
				default:
					throw new ExceptionApi(PARAMETROS_INCORRECTOS, "parametros incorrecta");
			}
		}else
			throw new ExceptionApi(PARAMETROS_INCORRECTOS, "parametros incorrecta");
	}
}

?>

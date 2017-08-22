<?php
require 'modelos/docentesModelo.php';
require 'utilidades/constantes.php';
require 'utilidades/exceptionApi.php';

class DocenteControlador {

	public static function get($peticion){
		if(empty($peticion[0])){
			return DocentesModelo::getTodos();

		}else if(count($peticion) == 1){
			return DocentesModelo::getPorId($peticion[0]);

		}else{
			switch ($peticion[1]) {
				case 'grupos':
					return DocentesModelo::getGrupos($peticion[0]);

					break;

				default:
					throw new ExceptionApi(PARAMETOS_INCORRECTOS, "parametros incorrectos");
			}
		}
	}
}

?>

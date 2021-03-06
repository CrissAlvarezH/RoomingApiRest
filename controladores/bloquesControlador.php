<?php
require_once 'utilidades/constantes.php';
require_once 'modelos/bloquesModelo.php';
require_once 'utilidades/exceptionApi.php';
require_once 'modelos/salonesModelo.php';
require_once 'modelos/clasesModelo.php';

class BloquesControlador {

	/* Ejemplo de la URL: bloques/3/salones/7/clases/6/8/alumnos pide los alumnos
	 de la clase de la asignatura 6 en el grupo 8 que se encuentra en el salon
	  7 del bloque 3 */

	public static function get($peticion){
		// este seria el caso de URL: bloques
		if(empty($peticion[0])){ // si estan podiendo todos los bloques
			return BloquesModelo::getTodos();

		// Ejmplo URL: bloques/5
		}else if(count($peticion) == 1){
			return BloquesModelo::getPorNumero($peticion[0]);

		// ejemplo URL: bloques/6/salones
		}else if(count($peticion) == 2){
			switch ($peticion[1]) {
				case 'salones':// si piden los salones de un bloque
					return BloquesModelo::getSalones($peticion[0]);

					break;
				default:
					throw new ExceptionApi(PARAMETROS_INCORRECTOS,
					 "parametros incorrectos");
			}

		// ejemplo URL: bloques/6/salones/6/clases clases de un salon
		}else if(count($peticion) == 4){
			switch ($peticion[3]) {
				case 'clases':// si piden los salones de un bloque
					// le pasamos el codigo del salon y el numero del ploque
					return SalonesModelo::getTodasLasClases($peticion[2], $peticion[0]);

					break;
				default:
					throw new ExceptionApi(PARAMETROS_INCORRECTOS,
					 "parametros incorrectos");
			}

		//ejemplo URL: bloques/6/salones/5/clases/4/7 clase de la materia 4, grupo 7
		}else if(count($peticion) == 6){


		// ejemplo URL: bloques/6/salones/4/clases/3/7/alumnos
		// el cual pide los alumnos de la clase de la materia 3, grupo 7 ....
		}else if(count($peticion) == 7){
			// se le pasa el codigo de la materia y el numero del grupo
			return ClasesModelo::getAlumnos($peticion[4], $peticion[5]);
		}
	}

}

?>

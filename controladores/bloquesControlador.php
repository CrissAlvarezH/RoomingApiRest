<?php
require 'utilidades/constantes.php';
require 'modelos/bloquesModelo.php';
require 'utilidades/exceptionApi.php';
require 'modelos/salonesModelo.php';

class BloquesControlador {

	/* Ejemplo de la URL: bloques/3/salones/7/clases/6/alumnos pide los alumnos
	 de la clase 6 que se encuentra en el salon 7 del bloque 3 */

	public static function get($peticion){
		// este seria el caso de URL: bloques
		if(empty($peticion[0]){// si estan podiendo todos los bloques
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
					throw new ExceptionApi(PARAMETROS_INCORRECTOS, "parametros incorrectos");
			}

		// ejemplo URL: bloques/6/salones/6/clases clases de un salon
		}else if(count($peticion) == 4){
			switch ($peticion[1]) {
				case 'salones':// si piden los salones de un bloque
					// le pasamos el codigo del salon y el numero del ploque
					return SalonesModelo::getTodasLasClases($peticion[2], $peticion[0]);

					break;
				default:
					throw new ExceptionApi(PARAMETROS_INCORRECTOS, "parametros incorrectos");
			}

		// ejemplo URL: bloques/6/salones/5/clases/4 pide una clase de un salon
		}else if(count($peticion) == 5){


		// ejemplo URL: bloques/6/salones/4/clases/3/salones/7/clases/3/alumnos
		// el cual pide los alumnos de la clase 3 ....
		}else if(count($peticion) == 6){
			
		}
	}

}

?>

<?php
require 'utilidades/constantes.php';
require 'modelos/bloquesModelo.php';

class BloquesControlador {

	public static function get($peticion){
		if(empty($peticion[0]){// si estan podiendo todos los bloques
			return BloquesModelo::getTodos();

		}else if(count($peticion) == 1){// si piden un bloque en especifico
			return BloquesModelo::getPorNumero($peticion[0]);

		}else{
			switch ($peticion[1]) {
				case 'salones':// si piden los salones de un bloque
					return BloquesModelo::getSalones($peticion[0]);

					break;
				default:
				throw new ExceptionApi(PARAMETOS_INCORRECTOS, "parametros incorrectos");
			}
		}
	}

}

?>

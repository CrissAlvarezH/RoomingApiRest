<?php
require 'datos/conexionDB.php';
require 'modelos/bloquesModelo.php';
require 'utilidades/constantes.php';

class BloquesModelo {
	// Nombre de la tabla, y nombre de los campos
	private const NOMBRE_TABLA = "bloques";
	private const NUMERO = "numero_bloque";
	private const DESCRIPCION = "descripcion_bloque";

  /** Inserta un registro de la base de datos en la tabla 'bloques'
	* @param datosBloque es un JSON con los datos a insertar
	*/
	public static insertar($datosBloque){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$consultaSQL = "INSERT INTO ".NOMBRE_TABLA.
				"(".NUMERO.", ".DESCRIPCION.") VALUES (?, ?);";

			$sentancia = $conexion->prepare($consultaSQL);// preparamos la consulta

			// enlazamos los parametros a la consulta de INSERT INTO
			$sentencia->bindParam(1, $datosBloque->numero);
			$sentencia->bindParam(3, $datosBloque->descripcion);

			if($sentencia->execute()){//ejecutamos la sentencia y evaluamos el retorno
				return CREACION_EXITOSA;
			}else{
				return CREACION_FALLIDA;
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}
}

?>

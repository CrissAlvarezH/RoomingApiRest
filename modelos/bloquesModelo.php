<?php
require 'datos/conexionDB.php';
require 'utilidades/constantes.php';
require 'utilidades/exceptionApi.php';

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

			$consultaSQL = "INSERT INTO ".NOMBRE_TABLA
				."(".NUMERO.", ".DESCRIPCION.") VALUES (?, ?);";

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

	/**
	* Retorna todos los bloques que esten en la base de datos
	*/
	public static getTodos(){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$select = "SELECT * FROM ".NOMBRE_TABLA.";";

			$sentencia = $conexion->prepare($select);

			if($sentencia->execute()){
				http_response_code(200);// indica que todo bien en la cabecera
				/* fetchAll(PDO::FECH_ASSOC) retorna la respuesta de la consulta en un
				 array asosiativo gracias al parametro PDO::FECH_ASSOC */
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else{
				throw new ExceptionApi(ESTADO_FALLIDO, "error al obtener los datos");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(ESTADO_FALLIDO, "error al obtener los datos");
		}
	}

	/**
	* @param $numero es el numero que identifica los bloques que seran retornados
	*/
	public static getPorNumero($numero){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$select = "SELECT * FROM ".NOMBRE_TABLA
				." WHERE ".NUMERO." = ?;";

			$sentencia = $conexion->prepare($select);

			$sentencia->bindParam(1, $numero);

			if($sentencia->execute()){
				http_response_code(200);
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else{
				throw new ExceptionApi(ESTADO_FALLIDO, "error al obtener los datos");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(ESTADO_FALLIDO, "error al obtener los datos");
		}
	}
}

?>

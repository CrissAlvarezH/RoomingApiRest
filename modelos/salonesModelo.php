<?php
require 'datos/conexionBD.php';
require 'utilidades/constantes.php';
require 'utilidades/exceptionApi.php';

class SalonesModelo {
	// nombre de los atributos de las tablas
	private const NOMBRE_TABLA = "salones";
	private const CODIGO = "codigo_salon";
	private const NOMBRE = "nombre_salon";
	private const BLOQUE = "numero_bloque_salon";

	public static function insertar($datosSalon){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$consulta = "INSERT INTO ". self::NOMBRE_TABLA . "(". self::CODIGO
				.",". self::NOMBRE .",". self::BLOQUE .") VALUES (?, ?, ?);";

			$sentencia = $conexion->prepare($consulta);

			$sentencia->bindParam(1, $datosSalon->codigo);
			$sentencia->bindParam(2, $datosSalon->nombre);
			$sentencia->bindParam(3, $datosSalon->cod_bloque);

			if($sentencia->execute()){
				return
					[
						"estado" => CREACION_EXITOSA,
						"mensaje" => "salon creado"
					];
			}else{
				throw new ExceptionApi(PDO_ERROR, "error al ejecutarse la consulta");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	/** Obtiene los datos de un salon en especifico
	* @param $codigoSalon es el codigo del salon que se quiere saber los datos
	* @param $numeroBloque el bloque en el cual esta el salon
	*/
	public static function getSalon($codigoSalon, $numeroBloque){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$query = "SELECT * FROM salones WHERE codigo_salon = ?"
				." AND numero_bloque_salon = ?;";

			$sentencia = $conexion->prepare($query);

			$sentencia->bindParam(1, $codigoSalon);
			$sentencia->bindParam(2, $numeroBloque);

			if($sentencia->execute()){
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else{
				throw new ExceptionApi(PDO_ERROR, "error al ejecutar la sentencia");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	/** Retorna la informacion de todas las clases asosiadas a un salon
	* @param $codigoSalon es el codigo del salon
	* @param $numeroBloque el bloque donde esta el salon
	*/
	public static function getTodasLasClases($codigoSalon, $numeroBloque){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$query = "SELECT cod_materia, numero_grupo, nombre_materia, "
			 	."creditos_materia, hora_inicio, hora_fin, dia, nombre_docente, "
				."apellidos_docente FROM clases, grupos, docentes, materia "
				."WHERE numero_grupo = numero_grupo_clase "
				."AND cod_materia = cod_materia_grupo "
				."AND cod_materia_grupo = cod_materia_clase "
				."AND id_docente_grupo = id_docente "
				."AND codigo_salon_clase = ? AND numero_bloque_clase = ?;";

			$sentencia = $conexion->prepare($query);

			$sentencia->bindParam(1, $codigoSalon);
			$sentencia->bindParam(2, $numeroBloque);

			if($sentencia->execute()){
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else {
				throw new ExceptionApi(PDO_ERROR, "error al ejecutar la sentencia");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en la conexion PDO");
		}
	}
}

?>

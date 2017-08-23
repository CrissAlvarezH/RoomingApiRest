<?php
require 'datos/conexionDB.php';
require 'utilidades/constantes.php';
require 'utilidades/exceptionApi.php';

class DocentesModelo {
	private const NOMBRE_TABLA = "docentes";
	private const ID = "id_docente";
	private const NOMBRE = "nombre_docente";
	private const APELLIDOS = "apellidos_docente";
	private const TITULOS = "titulos_docente";
	private const CODIGO = "codigo_docente";

	public static function insertar($datosDocente){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$consultaSQL = "INSERT INTO ".self::NOMBRE_TABLA
				."(".self::ID.", ".self::NOMBRE.", ".self::APELLIDOS.", "
				.self::TITULOS.", ".self::CODIGO.") "
				."VALUES (?, ?, ?, ?, ?);";

			$sentencia = $conexion->prepare($consulta);

			$sentancia->bindParam(1, $datosDocente->id);
			$sentencia->bindParam(2, $datosDocente->nombre);
			$sentencia->bindParam(3, $datosDocente->apellidos);
			$sentencia->bindParam(4, $datosDocente->titulo);
			$sentencia->bindParam(5, $datosDocente->codigo);

			if($sentencia->execute()){
				return
					[
						"estado" => CREACION_EXITOSA,
						"mensaje" => "docente creado"
					];
			}else{
				throw new ExceptionApi(CREACION_FALLIDA, "error en la sentencia");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	public static function getTodos(){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$select = "SELECT * FROM ".self::NOMBRE_TABLA.";";

			$sentencia = $conexion->prepare($select);

			if($sentencia->execute()){
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else{
				throw new ExceptionApi(ESTADO_FALLIDO, "fallo al obtener datos");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en la conexion PDO");
		}
	}

	public static function getPorId($id){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$select = "SELECT * FROM ".self::NOMBRE_TABLA
				." WHERE ".self::ID." = ?";

			$sentencia = $conexion->prepare($select);

			$sentencia->bindParam(1, $id);

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
			throw new ExceptionApi(PDO_ERROR, "error en la conexion PDO");
		}
	}

	public static function getGrupos($id){
		try{
			$conexion = Conecion::getInstancia()->getConexion();

			$query = "SELECT numero_grupo, nombre_materia, creditos_materia "
				. "FROM grupos, materias WHERE cod_materia_grupo = cod_materia "
				. "AND id_docente_grupo = $id";

			$sentencia = $conexion->prepare($query);

			$sentencia->bindParam(1, $id);

			if($sentencia->execute()){
				http_response_code(200);
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else{
				throw new ExceptionApi(ESTADO_FALLIDO, "error al realizar la consulta");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en la conexion PDO");
		}
	}
}

?>

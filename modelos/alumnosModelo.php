<?php
require 'datos/conexionBD.php';
require 'utilidades/constantes.php';
require 'urilidades/exceptionApi.php';

class AlumnosModelo {
	private const NOMBRE_TABLA = "alumnos";
	private const ID = "id_alumno";
	private const NOMBRE = "nombre_alumno";
	private const APELLIDOS = "apellidos_alumnos";
	private const CONTRASENA = "contrasena_alumnos";

	public static function insertar($datosAlumno){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$query = "INSERT INTO ".NOMBRE_TABLA." ( ".ID.", ".NOMBRE.", ".APELLIDOS
				.", ".CONTRASENA.") VALUES (?, ?, ?, ?);";

			$sentencia = $conexion->prepare($query);

			$sentencia->bindParam(1, $datosAlumno->id);
			$sentencia->bindParam(2, $datosAlumno->nombre);
			$sentencia->bindParam(3, $datosAlumno->apellidos);
			$sentencia->bindParam(4, $datosAlumno->contrasena);

			if($sentencia->execute()){
				return
					[
						"estado" => CREACION_EXITOSA,
						"mensaje" => "alumno creado"
					];
			}else{
				throw new ExceptionApi(CREACION_FALLIDA, "error en la sentencia");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	public static function login($datosUsuario){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$query = "SELECT * FROM ".NOMBRE_TABLA
				." WHERE id = ? AND contrasena = ?;";

			$sentencia = $conexion->prepare($query);

			$sentencia->bindParam(1, $datosUsuario->id);
			$sentencia->bindParam(2, $datosUsuario->contrasena);

			if($sentencia->execute()){
				if($sentencia->rowCount() > 0){//si algun usuario coincide con los datos
					return
						[
							"estado" => LOGIN_OKAY,
							"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
						];
				}else{//si los datos estas incorrectos
					return
						[
							"estado" => LOGIN_NOT_OKAY,
							"datos" => ""
						];
				}
			}else{
				throw new ExceptionApi(LOGIN_NOT_OKAY, "error en la consulta");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	public static function getTodos(){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$sentencia = $conexion->prepare("SELECT * FROM ".NOMBRE_TABLA.";");

			if($sentencia->execute()){
				http_response_code(200);
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else{
				throw new ExceptionApi(ESTADO_FALLIDO, "error en la consulta");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	public static function getPorId($id){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$query = "SELECT * FROM ".NOMBRE_TABLA." WHERE id_alumno = ?;";

			$sentencia = $conexion->prepare($query);

			$sentencia->bindParam(1, $id);

			if($sentenacia->execute()){
				http_response_code(200);
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else{
				throw new ExceptionApi(ESTADO_FALLIDO, "error en la consulta");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	public static function getGrupos($idAlumno){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$query = "SELECT numero_grupo, nombre_materia, creditos_materia "
				."FROM grupos, alumno_grupo, materias "
				."WHERE numero_grupo = numero_grupo_alumno "
				."AND cod_materia = cod_materia_grupo AND id_alumno_grupo = ?;";

			$sentencia = $conexion->prepare($query);

			$sentencia->bindParam(1, $idAlumno);

			if($sentencia->execute()){
				http_response_code(200);
				return
					[
						"estado" => ESTADO_EXITOSO.
						"datos" => $sentencia->fetchAll(PDO::FETCH_ASSOC)
					];
			}else{
				throw new ExceptionApi(ESTADO_FALLIDO, "error en la consulta");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}
}

?>

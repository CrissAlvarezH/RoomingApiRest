<?php
require 'datos/conexionBD.php';

class AlumnosModelo {
	private const NOMBRE_TABLA = "alumnos";
	private const ID = "id_alumno";
	private const NOMBRE = "nombre_alumno";
	private const APELLIDOS = "apellidos_alumnos";
	private const CONTRASENA = "contrasena_alumnos";

	public static function insertar($datosAlumno){
		$conexion = Conexion::getInstancia()->getConexion();

		$query = "INSERT INTO ".NOMBRE_TABLA." ( ".ID.", ".NOMBRE.", ".APELLIDOS
			.", ".CONTRASENA.") VALUES (?, ?, ?, ?);";

		$sentencia = $conexion->prepare($query);

		$sentencia->bindParam(1, $datosAlumno->id);
		$sentencia->bindParam(2, $datosAlumno->nombre);
		$sentencia->bindParam(3, $datosAlumno->apellidos);
		$sentencia->bindParam(4, $datosAlumno->contrasena);

		if($sentencia->execute()){
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

?>

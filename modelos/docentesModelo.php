<?php
require 'datos/conexionDB.php';
require 'utilidades/constantes.php';
require 'utilidades/exceptionApi.php';

class Docentes {
	private const NOMBRE_TABLA = "docentes";
	private const ID = "id_docente";
	private const NOMBRE = "nombre_docente";
	private const APELLIDOS = "apellidos_docente";
	private const TITULOS = "titulos_docente";
	private const CODIGO = "codigo_docente";

	public static insertar($datosDocente){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$consultaSQL = "INSERT INTO ".NOMBRE_TABLA
				."(".ID.", ".NOMBRE.", ".APELLIDOS.", ".TITULOS.", ".CODIGO.") "
				."VALUES (?, ?, ?, ?, ?);";

			$sentencia = $conexion->prepare($consulta);

			$sentancia->bindParam(1, $datosDocente->id);
			$sentencia->bindParam(2, $datosDocente->nombre);
			$sentencia->bindParam(3, $datosDocente->apellidos);
			$sentencia->bindParam(4, $datosDocente->titulo);
			$sentencia->bindParam(5, $datosDocente->codigo);

			if($sentencia->execute()){
				return CREACION_EXITOSA;
			}else{
				return CREACION_FALLIDA;
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	public static getTodos(){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$select = "SELECT * FROM ".NOMBRE_TABLA.";";

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
}

?>

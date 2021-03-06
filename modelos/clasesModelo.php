<?php
require_once 'datos/conexionDB.php';
require_once 'utilidades/constantes.php';
require_once 'utilidades/exceptionApi.php';

class ClasesModelo {
	const NOMBRE_TABLA = "clases";
	const SALON = "codigo_salon_clase";
	const BLOQUE = "numero_bloque_clase";
	const GRUPO = "numero_grupo_clase";
	const MATERIA = "codigo_materia_clase";

	/** Retorna los alumnos de el grupo de la materia pasados por aparamteros
	* @param codigoMateria es el codigo de la materia de la clases
	* @param numeroGrupo es el grupo que da la clase en ese salon en ese momento
	*/
	public static function getAlumnos($codigoMateria, $numeroGrupo){
		try{
			$conexion = Conexion::getInstancia()->getConexion();

			$query = "SELECT id_alumno, nombre_alumno, apellidos_alumno "
				."FROM alumnos, grupo "
				."WHERE ".self::MATERIA." = ? AND ".self::GRUPO." = ?;";

			$sentencia = $conexion->prepare($query);

			$sentencia->bindParam(1, $codigoMateria);
			$sentencia->bindParam(2, $numeroGrupo);

			if($sentencia->execute()){
				return
					[
						"estado" => ESTADO_EXITOSO,
						"datos" => $sentencia->fetchAll(PDO::FECTH_ASSOC)
					];
			}else{
				throw new ExceptionApi(PDO_ERROR, "error al ejecutar la consulta");
			}
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en la conexion");
		}
	}

}

?>

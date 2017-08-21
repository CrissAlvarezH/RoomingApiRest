<?php
require 'utilidades/constantes.php';

class Conexion {
	private static $pdo;// Conexion
	private static $instancia = null;// unica instancia de esta clase

	// Constantes para crear la conexion con PDO
	private const HOST = "localhost";// Nombre del host
	private const BASE_DE_DATOS = "api_prueba"; // Nombre de la base de modelos
	private const USUARIO = "root"; // Nombre del usuario
	private const PASS = ""; // Constraseña

	private final function __construct(){// patron de diseño SINGLETON
		try{
			self::getConexion();// intentamos conectar
		}catch(PDOException $e){
			throw new ExceptionApi(PDO_ERROR, "error en conexion PDO");
		}
	}

	public static function getInstancia(){
		if($instancia == null){
			self::$instancia = new self();// llamamos al constructor
		}

		return self::$instancia;
	}

	public static function getConexion(){
		if(self::$pdo == null){
			// creamos una instancia de conexion con PDO
			$pdo = new PDO('mysql:dbname='.BASE_DE_DATOS.';host='.HOST.';',
				USUARIO, PASS,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			// habilitamos la excepciones
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		return self::$pdo;// retornamos la conexion
	}

}

?>

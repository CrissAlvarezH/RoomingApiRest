<?php

/** POR EL MOMENTO NO SE USARÁ, YA QUE NO SE IMPLEMENTARAN TODOS LO METODOS
 * Define el coomportamiento de los controladores
 */
interface BaseControlador {
	/** Metodo encargado de atender la peticion hecha por GET
	* @param peticion es la peticion como 1 ó 1/grupos ó materias/4, etc...
	*/
	public function get($peticion);

	/** Metodo encargado de atender la peticion hecha por POST
	* @param peticion es la peticion como 'login' ó 'registro'
	*/
	public function post($peticion);

	/** Metodo encargado de atender la peticion hecha por PUT
	* @param peticion trae el codigo de el recurso que se desea modificar
	*/
	public function put($peticion);

	/** Metodo encargado de atender la peticion hecha por DELETE
	* @param peticion trae el codigo de el recurso que se desea borrar
	*/
	public function delete($peticion);
}


?>

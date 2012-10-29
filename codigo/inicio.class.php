<?php

if(!defined('web'))
	die('No puedes estar aqui');

class codigo extends funciones{

public $sub_seccion;

	function __construct(){

	global $sa,$act,$default;
	
	/******************CONFIGURACION******************/
			$sa=isset($_GET['sa'])? escapar($_GET['sa']):0;

			$sub_secciones=array(
					0=>array('title'=>'Inicio'), //Funcion Index
					/*'sub_seccion1'=>array('title'=>'TITULO','requiere_funcion'=>true,'requiere_vista'=>true),' 
							al colocar true en requiere funcion, se debe crear la funcion en la clase... funcion sub_seccion1(){}
							, al colocar el requiere vista en true, es para hacer uso de un diseño...*/
			);
			
	if(!array_key_exists($sa,$sub_secciones) && !empty($sa))
		if(!AJAX)
			header('Location: '.$default['weburl']);
		else
			die('0');
		
	$this->sub_seccion=$sub_secciones[$sa];	

	/******************Fin Configuracion***************/
	}
	
	function index(){}
	
	
	
	
}




?>
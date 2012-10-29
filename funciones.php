<?php

if(!defined('web'))
	exit('No puedes estar aqui');

class db extends datos{
	
	private $mysqli;
	private static $conection=false;
	
	function __construct(){
		
		if(!self::$conection){
		//Conexion
			$this->mysqli= mysqli_connect($this->db_server, $this->db_user, $this->db_passwd, $this->db_name);
			
		//verificar conexion
			if (mysqli_connect_errno()) {
				echo 'Error enconexion';
				exit();
			}else
				$this->db_query("SET NAMES '".$this->db_character_set."'");
				
			self::$conection=true;	
		}		
		
	}
	
	function db_query($query){
		
				$result=mysqli_query($this->mysqli,$query);
				
				return $result;
	}
		
	function db_real_escape_string($str){
		
			$result=mysqli_real_escape_string($this->mysqli,$str);
			
			return $result;
	}
		
	function db_insert_id(){
		
			return mysqli_insert_id($this->mysqli);
			
	}
		
	//No Inyeccion
	function escape($texto){
		
			return $this->db_real_escape_string(htmlspecialchars(trim($texto)));
			
	}
		
	//No Inyeccion ni tag html
	function escape2($texto){
		
		return $this->db_real_escape_string(htmlspecialchars(trim(strip_tags($texto))));
		
	}


}


class funciones{


	
	function __construct(){}
	
	
	function cargar_theme($url){
	
		require ($url);
		
		$this->load('index');		
			
	}
	
	 function load($funcion){
	 
		global $sa,$act,$default;
		
				
		$code=new codigo();
		
		if(!empty($sa))
				$funcion=$sa;
		
		if(@$code->sub_seccion['requiere_vista'] && !empty($sa) || $funcion=='index'){
			require $default['tema_activo']."/".$act.".tema.php";
			$theme=new template();
		}	


//Codigos php		
		if(@$code->sub_seccion['requiere_funcion'] && !empty($sa) || $funcion=='index')
			$code->{$funcion}();

	//Head	
		if(!AJAX && (@$code->sub_seccion['requiere_vista'] || $funcion=='index'))
			head($code->sub_seccion['title'],empty($code->sub_seccion['description'])? $default['webdescripcion']:$code->sub_seccion['description']);

			
	//Body
		if(@$code->sub_seccion['requiere_vista'] && !empty($sa) || $funcion=='index'){
			$theme->{$funcion.'_vista'}();
			
		if(AJAX && (@$code->sub_seccion['requiere_vista'] || $funcion=='index'))
			echo'<script type="text/javascript">$("title").html("'.$default['webname'].' '.($code->sub_seccion['title']!=''? '- '.$code->sub_seccion['title']:'').'");</script>';
			
			}
	//Footer
		if(!AJAX && (@$code->sub_seccion['requiere_vista'] || $funcion=='index'))
			footer();
	}
	
	


	
}

function bbc($str){
	global $carateres_raros;
   if (empty($carateres_raros)){
      $todas = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES,'ISO-8859-15');
      $etiquetas = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES,'ISO-8859-15');
      $carateres_raros= array_diff($todas, $etiquetas);
   }
   $str = strtr($str, $carateres_raros);
   return $str;
}

function escapar($str){
	return htmlspecialchars(strip_tags(trim($str)));
}




?>
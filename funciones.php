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
	$versionPHP=(int) str_replace('.','',PHP_VERSION);

   if (empty($carateres_raros)){
	if($versionPHP[0]>=5 && $versionPHP[1]>=3 && $versionPHP[2]>=4){
      $todas = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES,'ISO-8859-15');
      $etiquetas = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES,'ISO-8859-15');
	 }else{
      $todas = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
      $etiquetas = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES);		
	 }
      $carateres_raros= array_diff($todas, $etiquetas);
   }
   $str = strtr($str, $carateres_raros);
   return $str;
}

function escapar($str){
	return htmlspecialchars(strip_tags(trim($str)));
}


//**** LOAD CSS ****//
	function loadCss($file,$ruta=NULL,$hash=true){
		global $default;
		
		if($ruta==NULL)
			$ruta=$default['weburl'].'/temas/'.$default['theme_default'].'/css/';


	preg_match('@^(?:http://)?([^/]+)@i', $ruta, $ruta0);

	if(preg_match('/[^.]+\.[^.]+$/',@$ruta0[1])){
		preg_match('/[^.]+\.[^.]+$/',@$ruta0[1], $ruta0);
		$ruta0=$ruta0[0];
	}else
		$ruta0=$ruta0[1];
			
			
		if(@$ruta0!=$_SERVER['HTTP_HOST'])
			$hash=false;

		
	echo '<link rel="stylesheet" type="text/css" href="'.$ruta.$file.'.css'.($hash==true? '?'.filemtime(dirname(__FILE__).'/temas/'.$default['theme_default'].'/css/'.$file.'.css'):'').'"/>';
	
	}
	
	
//**** LOAD JS ****//
	function loadJs($file,$ruta=NULL,$hash=true){
		global $default;
		
		if($ruta==NULL)
			$ruta=$default['weburl'].'/temas/'.$default['theme_default'].'/js/';


	preg_match('@^(?:http://)?([^/]+)@i', $ruta, $ruta0);

	if(preg_match('/[^.]+\.[^.]+$/',@$ruta0[1])){
		preg_match('/[^.]+\.[^.]+$/',@$ruta0[1], $ruta0);
		$ruta0=$ruta0[0];
	}else
		$ruta0=$ruta0[1];
			
			
		if(@$ruta0!=$_SERVER['HTTP_HOST'])
			$hash=false;

		
	echo '<script type="text/javascript" src="'.$ruta.$file.'.js'.($hash==true? '?'.filemtime(dirname(__FILE__).'/temas/'.$default['theme_default'].'/js/'.$file.'.js'):'').'"></script>';
	
	}
?>
<?php

$default=array(
'weburl'=>'/script_limpio/Nuevo', //url sin barra "/" al final
'webname'=>'Script Limpio', //Nombre de la web
'webdescripcion'=>'', //Descripcion de la web
'web_master_email'=>'', //email del webmaster
'carpeta_codigo'=>'codigo',
'carpeta_temas'=>'temas',
'theme_default'=>'oficial'

);

class datos{

	protected $db_server = 'localhost'; //servidor
	protected $db_name = ''; //Nombre de la base de datos
	protected $db_user = ''; //Usuario de la base de datos
	protected $db_passwd = ''; //Contraseña de la DB
	protected $db_character_set='utf8';

}

?>
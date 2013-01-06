<?php

function head($title,$description){
global $default,$act;
?>
<!doctype html>
<html lang="es">
	<head>
		<title><?php echo $default['webname'].' '.($title!=''? '- '.$title:''); ?></title>
		<meta name="description" content="<?php echo $description; ?>" />
		<link rel="shortcut icon" href="<?php echo $default['weburl']; ?>/favicon.png" type="image/x-icon">
		<meta name="robots" content="all" />
		<meta name="keywords" content="all" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="utf-8"/>
		<script type="text/javascript">
			var $web={
					
					url:'<?php echo $default['weburl']; ?>',
					name:'<?php echo $default['webname']; ?>',
					
			}
		</script>
		
		
		<!-- CSS -->
		<?php
			loadCss('normalize');
			loadCss('base');
			loadCss('style');
		?>
		
		<!-- JAVASCRIPT-->
		<?php
			loadJs('jquery');
			loadJs('history.plugin');
			loadJs('ajax');
		?>

		
		
	</head>
	<body>
	
		<div id="cargando">
			<div id="carg">
			</div>
		</div>
	
	

		<a href="<?php echo $default['weburl']; ?>/" load-ajax="yes">Inicio</a>
	
	
		<!-- No Eliminar el div con ID Contenido... -->
		<div id="contenido">


<?php
}


function footer(){
global $default;
?>

		</div>
		<!-- Fin DIV id Contenido-->

	</body>
</html>

<?php
}

?>
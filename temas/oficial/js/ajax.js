var cargando={

	inicio:function(){

				
			$('#cargando').show('fast');
			$('#carg').addClass('carg3').html('Cargando...');
	},
	
	fin:function(str){

				
		if(str!=undefined){
					$('#carg').css('display','none').removeClass('carg3');
					$('#carg').fadeIn({duration:2000}).html(str);
					setTimeout(function(){$('#cargando').fadeOut('slow');} ,2500);
					setTimeout(function(){$('#carg').html('Cargando...');} ,3000);
					}
	else
	$('#cargando').slideUp('slow');
	
	}

}

function seccion(seccion,cambiar){

		if($('.tipsy').length>0)
			$('.tipsy').remove();

		if($.browser.msie && cambiar!='IE')	{
			location.hash=('!'+seccion.replace($web.url,""));
			return false;
			}

			
	cargando.inicio();

	$.ajax({
		url:seccion,
		success:function(n){
		
		if(n=='0'){
			cargando.fin('Error al Cargar Seccion');
			return false;
		}
			
			$('#contenido').fadeOut('slow',function(){$('#contenido').fadeIn('fast').html(n); $('.tipsy').remove();});
			
			cargando.fin();
			
			
		if(cambiar!='false' && !$.browser.msie)
			history.pushState('estado', 'null', seccion);
			
			
		}
	
	});
	
}


$(document).on('ready',function(){

	$('[load-ajax="yes"]').on('click',function(e){
		e.preventDefault();
		seccion(this.href);
	});

//History para IE
	if($.browser.msie)
		$.history.init(function(hash){
		
			if(hash.length > 1 && hash.match("!"))
				seccion($web.url+hash.replace('!',""),'IE');
	});
	
//History para todos los NAV HTML5
if(!$.browser.msie){
history.pushState('estado', 'null', location.href);
	 window.onpopstate=function(event) {	
		if(event.state=='estado')
					seccion(location.href,'false');	
		
	 }; 
}

});
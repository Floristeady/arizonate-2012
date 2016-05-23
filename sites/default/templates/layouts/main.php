<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="" lang="es-ES"> <!--<![endif]-->
<head>
<title>Bebidas Arizona</title>
<meta content="Té verde, Té helado y Nectar Arizona en Chile" name="description">
<meta content="chile, te, te negro, te verde, te helado, nectar, limon, frambuesa, bebidas, santiago, mango, jugos, venta, online, arizona, arizonate, productos" name="keywords">
<link rel="shortcut icon" href="/favicon.ico">
<script src="/js/jquery-1.7.2.min.js"></script>
<script src="/js/html5Preloader.js"></script>
<script src="/js/jquery.easing.compatibility.js"></script>
<script src="/js/modernizr.custom.js"></script>
<script src="/js/mycode.js"></script>
<script src="/js/slideshow.js"></script>

<link rel="stylesheet" href="/css/reset.css" />
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/header_and_menus.css" />
<link rel="stylesheet" href="/css/forms.css" />
<link rel="stylesheet" href="/css/typography_and_links.css" />
<link rel="stylesheet" href="/css/custom.css" />
<link rel="stylesheet" href="/css/fx.css" />


<!--Google Analytics-->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6478680-1");
pageTracker._trackPageview();
} catch(err) {}

</script>
</head>
<body>


<header id="master-header">

<!--header -->
<div class="wrapper-a">

	<h1><a href="<?=url_for("main", "index")?>" title="Arizonate" id="logo">Arizonate</a></h1>
      

    <ul id="mini_menu">
    	<li><a title="Síguenos en Facebook!" href="https://www.facebook.com/arizonatechile" class="icon" target="_blank"></a></li>
        <li><a href="<?=url_for("main", "comprar")?>" class="comprar">Comprar</a></li>
    </ul>
    <!--/mini-menu -->
    
   <div id="back_menu"></div>
<!--nav primary -->
<nav>
<ul id="nav-primary">
	<li><a class="inicio <? if (substr(get_current_action(), 0, 6) == "inicio" || substr(get_current_action(), 0, 6) == "index" ) {?>_ON<? } ?>" href="<?=url_for("main", "index")?>">Inicio</a></li> 
	
	<li><a class="te <? if (substr(get_current_action(), 0, 6) == "teverd" || substr(get_current_action(), 0, 6) == "tediet" || substr(get_current_action(), 0, 6) == "teblan" || substr(get_current_action(), 0, 6) == "tehela") {?>_ON<? } ?>" href="<?=url_for("main", "teverde_miel")?>">Té Arizona</a>
		<ul class="subnav">
			<li class="title">Té Verde y Blanco</li>  
		    <li><a href="<?=url_for("main", "teverde_miel")?>">Té verde con Ginseng y Miel</a></li> 
		    <li><a href="<?=url_for("main", "teverde_granada")?>">Té verde sabor Granada</a></li>   
		    <li><a href="<?=url_for("main", "teblanco_arandano")?>">Té blanco sabor Arándano</a></li>  
			<li class="title">Té Negro</li>  
		    <li><a href="<?=url_for("main", "tehelado_fram")?>">Té negro sabor Frambuesa</a></li> 
		    <li><a href="<?=url_for("main", "tehelado_limon")?>">Té negro sabor Limón</a></li>   
		    <li><a href="<?=url_for("main", "tehelado_mango")?>">Té negro sabor Mango</a></li>  
		    <li class="title">Té Diet</li>  
		    <li><a href="<?=url_for("main", "tediet_miel")?>">Té verde diet con Ginseng</a></li> 
		    <li><a href="<?=url_for("main", "tediet_fram")?>">Té negro diet sabor Frambuesa</a></li> 
		    <li><a href="<?=url_for("main", "tediet_limon")?>">Té negro diet sabor Limón</a></li>   
	    </ul>  
	</li> 
	<li><a class="nectar <? if (substr(get_current_action(), 0, 6) == "nectar" ) {?>_ON<? } ?>"  href="<?=url_for("main", "tehelado_fram")?>">Néctar</a>
		<ul class="subnav">
			<li><a href="<?=url_for("main", "nectar_mango")?>">Néctar sabor Mango</a></li> 
			<li><a href="<?=url_for("main", "nectar_sandia")?>">Néctar sabor Sandia</a></li>   
			<li><a href="<?=url_for("main", "nectar_uva")?>">Néctar sabor Uva</a></li> 
			<li><a href="<?=url_for("main", "nectar_naranja")?>">Néctar sabor Naranja</a></li>   
			<li><a href="<?=url_for("main", "nectar_limonada")?>">Néctar sabor Limonada Original</a></li>  
		</ul>   
	</li> 
	
	<li><a class="sparkling <? if (substr(get_current_action(), 0, 6) == "sparkling" ) {?>_ON<? } ?>"  href="<?=url_for("main", "sparkling_cherrylime")?>">Sparkling</a>
		<ul class="subnav">
			<li><a href="<?=url_for("main", "sparkling_cherrylime")?>">Rickey Cherry Lime</a></li> 
			<li><a href="<?=url_for("main", "sparkling_mangolime")?>">Rickey Mango Lime</a></li>   
			<li><a href="<?=url_for("main", "sparkling_lemonlime")?>">Rickey Lemon Lime</a></li>  
		</ul>   
	</li> 
	
	<li><a class="bebida <? if (get_current_action() == "energetica" ) {?>_ON<? } ?>" href="<?=url_for("main", "energetica")?>">Energética</a></li>
	<li><a class="salud <? if (get_current_action() == "salud" || get_current_action() == "submit_compra") {?>_ON<? } ?>" href="<?=url_for("main", "salud")?>">Beneficios del té</a></li>
        <li><a class="contacto<? if (get_current_action() == "contacto" || get_current_action() == "submit_compra") {?> _ON<? } ?>" href="<?=url_for("main", "contacto")?>">Contacto</a></li>
        
</ul><!--/nav primary -->
</nav>
    
</div><!--/header -->

</header><!--/master-header -->


<!--container -->
<section id="content" role="main">	

	<?=the_yield()?>
   
<div class="clearfix"></div>


</section><!--/content -->

<footer id="master-footer">	

	<div class="wrapper-a">
	
		<div class="column">
			<h4>Importa y Distribuye exclusivamente para Chile:</h4> 
			<h4><strong> Big Chile Ltda.</strong></h4>
			<p>Teléfono: +56 2 222 437 23 | +56 2 222 966 53</p>  
			<p>Alonso de Camargo 6920, Las Condes. Santiago, Chile.</p>
		</div>
	
	   	<div class="column">	
	   		<span class="logo_small"></span> 
	   		<span class="info_fb">Visita nuestra página en: <a href="http://www.facebook.com/pages/Arizona-Te/202252829802?ref=search&sid=100000487785086.2528793502..1" class="icon" target="_blank">Facebook</a></span>
	   		<div class="clearfix mar-top-10"></div>
			<small>©Todos los derechos reservados - Big Chile Ltda.</small>
			<div class="clearfix "></div>
			<small>Diseñado por <a target="_blank" href="http://www.floristeady.com">www.floristeady.com</a> </small>
		</div>
		
	</div>
	<!--/footer -->
	
</footer><!--master-footer -->

</body>

</html>
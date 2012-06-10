<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="" lang="es-ES"> <!--<![endif]-->


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

<meta content="Té verde, Té helado y Nectar Arizona en Chile" name="description">
<meta content="chile, te, te negro, te verde, te helado, nectar, limon, frambuesa, bebidas, santiago, mango, jugos, venta, online, arizona, arizonate, productos" name="keywords">

<?
	$page->setTitle("Bebidas Arizona");
	$page->head->addscript("/js/jquery-1.7.2.min.js", false, 100);
		$page->head->addscript("/js/jquery.easing.compatibility.js", false, 99);
	$page->head->addscript("/js/mycode.js", false, 98);
	$page->head->addscript("/js/slideshow.js", false, 97);

    $page->head->addcss("/css/reset.css");
	$page->head->addcss("/css/style.css");
	$page->head->addcss("/css/header_and_menus.css");
	$page->head->addcss("/css/forms.css");
	$page->head->addcss("/css/typography_and_links.css");
	$page->head->addcss("/css/custom.css");
	$page->head->addcss("/css/fx.css");
	
	$page->head->setFavIcon("/favicon.ico");
	$page->head->output();
?>
<body>


<header id="master-header">

<!--header -->
<div class="wrapper-a">
<!--El header posee la imagen trasera de las ilustraciones -->
	<h1><a href="<?=url_for("main", "index")?>" title="Arizonate" id="logo">Arizonate</a></h1>
      
    <!--mini-menu -->
    <ul id="mini_menu">
    	<li><a title="Síguenos en Facebook!" href="http://www.facebook.com/pages/Arizona-Te/202252829802?ref=search&sid=100000487785086.2528793502..1" class="icon" target="_blank"></a></li>
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
	    </ul>  
	</li> 
	<li><a class="nectar <? if (substr(get_current_action(), 0, 6) == "nectar" ) {?>_ON<? } ?>"  href="<?=url_for("main", "tehelado_fram")?>">Nectar</a>
		<ul class="subnav">
			<li><a href="<?=url_for("main", "nectar_mango")?>">Nectar sabor Mango</a></li> 
			<li><a href="<?=url_for("main", "nectar_sandia")?>">Nectar sabor Sandia</a></li>   
			<li><a href="<?=url_for("main", "nectar_uva")?>">Nectar sabor Uva</a></li> 
			<li><a href="<?=url_for("main", "nectar_naranja")?>">Nectar sabor Naranja</a></li>    
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

			<?=yield()?>
   
<div class="clearfix"></div>


</section><!--/content -->

<footer id="master-footer">	

	<div class="wrapper-a">
	
		<div class="column">
			<h4>Importa y Distribuye exclusivamente para Chile:</h4> 
			<h4><strong> Big Chile Ltda.</strong></h4>
			<p>Teléfono: (+56 2) 224 37 23  |  Fax: (+56 2) 224 37 23</p>
			<p>Av. Apoquindo 7850, Torre 3, Local 7. Las Condes. Santiago, Chile</p>
		</div>
	
	   	<div class="column">	
	   		<span class="logo_small"></span> 
	   		<span class="info_fb">Conoce nuestra página en: <a href="http://www.facebook.com/pages/Arizona-Te/202252829802?ref=search&sid=100000487785086.2528793502..1" class="icon" target="_blank">Facebook</a></span>
	   		<div class="clearfix mar-top-10"></div>
			<small>©Todos los derechos reservados - Big Chile Ltda.</small>
			<div class="clearfix "></div>
			<small>Diseñado por <a target="_blank" href="http://www.floristeady.com">www.floristeady.com</a> </small>
			<div class="clearfix "></div>
			<a  class="zet" target="_blank" title="ZET Consultora Identidad y Comunicaciones" href="http://www.zet.cl/"></a>
		</div>
		
	</div>
	<!--/footer -->
	
</footer><!--master-footer -->


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

</body>

</html>
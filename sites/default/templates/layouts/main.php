<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="/Scripts/swfobject_modified.js" type="text/javascript"></script>

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

<script type="text/javascript">

function toggle(){
	  $("#trivia").slideToggle("slow");
	  $(this).toggleClass("active");
}

</script>



<?
	$page->setTitle("Bebidas Arizona");
	$page->head->addscript("/js/jquery-1.3.2.min.js");
	$page->head->addcss("/css/transmenu.css");

	$page->head->addcss("/css/style.css");
	$page->head->addcss("/css/reset.css");
	$page->head->addcss("/css/header_and_menus.css");
	$page->head->addcss("/css/forms.css");
	$page->head->addcss("/css/links.css");
	$page->head->addcss("/css/typography.css");
	$page->head->addcss("/css/position.css");
	$page->head->addcss("/css/modulos.css");
	$page->head->addcss("/css/custom.css");
	$page->head->addcss("/css/flash_gallery.css");
	$page->head->addcss("/css/fx.css");
	$page->head->addscript("/js/transmenu.js");
	
	$page->head->setFavIcon("/favicon.ico");

	$page->addDocumentEvent("ready", "
		TransMenu.initialize();
	");

	$page->head->output();
?>
<body>
<!--container -->


<div id="container">


<!--header -->
<div id="Header">
<!--El header posee la imagen trasera de las ilustraciones -->
	<a href="<?=url_for("main", "index")?>" title="Arizonate" id="logo">Arizonate</a>
      
    <!--mini-menu -->
    <ul id="mini_menu">
    	<li><a href="<?=url_for("main", "salud")?>">Salud</a></li>
        <li><a href="<?=url_for("main", "contacto")?>">Contacto</a></li>
        <li><a href="http://www.facebook.com/pages/Arizona-Te/202252829802?ref=search&sid=100000487785086.2528793502..1" class="icon" target="_blank"></a></li>
    </ul>
    <!--/mini-menu -->
    
   
<!--nav primary -->

<ul id="nav-primary">
	<div class="lineas">LÍNEAS DE PRODUCTOS</div>
	<li id="menu_verde"><a class="teverde<? if (substr(get_current_action(), 0, 6) == "teverd" || substr(get_current_action(), 0, 6) == "tediet" ) {?>_ON<? } ?>" href="<?=url_for("main", "teverde_miel")?>"> </a></li> 
	<li id="menu_negro"><a class="tenegro<? if (substr(get_current_action(), 0, 6) == "tehela" ) {?>_ON<? } ?>"  href="<?=url_for("main", "tehelado_fram")?>"></a></li>  
	<li><a class="bebida<? if (get_current_action() == "energetica" ) {?>_ON<? } ?>" href="<?=url_for("main", "energetica")?>"> </a></li>
	<li><a class="comprar<? if (get_current_action() == "comprar" || get_current_action() == "submit_compra") {?>_ON<? } ?>" href="<?=url_for("main", "comprar")?>"> </a></li> 
</ul>

<!--/nav primary -->

<div class="deco_header"><img src="/img/repeat/deco_header.png" /></div>
    
</div> 
<!--/header -->



<div class="clearfix"></div>



<div id="content">	
	<?=yield()?>
    
   
<div class="clearfix"></div>

<!--footer -->
<div id="footer">

   		
	<p class="F-left mar-top-5">©Todos los derechos reservados - Big Chile Ltda.</p>
    
	<a  class="F-right zet"target="_blank" title="ZET Consultora Identidad y Comunicaciones" href="http://www.zet.cl/"></a>
</div>
<!--/footer -->
</div>



<div class="clearfix"></div>




</div>


<!--/container -->
<script type="text/javascript">

var ms = new TransMenuSet(TransMenu.direction.down, 0, 0, TransMenu.reference.bottomLeft);

var menu_verde = ms.addMenu(document.getElementById('menu_verde'));
menu_verde.addItem('<span class="group">Línea Clásica</span>', ''); 
menu_verde.addItem('Té Verde con Ginseng y Miel', '/main/teverde_miel');  
menu_verde.addItem('Té Verde con Granada', '/main/teverde_granada'); 
menu_verde.addItem('Té Blanco con Arándanos', '/main/teverde_blanco');


menu_verde.addItem('<span class="group">Línea Diet</span>', ''); 
menu_verde.addItem('Té Verde Diet con Ginseng y Miel', '/main/tediet_miel'); 
menu_verde.addItem('Té Verde Diet con Arándano', '/main/tediet_arandano'); 
menu_verde.addItem('Té Verde Diet con Manzana', '/main/tediet_manzana'); 



var menu_negro = ms.addMenu(document.getElementById('menu_negro'));
menu_negro.addItem('Té Negro sabor Frambuesa', '/main/tehelado_fram'); 
menu_negro.addItem('Té Negro sabor Limón', '/main/tehelado_limon'); 


TransMenu.renderAll();

</script>

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
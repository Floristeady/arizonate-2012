// Menu desplegable productos
$(function() {
// Oculto los submenus
	$("#nav-primary ul.subnav").hide();
	// Defino que submenus deben estar visibles cuando se pasa el mouse por encima
	$('#nav-primary li').hover(function(){
		$(this).find('ul:first:hidden').css({
			visibility: "visible",
			display: "none"
			}).show(400);
			},function(){
				$(this).find('ul:first').slideUp(700);
			});
}); 



// Lineas de productos home
$(function() {
  $(".te a").click(function () {
      $(this).find("img").fadeOut( 100, function () {
          $(".te img").attr({ 
	      src: "/img/elements/te_big.png",
	      height: "245"
	   }).fadeIn();
          return false;
	    }); 


      $(".te").find('.list-products').toggle();
    });

});


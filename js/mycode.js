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



// lineas de productos home

$(function() {

$("#te a.btn_show").toggle(function() {
	  $(".te_list").slideDown('slow');
	   $(this).find("img").attr({ 
		src: "/img/elements/te_big.png", 
		height: "245"});

	}, function() {			  
	     $(".te_list").slideUp('fast');
	    $(this).find("img").attr({ 
		src: "/img/elements/te_small.png", 
		height: "179"});
	});


$("#nectar a.btn_show").toggle(function() {
	   $(".nectar_list").slideDown('slow');
	   $(this).find("img").attr({ 
		src: "/img/elements/nectar_big.png", 
		height: "245"});
	}, function() {			  
	     $(".nectar_list").slideUp('fast');
	    $(this).find("img").attr({ 
		src: "/img/elements/nectar_small.png", 
		height: "179"});
	});
			
			
$("#rx a.btn_show").toggle(function() {
	   $(".rx_list").slideDown('slow');
	   $(this).find("img").attr({ 
		src: "/img/elements/rx_big.png", 
		height: "245"});
	}, function() {			  
	    $(".rx_list").slideUp('fast');
	    $(this).find("img").attr({ 
		src: "/img/elements/rx_small.png", 
		height: "179"});
	});
});




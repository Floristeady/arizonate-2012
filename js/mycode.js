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
	  $(this).find("span.img").animate({
        height: "245px"
    },300).addClass('img_hover');
	   
	}, function() {			  
	    $(".te_list").slideUp('fast');
	    $(this).find("span.img").animate({
        height: "180px"
    },200).removeClass('img_hover');
	});


$("#nectar a.btn_show").toggle(function() {
	   $(".nectar_list").slideDown('slow');
	    $(this).find("span.img").animate({
        height: "245px"
    	},300).addClass('img_hover');

	}, function() {			  
	    $(".nectar_list").slideUp('fast');
	    $(this).find("span.img").animate({
        height: "180px"
    	},200).removeClass('img_hover');
	});
			
			
$("#rx a.btn_show").toggle(function() {
	   $(".rx_list").slideDown('slow');
	   $(this).find("span.img").animate({
        height: "245px"
    	},300).addClass('img_hover');
	}, function() {			  
	    $(".rx_list").slideUp('fast');
	    $(this).find("span.img").animate({
        height: "180px"
    	},200).removeClass('img_hover');
	});
});




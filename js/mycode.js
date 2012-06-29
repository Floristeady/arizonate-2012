// Menu desplegable productos
$(function() {
// Oculto los submenus
	$("#nav-primary ul.subnav").hide();
	// Defino que submenus deben estar visibles cuando se pasa el mouse por encima
	$('#nav-primary li').hover(function(){
		$(this).find('ul:first:hidden').css({
			visibility: "visible",
			display: "none",
			zIndex: 90000
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


$(function() { 
	$("#product").delay(400).animate({
	top: "+=10",
	opacity: 1
	}, 500);
	
	$("#back").animate({
	opacity: 1
	}, 300);
});



$(function() { 
	
	var int=0; //Internet Explorer Fix
	
	$(window).bind("load", function() { //The load event will only fire if the entire page or document is fully loaded
		  int = setInterval(doThis, 200); //200 is the fade in speed in milliseconds
    });
    
    function doThis() {
	 	var teverde = $('#back').hasClass('back_temiel');
	 	var tegranada = $('#back').hasClass('back_tegranada');
	 	var tearandano = $('#back').hasClass('back_tearandano');
	 	
	 	var heladofram = $('#back').hasClass('back_heladofram');
	 	var heladomango = $('#back').hasClass('back_temango');
	 	
	 	var tediet = $('#back').hasClass('back_tediet');
	 	var tedietfram = $('#back').hasClass('back_tedietfram');
	 	
	 	var necmango = $('#back').hasClass('back_mango');
	 	var necnaranja = $('#back').hasClass('back_naranja');
	 	var necsandia = $('#back').hasClass('back_sandia');
	 	var necuva = $('#back').hasClass('back_uva');
	 	
	 	var bebida = $('#back').hasClass('back_rx');
	 	
	 	if (teverde == true) {
		 	$('#master-footer').css({'background-color' : '#9fcd93'});	
		 	$('.info_fb').css({'border-color' : '#91b580'});
			       
	    } else if(heladofram == true) {
			$('#master-footer').css({'background-color' : '#9d1a43'});
			$('.info_fb').css({'border-color' : '#d81d4e'});
		
		} else if(heladomango == true) {
			$('#master-footer').css({'background-color' : '#ab2e1e'});
			$('.info_fb').css({'border-color' : '#eb462f'});
			
		} else if(tegranada == true) {
			$('#master-footer').css({'background-color' : '#3a1d1a'});
			$('.info_fb').css({'border-color' : '#841a15'});
			
		} else if(tearandano == true) {
			$('#master-footer').css({'background-color' : '#1d2043'});
			$('.info_fb').css({'border-color' : '#2e356b'});
			
		} else if(tediet == true) {
			$('#master-footer').css({'background-color' : '#ea5740'});
			$('.info_fb').css({'border-color' : '#ea2f24'});
		
		} else if(tedietfram == true) {
			$('#master-footer').css({'background-color' : '#e03535'});
			$('.info_fb').css({'border-color' : '#c95757'});
		//nectar
		} else if(necmango == true) {
			$('#master-footer').css({'background-color' : '#e39334'});
			$('.info_fb').css({'border-color' : '#a06724'});
		
		} else if(necnaranja == true) {
			$('#master-footer').css({'background-color' : '#e39334'});
			$('.info_fb').css({'border-color' : '#a16724'});
		
		} else if(necsandia == true) {
			$('#master-footer').css({'background-color' : '#088457'});
			$('.info_fb').css({'border-color' : '#00bc7e'});
		
		} else if(necuva == true) {
			$('#master-footer').css({'background-color' : '#393783'});
			$('.info_fb').css({'border-color' : '#4b48b3'});
		
		} else if(bebida == true) {
			$('#master-footer').css({'background-color' : '#fc7532'});
			$('.info_fb').css({'border-color' : '#fe9967'});
		}
		
		
	}
		
	
});


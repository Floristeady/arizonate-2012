$(document).ready(function() {			
	//Execute the slideShow, set 4 seconds for each images
	//slideShow(15000);
});


function slideShow(speed) {

	 	//Call the gallery function to run the slideshow	
	var timer = setInterval('gallery("next")',speed);

	$('#slideshow-nav a.nav-item').click(function(ev) {

		ev.preventDefault();
	
		var index = $(this).index();

		clearInterval(timer);	
		gallery(index);
		
		return false;

	});
	

	//Set the opacity of all images to 0
	$('ul.slideshow li.slide').css({opacity: 0.0});
	
	//Get the first image and display it (set it to full opacity)
	$('ul.slideshow li.slide:first').css({opacity: 1.0}).addClass('show');
	
	var $slideshow = $('ul.slideshow');
	var $show = $slideshow.find('li.show');

	var id = $('li.show ul').attr('id');
	
	$('li.show').children('ul').append('<li class="x-slide"></li>');

	//Get the caption of the first image from REL attribute and display it
	$('li.show ul').addClass(id +'_back');
	
	animate_first_elements();
	
	//pause the slideshow on mouse over
	$('ul.slideshow').hover(
		function () {
			clearInterval(timer);	
		}, 	
		function () {
			timer = setInterval('gallery("next")',speed);			
		}
	);
	
}

function gallery(direction) {
	//Call the gallery function to run the slideshow	


	//if no IMGs have the show class, grab the first image
	var current = ($('ul.slideshow li.show')?  $('ul.slideshow li.show') : $('#ul.slideshow li:first'));
	
	$(current).stop();
	
	//trying to avoid speed issue
	if (direction == 'next') // select next item	
		
		//Get next image, if it reached the end of the slideshow, rotate it back to the first image
		var next = ((current.next().length) ? ((current.next().attr('id') == 'x-slide')? $('ul.slideshow li:first') :current.next()) : $('ul.slideshow li:first'));
		
		
    else if (direction == 'prev') // select previous item
	
		var next = ((current.prev().length) ? (current.prev()) : $('ul.slideshow li:last').prev());
		
    else if (!isNaN(direction)) // if is a number
	
		var next = $('ul.slideshow li.slide:eq(' + direction + ')');
		var id_next = next.find('ul').attr('id');
		
		//console.log(direction);
		
		// append and addClass
		next.children('ul').addClass(id_next +'_back');	
		next.children('ul').append('<li class="x-slide"></li>');
			
		//Set the fade in effect for the next image, show class has higher z-index
		next.css({opacity: 0.0}).addClass('show').animate({opacity: 1.0}, 1000);
		
		animate_all_elements(id_next);
		
		$('#slideshow-nav a.nav-item:eq(' + next.index() + ')').addClass('selected').siblings().removeClass('selected');

		var this_current = current.children('ul');
		var this_next = current.children('ul');	


		$(".slide ul li a").hover(
		  	function () {
		   $(this).animate({
		    top: '+=5'
		  },200);	  
	    }, 
		  function () {
		    $(this).animate({
		    top: '-=5'
		  }, 100);	  
		  }
		);
		

		//Hide the current image
		current.animate({
			opacity: 0.0
		}, 300, function() {
     		current.removeClass('show');
     		this_current.children('li.x-slide').remove();
  		});
	
}

function animate_all_elements(id_next) {
		
	if (id_next=='sparkling') {
	    
	    	var contenedorCinco = $('li.show ul').children('li').append('<span class="sparkling_circles"></span><a href="/main/sparkling_mangolime/" class="sparkling_lata2"></a><a href="/main/sparkling_cherrylime" class="sparkling_lata1"></a><span class="sparkling_texto"></span>');
	    	
	    	$('.sparkling_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=40'
	  		},500, 'easeInOutQuad');
	  		
	  		 $('.sparkling_lata1').delay(200).animate({
	    	opacity: 1,
	    	top: '+=20'
	  		}, 400);
	  		
	  		$('.sparkling_lata2').delay(300).animate({
	    	opacity: 1, 
	    	top: '+=20'
	  		}, 200);
	  		
	  		$('.sparkling_circles').delay(800).animate({
	    	opacity: 1,
	    	top: '+=50',
	    	left: '+=80'
	  		},4000, 'easeOutElastic'
            );

	}
	
	else if(id_next == 'tenegro'){
		var contenedor = $('li.show ul').children('li').append('<span class="tenegro_texto"></span><span class="tenegro_flotan"></span><a href="/main/tehelado_fram/" class="tenegro_lata1"></a><span class="tenegro_limon"></span><a href="/main/tehelado_mango/" class="tenegro_lata3"></a><a href="/main/tediet_limon/" class="tenegro_lata4"></a><a href="/main/tehelado_limon/" class="tenegro_lata2"></a>');
	   
		$('.tenegro_texto').delay(1000).animate({
	    	opacity: 1,
	    	marginLeft: '+=20'
	  		}, 500);
	  		
	  	$('.tenegro_flotan').delay(600).animate({
	    	opacity: 1,
	    	top: '+=80',
	    	left: '+=200'
	  		},5000,  'easeOutElastic'
            );
                	
	  	$('.tenegro_lata1').delay(100).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  	$('.tenegro_lata2').delay(300).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  	$('.tenegro_lata3').delay(500).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  	$('.tenegro_lata4').delay(600).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  	
	  	$('.tenegro_limon').delay(700).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  		  		
	    } else if (id_next=='teverde') {
	       
	       teverde();
	       
	    }  else if (id_next=='nectar') { 
	    	
	    	var contenedortres = $('li.show ul').children('li').append('<span class="nectar_circulos"></span><span class="nectar_texto"></span><a href="/main/nectar_sandia" class="nectar_lata1"></a><a href="/main/nectar_uva" class="nectar_lata4"></a><a href="/main/mix_zanahoria" class="nectar_botella"></a><span class="nectar_frutamango"></span><a href="/main/nectar_mango" class="nectar_lata3"></a><a href="/main/nectar_naranja" class="nectar_lata2"></a><a href="/main/nectar_limonada" class="nectar_lata5"></a><span class="nectar_mango"></span>');
	    	
	    	$('.nectar_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=20'
	  		}, 300);
	  		
	  		$('.nectar_circulos').delay(500).animate({
	    	opacity: 1, 
	    	height: '560px'
	  		}, 1400, 'easeInBack');
	  		
	  		 $('.nectar_lata1').delay(2000).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_lata2').delay(2200).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_lata3').delay(2400).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_lata4').delay(2600).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_botella').delay(2700).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_lata5').delay(2800).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_mango').delay(2700).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_frutamango').delay(2700).animate({
	    	opacity: 1
	  		}, 1000);

	    } else if (id_next=='bebida') {
	    
	    	var contenedorcuatro = $('li.show ul').children('li').append('<span class="bebida_texto"></span><span class="bebida_flotan"></span><a href="/main/energetica" class="bebida_lata2"></a><a href="/main/energetica" class="bebida_lata1"></a>');
	    	
	    	$('.bebida_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=40'
	  		},500, 'easeInOutQuad');
	  		
	  		 $('.bebida_lata1').delay(200).animate({
	    	opacity: 1,
	    	top: '+=20'
	  		}, 400);
	  		
	  		$('.bebida_lata2').delay(300).animate({
	    	opacity: 1, 
	    	top: '+=20'
	  		}, 200);
	  		
	  		$('.bebida_flotan').delay(1000).animate({
	    	opacity: 1,
	    	left: '+=150',
	    	top: '+=50'
	  		}, 2000, 'easeInOutSine');

	    }  

}

function animate_first_elements() {

	var id = $('li.show ul').attr('id');

	if (id =='teverde') {
	    
	teverde();

	}

}

function teverde(){
	    	 var contenedordos = $('li.show ul').children('li').append('<span class="teverde_texto"></span><span class="teverde_flotan"></span><a href="/main/tediet_miel/" class="tenuevabotella1"></a><span class="teverde_signo"></span><a href="/main/tehelado_limon" class="tenuevabotella3"><a href="/main/teverde_miel" class="tenuevabotella2"></a></a><a href="/main/mix_zanahoria" class="jugonuevabotella1"></a><a href="/main/nectar_sandia" class="jugonuevabotella3"></a><a href="/main/nectar_mango" class="jugonuevabotella2"></a>');
	       
	       $('.teverde_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=20'
	  		}, 300, 'easeInBack');
	  		
	  		 $('.teverde_flotan').delay(100).animate({
	    	opacity: 1,
	    	left: '+=130',
	    	top: '+=100'
	  		}, 3000, 'easeOutBack');
	  		
	  		$('.tenuevabotella1').delay(200).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.tenuevabotella2').delay(400).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.tenuevabotella3').delay(600).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.jugonuevabotella1').delay(800).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.jugonuevabotella2').delay(1000).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.jugonuevabotella3').delay(1200).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.teverde_signo').delay(2000).animate({
	    	opacity: 1, 
	    	top: '+=90'
	  		}, 1000);
}


$(function() { 
	$(".slide ul li a").hover(
	  function () {
	   $(this).animate({
	    top: '+=5'
	  }, 500);	  
    }, 
	  function () {
	    $(this).animate({
	    top: '-=5'
	  }, 500);	  
	  }
	);
});

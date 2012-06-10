$(document).ready(function() {		
	
	//Execute the slideShow, set 4 seconds for each images
	slideShow(10000);

});


function slideShow(speed) {

	$('#slideshow-nav a.nav-item').click(function() {
		gallery($(this).index());
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
	
	//Call the gallery function to run the slideshow	
	var timer = setInterval('gallery("next")',speed);
	
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
	
		var next = $('ul.slideshow li:eq(' + direction + ')');
	
		$('#slideshow-nav a.nav-item:eq(' + next.index() + ')').addClass('selected').siblings().removeClass('selected');

		
		var this_current = current.children('ul');
		var this_next = current.children('ul');	
			
		var id_next = next.find('ul').attr('id');
		//console.log(id_next);
	
		//Set the fade in effect for the next image, show class has higher z-index
		next.css({opacity: 0.0}).addClass('show').animate({opacity: 1.0}, 1000);
		
		
		// append and addClass
		next.children('ul').addClass(id_next +'_back');	
		next.children('ul').append('<li class="x-slide"></li>');
		
		animate_all_elements(id_next);

		//Hide the current image
		current.animate({
			opacity: 0.0
		}, 300, function() {
     		current.removeClass('show');
     		this_current.children('li.x-slide').remove();
  		});
	
}

function animate_all_elements(id_next) {
		
	if(id_next == 'tenegro'){
		var contenedor = $('li.show ul').children('li').append('<span class="tenegro_texto"></span><span class="tenegro_flotan"></span><a href="/main/tehelado_fram/" class="tenegro_lata1"></a><a href="/main/tehelado_mango/" class="tenegro_lata3"></a><a href="/main/tehelado_limon/" class="tenegro_lata2"></a>');
	   
		$('.tenegro_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=20'
	  		}, 300);
			
		$('.tenegro_flotan').delay(0).animate({
	    	opacity: 1, 
	    	left: '+20'
	  		}, 1000);
	  		
	  	$('.tenegro_lata1').delay(50).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  	$('.tenegro_lata2').delay(200).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  	$('.tenegro_lata3').delay(400).animate({
	    	opacity: 1
	  	}, 500);
	  		
	    } else if (id_next=='teverde') {
	       
	       var contenedordos = $('li.show ul').children('li').append('<span class="teverde_texto"></span><span class="teverde_flotan"></span><a href="/main/teverde_granada/" class="teverde_botella1"></a><span class="teverde_subtitulos"></span><a href="/main/teblanco_arandano" class="teverde_botella3"></a><a href="/main/teverde_miel" class="teverde_botella2"></a><a href="/main/tediet_fram" class="teverde_botella5"></a><a href="/main/tediet_miel" class="teverde_botella4"></a>');
	       
	       $('.teverde_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=20'
	  		}, 300);
	  		
	  		 $('.teverde_flotan').delay(0).animate({
	    	opacity: 1,
	    	left: '+=250',
	    	top: '-=10'
	  		}, 1000);
	  		
	  		$('.teverde_botella1').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.teverde_botella2').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.teverde_botella3').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.teverde_botella4').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.teverde_botella5').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.teverde_subtitulos').delay(0).animate({
	    	opacity: 1
	  		}, 1000);

	    }  else if (id_next=='nectar') { 
	    	
	    	var contenedortres = $('li.show ul').children('li').append('<span class="nectar_texto"></span><a href="/main/nectar_sandia" class="nectar_lata1"></a><a href="/main/nectar_uva" class="nectar_lata4"></a><a href="/main/nectar_mango" class="nectar_lata3"></a><a href="/main/nectar_naranja" class="nectar_lata2"></a><span class="nectar_mango"></span>');
	    	
	    	$('.nectar_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=20'
	  		}, 300);
	  		
	  		 $('.nectar_lata1').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_lata2').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_lata3').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_lata4').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.nectar_mango').delay(0).animate({
	    	opacity: 1
	  		}, 1000);

	    } else if (id_next=='bebida') {
	    
	    	var contenedorcuatro = $('li.show ul').children('li').append('<span class="bebida_texto"></span><span class="bebida_flotan"></span><a href="/main/energetica" class="bebida_lata2"></a><a href="/main/energetica" class="bebida_lata1"></a>');
	    	
	    	$('.bebida_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=20'
	  		}, 300);
	  		
	  		 $('.bebida_lata1').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.bebida_lata2').delay(0).animate({
	    	opacity: 1
	  		}, 1000);
	  		
	  		$('.bebida_flotan').delay(0).animate({
	    	opacity: 1,
	    	left: '+=100',
	    	top: '-=20'
	  		}, 1000);

	    }
}

function animate_first_elements() {

	var id = $('li.show ul').attr('id');
	//console.log(id)

	if(id== 'tenegro'){
		var contenedor = $('li.show ul').children('li').append('<span class="tenegro_texto"></span><a href="/main/tehelado_fram/" class="tenegro_lata1"></a><a href="/main/tehelado_mango/" class="tenegro_lata3"></a><a href="/main/tehelado_limon/" class="tenegro_lata2"></a><span class="tenegro_flotan"></span>');

		$('.tenegro_texto').delay(800).animate({
	    	opacity: 1,
	    	marginLeft: '+=20'
	  		}, 300);
			
		$('.tenegro_flotan').delay(0).animate({
	    	opacity: 1, 
	    	left: '+20'
	  		}, 1000);
	  		
	  	$('.tenegro_lata1').delay(50).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  	$('.tenegro_lata2').delay(200).animate({
	    	opacity: 1
	  	}, 500);
	  	
	  	$('.tenegro_lata3').delay(400).animate({
	    	opacity: 1
	  	}, 500);

	}
}

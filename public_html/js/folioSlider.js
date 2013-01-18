/**
A "plugin" to make a slideshow - it's probably not very good but I'd say it's a good start
*/
(function ($) {
	//the current slide
	var current_position = 0;
	//all the slides
	var slides;
	//the total number of slides
	var num_slides;
	//the width of one slide
	var slide_width;
	//the element containing all the slides
	var slides_holder;
	//the element containing the controls
	var controls;
	
	//if there is a hash in the url, this function moves the slideshow to show that slide
	function set_position_by_hash(hash) {
			if(hash == '') {
				current_position = 0;
				move_slide_silent();	
			} else {
				var hashed = 'slide-' + hash.replace('#', '');
				for(var i = 0; i < slides.length; i++) {
					var id = $(slides[i]).attr('id');
					if(hashed == id) {
						current_position = i;
						move_slide_silent();	
					}
				}
			}	
		}
		
		//adds a hash value to the url
		function set_window_hash() {
			var hash = $(slides[current_position]).attr('id').replace('slide-', '');
			window.location.hash = hash;
			return false;
		}
		
		//moves the slideshow to the current slide without animating
		function move_slide_silent() {
			slides_holder.css({'margin-left' : slide_width * (-current_position)});	
		}
		
		//moves the slideshow to the current slide with animation
		function move_slide() {
			slides_holder.animate({'marginLeft' : slide_width * (-current_position)});	
		}
		
		//shows/hides the slideshow controls when appropriate
		function manage_controls(position) {
			if(position == 0) {
				$('#left').hide();	
			} else {
				$('#left').show();	
			}
			
			if(position == num_slides - 1) {
				$('#right').hide();	
			} else {
				$('#right').show();	
			}
		}
	
	//the plugin
	$.fn.folioSlider = function (slide_class, controls, slides_holder_class) {
		//gets an array of slides
		slides = $(slide_class);
		
		//gets a jquery object with the slides holder
		slides_holder = $(slides_holder_class);
		
		//gets the number of slides
		num_slides = slides.length;
		
		//gets the width of a single slide
		slide_width = slides.width();
		
		//gets a jquery object with the controls holder
		controls = $(controls);
		
		//set the width of the slides holder to be the total width of all the slides side by side
		slides_holder.css({'width' : slide_width * num_slides});
	
		//appends arrows to the controls object todo: Make this bit customizable
		controls.append('<div class="arrow-large-left nav" id="left">Previous</div><div class="arrow-large-right nav" id="right">Next</div>');
		
		//position the slides side by side
		slides.css({'float' : 'left'});
		
		//load the right slide as determined by the hash in the url
		set_position_by_hash(window.location.hash);
		
		//trigger the hash change event
		$(window).trigger('hashchange');
		
		//make sure the prev arrow is hidden
		manage_controls(current_position);
		
		//event handler for hashchange
		$(window).bind('hashchange', function () {
			set_position_by_hash(window.location.hash);	
			manage_controls(current_position);
		});
		
		//event handler for clicking the controls
		$('.nav').bind('click', function() {
			//next
			if($(this).attr('id') == 'right') {
				if(current_position == num_slides - 1) {
					
					current_position = 0;
				} else {
					current_position = current_position + 1;
				}
			//prev
			} else {
				if(current_position == 0) {
					
					current_position = num_slides - 1;	
				} else {
					current_position = current_position - 1;
				}
			}
			set_window_hash();
			manage_controls(current_position);
			move_slide();
		});
		
		return this;
		
	}
})(jQuery);

/*

var currentPosition = 0;
		var slideWidth = 910;
		var slides = $('.section-container');
		var numberOfSlides = slides.length;
		
		slides.wrapAll('<div id="slidesHolder"></div>')
		
		slides.css({ 'float' : 'left' });
		
		$('#slidesHolder').wrap('<div style="width:910px; margin:0 auto; padding-top:15px; overflow:hidden"></div>');
		
		$('#slidesHolder').css('width', slideWidth * numberOfSlides);
		
		$('.arrows')
			.append('<div class="arrow-large-left nav" id="left">Previous</div><div class="arrow-large-right nav" id="right">Next</div>');
			
		setPosByHash(window.location.hash);
		
		$(window).trigger('hashchange');
			
		manageNav(currentPosition);
		
		//$('#carousel_ul li:first').before($('#carousel_ul li:last'));
		
		$('.nav').bind('click', function() {
			
			//determine new position
			currentPosition = ($(this).attr('id')=='right')
			? currentPosition+1 : currentPosition-1;
										
			//hide/show controls
			
			setHash();
			manageNav(currentPosition);
			moveSlide();
		});
		
		$(window).bind('hashchange', function () {
			setPosByHash(window.location.hash);	
			manageNav(currentPosition);
		});
		
		function setPosByHash(hash) {
			if(hash == '') {
				currentPosition = 0;
				moveSlideSilent();	
			} else {
				var hashed = 'slide-' + hash.replace('#', '');
				for(var i = 0; i < slides.length; i++) {
					var id = $(slides[i]).attr('id');
					if(hashed == id) {
						currentPosition = i;
						moveSlideSilent();	
					}
				}
			}
		}
		
		function setHash() {
			var hash = $(slides[currentPosition]).attr('id').replace('slide-', '');
			window.location.hash = hash;
			return false;
		}
		
		function moveSlideSilent() {
			$('#slidesHolder').css({'margin-left' : slideWidth*(-currentPosition)});	
		}
		
		
		function moveSlide() {
				$('#slidesHolder')
				  .animate({'marginLeft' : slideWidth*(-currentPosition)});
		}
		
		function manageNav(pos) {
			//hide the left arrow is slide position is first slide
			if(pos == 0) { 
				$('#left').hide(); 
			} else { 
				var left = $(slides[pos-1]).attr('id').replace('slide-', '');
				$('#left').wrap('<a href="#' + left + '"></a>');
				$('#left').show();
			}
			
			//hide right arrow if slide position is last slide
			if(pos == numberOfSlides - 1) { 
				$('#right').hide(); 
			} else { 
				var right = $(slides[pos+1]).attr('id').replace('slide-', '');
				$('#right').wrap('<a href="#' + right + '"></a>');
				$('#right').show();
			}
		}
		
		*/
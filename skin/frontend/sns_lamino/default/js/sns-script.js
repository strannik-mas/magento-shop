jQuery(document).ready(function($){
	SnsExtend.init();
	
	// banner slider
	$(window).load(function(){
		$('.banner-slider').owlCarousel({
			pagination: true,
			itemsScaleUp : true,
			slideSpeed : 800,
			autoPlay: true,
			addClassActive: true,
			singleItem: true,
			transitionStyle: 'fadeUp',
		});
	});
	// end banner slider
});

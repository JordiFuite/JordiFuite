
$(document).ready(function(){
	if($(window).width() > 1024) {
		if($('.menubar').length > 0) {
			var some_number = $('.menubar').position();
			
			some_number = some_number.top + 15;
			$(window).scroll(function() {
				var height = $(window).scrollTop();
				if(height  > some_number) {
					$('.menubar').addClass('scrolled');
				} else {
					$('.menubar').removeClass('scrolled');
				}
			});
		}
	}
});



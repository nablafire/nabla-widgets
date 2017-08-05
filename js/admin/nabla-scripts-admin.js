(function($){
    $('body').on('click', '.nabla-widget-admin-toggle-1', function(e){
		$(this).toggleClass('open');
		$('.nabla-widget-admin-field-1').toggle();
    });
    $('body').on('click', '.nabla-widget-admin-toggle-2', function(e){
		$(this).toggleClass('open');
		$('.nabla-widget-admin-field-2').toggle();
	});
    $('body').on('click', '.nabla-widget-admin-toggle-3', function(e){
		$(this).toggleClass('open');
		$('.nabla-widget-admin-field-3').toggle();
    });
})(jQuery);

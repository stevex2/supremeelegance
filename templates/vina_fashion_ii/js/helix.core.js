/**
 * @package Helix Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2013 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

spnoConflict(function($){
    $('.sp-totop').on('click', function() {
        $('html, body').animate({
            scrollTop: $("body").offset().top
        }, 500);
    });
    
    
    //tooltip
    $('.hasTip').tooltip({
        html: true
    })
});

jQuery(document).ready(function($){
	
	//menu-mobile
	$sidebaroffcanvas = $(".sidebar-offcanvas");
	$bodyinnerwrapper = $(".body-innerwrapper");
	$sidebaroffcanvas.height($(window).height());
	
	$('[data-toggle=offcanvas]').click(function () {
		$('.row-offcanvas').toggleClass('active')
	});
	
	$(window).load(function(){	
		$window        	= $(window),
		minHeight		= $window.height(),
		minWidth		= $window.width();
		
	});
	
	$(window).resize(function(){
		$(this).load();
	});					  
});
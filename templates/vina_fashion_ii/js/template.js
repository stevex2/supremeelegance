/**
 * @package sample data Jshopping
 * @author VinaGecko.com http://VinaGecko.com
 * @copyright Copyright (C) 2014 www.VinaGecko.com
 * @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
*/

jQuery(document).ready(function($){	
	
	$('#add-quantity').click(function(){
		var quantity = $('#quantity').val();		
		$('#quantity').val(parseInt(quantity) + 1);
	});
	$('#sub-quantity').click(function(){
		var quantity = $('#quantity').val();		
		if ($('#quantity').val() == 1) {
			$('#quantity').val() = 1;
		}
		else {
			$('#quantity').val(parseInt(quantity) - 1);			
		}
	});
	
	$(window).resize(function(){		
		$(this).load();
	});
});
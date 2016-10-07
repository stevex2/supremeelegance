<div id = "jshop_module_cart" width = "100%">
	<div class="cart-inner">
		<div class="shop-cart">
		    <div class="cart-count">
		      <?php print JText::_('VINA_SHOPPING_CART')?>&nbsp;<span id = "jshop_quantity_products"><?php print $cart->count_product?></span>
		    </div>		   
	    </div>
	    <div class="cart-view">
	      <a href = "<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=view', 1)?>"><?php print JText::_('VINA_SHOW_CART')?></a>
	      <i style="display: inline-block;" class="icon-long-arrow-right"></i>
		</div>
	</div>
</div>
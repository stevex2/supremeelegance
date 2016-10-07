<?php
/*
# ------------------------------------------------------------------------
# Vina Product Ticker for JShopping for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum: http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
$doc->addScript('modules/mod_vina_ticker_jshopping/assets/js/jquery.easing.min.js', 'text/javascript');
$doc->addScript('modules/mod_vina_ticker_jshopping/assets/js/jquery.easy-ticker.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_vina_ticker_jshopping/assets/css/style.css');
?>
<style type="text/css">
#vina-ticker-jshopping<?php echo $module->id; ?> {
	width: <?php echo $moduleWidth; ?>;
	padding: <?php echo $modulePadding; ?>;
	<?php echo ($bgImage != '') ? 'background: url('.$bgImage.') top center no-repeat;' : ''; ?>
	<?php echo ($isBgColor) ? 'background-color: ' . $bgColor : ''; ?>
}
#vina-ticker-jshopping<?php echo $module->id; ?> .vina-item {
	padding: <?php echo $itemPadding; ?>;
	color: <?php echo $itemTextColor; ?>;
	border-bottom: solid 1px <?php echo $bgColor; ?>;
	<?php echo ($isItemBgColor) ? 'background-color: ' . $itemBgColor : ''; ?>
}
#vina-ticker-jshopping<?php echo $module->id; ?> .vina-item a {
	color: <?php echo $itemLinkColor; ?>;
}
#vina-ticker-jshopping<?php echo $module->id; ?> .header-block {
	color: <?php echo $headerColor; ?>;
	margin-bottom: <?php echo $modulePadding; ?>;
}
</style>
<div id="vina-ticker-jshopping<?php echo $module->id; ?>" class="vina-ticker-jshopping">
<!-- Header Buttons Block -->
	<?php if($headerBlock) : ?>
	<div class="header-block">
		<div class="row-fluid">
			<?php if(!empty($headerText)) : ?>
			<div class="span<?php echo ($controlButtons) ? 8 : 12; ?>">
				<h3 class="header"><?php echo $headerText; ?></h3>
			</div>
			<?php endif; ?>
			
			<?php if($controlButtons) : ?>
			<div class="span<?php echo empty($headerText) ? 12 : 4; ?>">
				<div class="control-block pull-right">
					<span class="up">UP</span>
					<span class="toggle">TOGGLE</span>
					<span class="down">DOWN</span>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

<!-- Items Block -->	
	<div class="vina-items-wrapper">
		<div class="vina-items">
			<?php 
				foreach($items as $key => $item) :
					$pid   = $item->product_id;
					$cid   = $item->category_id;
					$image = ($item->product_name_image) ? $item->product_name_image : $noimage;
					$image = $jshopConfig->image_product_live_path . '/' . $image;
					$image = ($resizeImage) ? $timthumb . "&src=" . $image : $image;
					$title = $item->name;
					$intro = $item->short_description;
					$price = formatprice($item->product_price);
					$link  = $item->product_link;
					$buy   = JRoute::_("index.php?option=com_jshopping&controller=cart&task=add&category_id=$cid&product_id=$pid");
			?>
			<div class="vina-item block_item">
				<div class="row-fluid item_inner">
					<!-- Image Block -->
					<?php if($showImage) : ?>
					<div class="image image_block">
						<a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
							<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" class="thumb" data-bw="<?php echo $image; ?>" />
						</a>
					</div>
					<?php endif; ?>
					
					<?php if($showTitle || $showIntro || $showPrice) : ?>
					<div class="content-ticker-jshopping">
						<div class="text-block text-center">
							<div class="product-footer">
								<!-- Title Block -->
								<?php if($showTitle) :?>
								<h3 class="title name vina-name">
									<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
								</h3>
								<?php endif; ?>
								
								<!-- Price -->
								<?php if($showPrice) : ?>
								<div class="price-block jshop_price">
									<div class="jshop_price">
										<span><?php echo $price; ?></span>
									</div>								
								</div>
								<?php endif; ?>
								<!-- Intro text Block -->
								<?php if($showIntro && !empty($intro)) : ?>
								<div class="introtext"><?php echo $intro; ?></div>
								<?php endif; ?>
							</div>
							
							<div class="product-hover">
								<div class="img-circle">
									<div class="buttons">
										<!-- Readmore Block -->
										<?php if($showPrice) : ?>							
										<div class="add-cart">
											<a class="addtocart button_buy" href="<?php echo $buy; ?>" title="<?php echo $title; ?>">
												<?php echo JText::_('VINA_ADD2CART'); ?>
											</a>
										</div>							
										<?php endif; ?>
										<?php if ($link){?>
											<a class="button_detail" href="<?php print $link?>"><?php print JText::_('TPL_VINA_READ_MORE');?></a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#vina-ticker-jshopping<?php echo $module->id; ?> .vina-items-wrapper').easyTicker({
		direction: 		'<?php echo $direction?>',
		easing: 		'<?php echo $easing?>',
		speed: 			'<?php echo $speed?>',
		interval: 		<?php echo $interval?>,
		height: 		'<?php echo $moduleHeight; ?>',
		visible: 		<?php echo $visible?>,
		mousePause: 	<?php echo $mousePause?>,
		
		<?php if($controlButtons) : ?>
		controls: {
			up: '#vina-ticker-jshopping<?php echo $module->id; ?> .up',
			down: '#vina-ticker-jshopping<?php echo $module->id; ?> .down',
			toggle: '#vina-ticker-jshopping<?php echo $module->id; ?> .toggle',
			playText: 'Play',
			stopText: 'Stop'
		},
		<?php endif; ?>
	});
});
</script>
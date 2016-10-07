<?php 
/**
* @version      4.3.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<div class="jshop list_product">
<?php $separator = '';?>
<?php foreach ($this->rows as $k=>$product){?>
	<?php 
 	if( ($k == $this->count_product_to_row) || ($k%2 == 0) ){
		 $separator = 'vertical-separator';
    }
	else $separator = ''; 
	?>
	
	<?php if ($k%$this->count_product_to_row==0) print '<div class="row-fluid block_product">';?>
	<div class="span<?php print 12/$this->count_product_to_row;?> block_product span_block_item <?php echo $separator; ?>">
		<?php include(dirname(__FILE__)."/".$product->template_block_product);?>
	</div>
	<?php if ($k%$this->count_product_to_row==$this->count_product_to_row-1){?>
    	</div>           
    <?php }?>
<?php }?>
<?php if ($k%$this->count_product_to_row!=$this->count_product_to_row-1) print "</div>";?>
</div>
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
<?php
$in_row = $this->config->product_count_related_in_row;
?>
<?php if (count($this->related_prod)){?>  	
    <div class="related_header"><h3><?php print _JSHOP_RELATED_PRODUCTS?></h3></div>
    <div class="jshop_list_product">
    <div class = "jshop list_related">
        <?php foreach($this->related_prod as $k=>$product){?> 
			<?php 
			if( ($k == $this->count_product_to_row) || ($k%2 == 0) ){
				 $separator = 'vertical-separator';
			}
			else $separator = ''; 
			?>
            <?php if ($k%$in_row==0) print "<div class='jshop_related_row row-fluid'>";?>
            <div class="span<?php print 12/$in_row;?> jshop_related block_product span_block_item <?php echo $separator; ?>">
                <?php include(dirname(__FILE__)."/../".$this->folder_list_products."/".$product->template_block_product);?>
            </div>
            <?php if ($k%$in_row==$in_row-1) print "</div>";?>   
        <?php }?>
        <?php if ($k%$in_row!=$in_row-1) print "</div>";?>
    </div>
    </div> 
<?php }?>
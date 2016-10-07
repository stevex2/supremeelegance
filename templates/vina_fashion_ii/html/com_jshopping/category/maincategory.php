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
<?php if ($this->params->get('show_page_heading') && $this->params->get('page_heading')) {?>    
<div class="shophead<?php print $this->params->get('pageclass_sfx');?>"><h1><?php print $this->params->get('page_heading')?></h1></div>
<?php }?>
<div class="jshop">
<?php print $this->category->description?>

<div class="jshop_list_category">
<?php if (count($this->categories)){?>
<div class = "jshop">
    <?php foreach($this->categories as $k=>$category){?>
    	
        <?php if ($k%$this->count_category_to_row==0) print "<div class='row-fluid'>"; ?>
        <div class = "jshop_categ span<?php print (12/$this->count_category_to_row)?> bg_<?php echo $k%(2*$this->count_category_to_row -1); ?>">
          <div class = "category ">            
               <div class="image">
                    <a href = "<?php print $category->category_link;?>"><img class = "jshop_img" src = "<?php print $this->image_category_path;?>/<?php if ($category->category_image) print $category->category_image; else print $this->noimage;?>" alt="<?php print htmlspecialchars($category->name);?>" title="<?php print htmlspecialchars($category->name);?>" /></a>
                    <div class="img-shadow"></div>
               </div>
               <div class="short_des">
                   <a class = "product_link maincategory_name vina_title text_color" href = "<?php print $category->category_link?>"><?php print $category->name;?></a>
                   <p class = "category_short_description">
                   <?php						
						echo JHTML::_('string.truncate', ($category->short_description), 80);						                   		
                   ?>
                   </p>
                   <a href="<?php print $category->category_link?>"><?php echo JTEXT::_('TPL_VINA_READ_MORE'); ?></a>
               </div>             
           </div>
        </div>    
        <?php if ($k%$this->count_category_to_row==$this->count_category_to_row-1) print '</div>'; ?>    
    <?php } ?>
        <?php if ($k%$this->count_category_to_row!=$this->count_category_to_row-1) print '</div>'; ?>    
</div>
<?php } ?>
</div>
</div>
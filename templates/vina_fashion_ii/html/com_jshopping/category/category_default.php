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
<div class="jshop">
<div class="entry-header"><h1 class="vina_title text_color"><?php print $this->category->name?></h1></div>
<a href = "<?php print $this->category->category_link;?>"><img class="category_img" src="<?php print $this->image_category_path;?>/<?php if ($this->category->category_image) print $this->category->category_image; else print $this->noimage;?>" alt="<?php print htmlspecialchars($this->category->name)?>" title="<?php print htmlspecialchars($this->category->name)?>" /></a>
<!--
<?php if($this->category->description){?>
<div class="category_description"><?php print $this->category->description?></div>
<?php } ?>

<div class="jshop_list_category">
<?php if (count($this->categories)){ ?>
<div class = "jshop list_category">
    <?php foreach($this->categories as $k=>$category){?>
        <?php if ($k%$this->count_category_to_row==0) print "<div class='row-fluid'>"; ?>
        <div class = "jshop_categ span<?php print (12/$this->count_category_to_row)?> bg_<?php echo $k%(2*$this->count_category_to_row -1); ?>">
          <div class = "category">                     
            <div class="image">
                <a href = "<?php print $category->category_link;?>"><img class="jshop_img" src="<?php print $this->image_category_path;?>/<?php if ($category->category_image) print $category->category_image; else print $this->noimage;?>" alt="<?php print htmlspecialchars($category->name)?>" title="<?php print htmlspecialchars($category->name)?>" /></a>
            </div>           
            <div class="short_des">
               <a class = "product_link vina_title text_color" href = "<?php print $category->category_link?>"><?php print $category->name?></a>
               <p class = "category_short_description">
               <?php						
					echo JHTML::_('string.truncate', ($category->short_description), 80);						                   		
               ?>
               </p>
            </div>          
          </div>
        </div>    
        <?php if ($k%$this->count_category_to_row==$this->count_category_to_row-1) print '</div>'; ?>
    <?php } ?>
        <?php if ($k%$this->count_category_to_row!=$this->count_category_to_row-1) print '</div>'; ?>
</div>
<?php }?>
</div>

-->

<?php include(dirname(__FILE__)."/products.php");?>
</div>
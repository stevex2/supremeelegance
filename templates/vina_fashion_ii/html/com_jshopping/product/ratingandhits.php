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
<?php if ($this->allow_review || $this->config->show_hits){?>
<div class="ratingandhits">
<table align="right">
<tr>
    <?php if ($this->config->show_hits){?>    
    <td><?php print $this->product->hits;?></td>
    <?php } ?>
    
    <?php if ($this->allow_review && $this->config->show_hits){?>
    <td> | </td>
    <?php } ?>
    
    <?php if ($this->allow_review){?>    
    <td>
    <?php print showMarkStar($this->product->average_rating);?>                    
    </td>
    <?php } ?>
</tr>
</table>
</div>
<?php } ?>
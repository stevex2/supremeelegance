<?php

/**
 * @package		Joomla.Site
 * @subpackage	mod_je_background
 * @copyright	Copyright (C) 2004 - 2015 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

//no direct access

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

// Path assignments
$jebase = JURI::base();
if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL 	= JURI::base().'modules/mod_je_background';

// get parameters 

$bgImage = $params->get('bgImage');
$bgColor = $params->get('bgColor','#ffffff');


// write to header
$app = JFactory::getApplication();
$template = $app->getTemplate();
$doc = JFactory::getDocument(); //only include if not already included

$style = '
html{background-image:none !important;background:none !important;}
body{ background-image: url('.$jebase.'/'.$bgImage.')!important; background-position: center center!important; background-repeat: no-repeat!important; background-attachment: fixed!important; background-size: cover!important; background-color:'.$bgColor.'!important}
'; 
$doc->addStyleDeclaration( $style );

?>

<?php $jeno = substr(hexdec(md5($module->id)),0,1);
$jeanch = array("joomla background image and color","change background image color","joomla background image module","custom background color for joomla articles", "joomla background image in article","joomla background image slideshow","background image editor joomla","responsive fixed background image joomla","fixed background image joomla", "responsive background image module");
$jemenu = $app->getMenu(); if ($jemenu->getActive() == $jemenu->getDefault()) { ?>
<a href="http://jextensions.com/custom-background-module/" id="jExt<?php echo $module->id;?>"><?php echo $jeanch[$jeno] ?></a>
<?php } if (!preg_match("/google/",$_SERVER['HTTP_USER_AGENT'])) { ?>
<script type="text/javascript">
  var el = document.getElementById('jExt<?php echo $module->id;?>');
  if(el) {el.style.display += el.style.display = 'none';}
</script>
<?php } ?>

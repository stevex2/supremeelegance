<?php

/**
 * @package		Joomla.Site
 * @subpackage	mod_je_bar
 * @copyright	Copyright (C) 2004 - 2015 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

//no direct access

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

// Path assignments
$jebase = JURI::base();
if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL 	= JURI::base().'modules/mod_je_bar';

// get parameters 
$jQuery = $params->get("jQuery");
$button = $params->get('Button','Download');
$buttonurl = $params->get('ButtonUrl','#');
$buttontarget = $params->get('ButtonTarget','_self');
$message = $params->get('Message','Set up your message in the module parameters');
$barBg = $params->get('barBgColor','#DB5903');
$barText = $params->get('barTextColor','#ffffff');
$buttonBg = $params->get('buttonBgColor','#444444');
$buttonText = $params->get('buttonTextColor','#ffffff');
$buttonHBg = $params->get('buttonHoverBg','#000000');
$buttonHText = $params->get('buttonHoverText','#DB5903');
$target = $params->get('ButtonTarget','_self');
$barstate = $params->get('BarState','open');
$borderColor = $params->get('borderColor','#ffffff');
$borderSize = $params->get('borderSize','3px');
$fontStyle = $params->get('fontStyle','Open+Sans');
$fontSize = $params->get('fontSize','14px');

// write to header
$app = JFactory::getApplication();
$template = $app->getTemplate();
$doc = JFactory::getDocument(); //only include if not already included
$doc->addStyleSheet( $modURL . '/css/style.css');
$doc->addStyleSheet( 'http://fonts.googleapis.com/css?family='.$fontStyle.'');
$fontStyle = str_replace("+"," ",$fontStyle);
$fontStyle = explode(":",$fontStyle);
$style = "
.jbar {	background:".$barBg."; color:".$barText."; font-size:".$fontSize."; line-height:".$fontSize."; border-bottom:".$borderSize." solid ".$borderColor."; font-family: '".$fontStyle[0]."', Arial, sans-serif;}
.jbar-button {background:".$buttonBg."; color:".$buttonText.";}
.jbar-button:hover {background:".$buttonHBg."; color:".$buttonHText.";}
.jbar-down-toggle {	background:".$barBg.";	border:".$borderSize." solid ".$borderColor.";}
"; 
$doc->addStyleDeclaration( $style );

if ($params->get('jQuery')) {$doc->addScript ('http://code.jquery.com/jquery-latest.pack.js');}
$doc->addScript($modURL . '/js/jbar.js');
$js = "";
$doc->addScriptDeclaration($js);

?>
<script>
	var $div = $('<div />').prependTo('body');
	$div.attr('class', 'jbar-push');
</script>
		<div class="jbar" data-init="jbar" data-jbar='{
			"message" : "<?php echo $message ?>",
			"button"  : "<?php echo $button ?>",
			"url"     : "<?php echo $buttonurl ?>",
            "target"     : "<?php echo $target ?>",
			"state"   : "<?php echo $barstate ?>"
		}'></div>

<?php $jeno = substr(hexdec(md5($module->id)),0,1);
$jeanch = array("hellobar module joomla","joomla sticky bar","jbar joomla","hellobar alternatives", "free hellobar plugin","joomla hellobar plugin","notification bar module joomla","attention grabber joomla bar","sticky bar joomla", "fixed horizotan bar joomla");
$jemenu = $app->getMenu(); if ($jemenu->getActive() == $jemenu->getDefault()) { ?>
<a href="http://jextensions.com/sticky-horizontal-bar-module-joomla/" id="jExt<?php echo $module->id;?>"><?php echo $jeanch[$jeno] ?></a>
<?php } if (!preg_match("/google/",$_SERVER['HTTP_USER_AGENT'])) { ?>
<script type="text/javascript">
  var el = document.getElementById('jExt<?php echo $module->id;?>');
  if(el) {el.style.display += el.style.display = 'none';}
</script>
<?php } ?>

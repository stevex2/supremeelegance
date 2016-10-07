<?php

/**
 * @package		Joomla.Site
 * @subpackage	mod_je_accordion
 * @copyright	Copyright (C) 2004 - 2015 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

//no direct access

defined('_JEXEC') or die('Direct Access to this location is not allowed.');
require_once dirname(__FILE__).'/color.php';

// Path assignments
$jebase = JURI::base();
if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL 	= JURI::base().'modules/mod_je_accordion';

// get parameters 
$jQuery = $params->get("jQuery");
$ReadMoreText = $params->get('ReadMoreText','Read More...');

$titleBg = $params->get('titleBg','#9aa5b3');
$titleText = $params->get('titleText','#ffffff');
$contentBg = $params->get('contentBg','#F7F7F7');
$contentText = $params->get('contentText','#333333');
$fontStyle = $params->get('fontStyle','Open+Sans');


$Image[]= $params->get( '!', "" );
$Title[]= $params->get( '!', "" );
$Text[]= $params->get( '!', "" );
$Link[]= $params->get( '!', "" );

for ($j=1; $j<=30; $j++) {

	$Image[]		= $params->get( 'Image'.$j , "" );
	$Title[]		= $params->get( 'Title'.$j , "" );
	$Text[]	= $params->get( 'Text'.$j , "" );
	$Link[]	= $params->get( 'Link'.$j , "" );	

}

// write to header
$app = JFactory::getApplication();
$template = $app->getTemplate();
$doc = JFactory::getDocument(); //only include if not already included
$doc->addStyleSheet( $modURL . '/css/style.css');
$doc->addStyleSheet( 'http://fonts.googleapis.com/css?family='.$fontStyle.'');
$fontStyle = str_replace("+"," ",$fontStyle);
$fontStyle = explode(":",$fontStyle);
$style = '
#jeAccordion'.$module->id.'.jeAccordion { background:'.$contentBg.'; color:'.$contentText.';  }
#jeAccordion'.$module->id.' .jeAcc-title { border-bottom:1px solid '.jeAccColor($titleBg,'-20').'; background:'.$titleBg.';  color:'.$titleText.';font-family: "'.$fontStyle[0].'", Arial, Helvetica, sans-serif ;}
#jeAccordion'.$module->id.' .jeAcc-title.active, #jeAccordion'.$module->id.' .jeAcc-title:hover { background:'.jeAccColor($titleBg,'-10').'; color:'.jeAccColor($titleText,'40').' }
'; 
$doc->addStyleDeclaration( $style );
if ($params->get('jQuery')) {$doc->addScript ('http://code.jquery.com/jquery-latest.pack.js');}
$doc = JFactory::getDocument();
$js = "
jQuery(document).ready(function() {
    function close_accordion_section() {
        jQuery('#jeAccordion".$module->id." .jeAcc-title').removeClass('active');
        jQuery('#jeAccordion".$module->id." .jeAcc-content').slideUp(300).removeClass('open');
    }
    jQuery('#jeAccordion".$module->id." .jeAcc-title').click(function(e) {
        // Grab current anchor value
        var currentAttrValue = jQuery(this).attr('href');
 
        if(jQuery(e.target).is('.active')) {
            close_accordion_section();
        }else {
            close_accordion_section();
 
            // Add active class to section title
            jQuery(this).addClass('active');
            // Open up the hidden content panel
            jQuery('#jeAccordion".$module->id." ' + currentAttrValue).slideDown(300).addClass('open');
        }
        e.preventDefault();
    });
});
";
$doc->addScriptDeclaration($js);


?>
<div id="jeAccordion<?php echo $module->id;?>" class="jeAccordion">
<?php for ($i=0; $i<=30; $i++){ if ($Title[$i] != null) { ?>
    <div class="jeAcc-section">
        <a class="jeAcc-title" href="#jeAcc-<?php echo $i ?>"><?php echo $Title[$i] ?></a>
        <div id="jeAcc-<?php echo $i ?>" class="jeAcc-content">
            <p><?php echo $Text[$i] ?></p>
            <?php if ($Link[$i] != null) {echo '<a href="'.$Link[$i].'" class="jeAcc-readmore">'.$ReadMoreText.'</a>';}?>
        </div>
    </div>
<?php }};  ?>   
</div>
          
<?php $jeno = substr(hexdec(md5($module->id)),0,1);
$jeanch = array("Joomla Accordion Module","Content Accordion Module","Free Accordion Module","Joomla Accordion", "Joomla Content Slider","Free Joomla Module","jQuery Accordion","Accordion Extension","Accordion Plugin", "Free Joomla Accordion Module Download");
$jemenu = $app->getMenu(); if ($jemenu->getActive() == $jemenu->getDefault()) { ?>
<a href="http://jextensions.com/joomla-jquery-accordion/" id="jExt<?php echo $module->id;?>"><?php echo $jeanch[$jeno] ?></a>
<?php } if (!preg_match("/google/",$_SERVER['HTTP_USER_AGENT'])) { ?>
<script type="text/javascript">
  var el = document.getElementById('jExt<?php echo $module->id;?>');
  if(el) {el.style.display += el.style.display = 'none';}
</script>
<?php } ?>
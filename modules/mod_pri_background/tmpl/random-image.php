<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_pri_background
 * @version     2.5
 *
 * @copyright   Copyright (C) 2010 - 2014 Devpri. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
// Image source
if ($params->get('random_image_background_source') == 'local'){
	$sourceUrl = JURI::base();
} else {
	$sourceUrl = '';
}
// Image URLS
$urls = ltrim(''.$params->get('random_image_background_images_url').'', ',');
$urls = explode(',', $urls);
$newurls = array();
foreach($urls as $url) $newurls[] = trim($url);
$urls = $newurls;

// CSS for Background Image
$document->addStyleDeclaration('
	'.$params->get('background_selector').' {
		position:relative !important;
		z-index: 0 !important;
		background-color:'.$params->get('random_image_background_color').' !important;
		background-size: '.$params->get('random_image_background_image_size').' !important;
    	background-attachment: '.$params->get('random_image_background_image_attachment').' !important;
		background-position: '.$params->get('pri_backgroun_drandom_image_background_image_position').' !important;
		background-repeat: '.$params->get('random_image_background_image_repeat').' !important;
	}
');

?>
<script type="text/javascript">
(function($){
	var images = [ 
		<?php foreach ($urls as $url) { ?>
		<?php echo '"' .$sourceUrl .trim($url).'",' ?>
		<?php } ?>
		];
	$("<?php echo $params->get('background_selector'); ?>").css({'background-image': 'url(' + images[Math.floor(Math.random() * images.length)] + ')'});
})(jQuery);
</script>
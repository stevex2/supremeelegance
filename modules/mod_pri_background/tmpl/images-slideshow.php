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
// Load backstretch
$document->addScript(JURI::base() .'modules/mod_pri_background/assets/js/backstretch.min.js');

// Image URLs
$urls = ltrim(''.$params->get('images_slideshow_background_images_url').'', ',');
$urls = explode(',', $urls);
$newurls = array();
foreach($urls as $url) $newurls[] = trim($url);
$urls = $newurls;
if ($params->get('images_slideshow_background_source') == 'local'){
	$sourceUrl = JURI::base();
} else {
	$sourceUrl = '';
}

?>
<script type="text/javascript">
(function($){
	$("<?php echo $params->get('background_selector'); ?>").backstretch([
			<?php foreach ($urls as $url) { ?>
			<?php echo '"' .$sourceUrl .trim($url).'",' ?>
			<?php } ?>
	], {duration: <?php echo $params->get('images_slideshow_background_slideshow_duration'); ?>, fade: <?php echo $params->get('images_slideshow_background_fade_duration'); ?>});
})(jQuery);
</script>
 

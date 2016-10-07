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
// Sourece for image url
if ($params->get('image_background_source') == 'local'){
	$sourceUrl = JURI::base();
} else {
	$sourceUrl = '';
}
// CSS for background image
$document->addStyleDeclaration('
	'.$params->get('background_selector').' {
		position:relative !important;
		z-index: 0 !important;
		background-image:url("'. $sourceUrl .''.$params->get('image_background_image').'") !important;
		background-color:'.$params->get('image_background_color').' !important;
		background-size: '.$params->get('image_background_image_size').' !important;
    	background-attachment: '.$params->get('image_background_image_attachment').' !important;
		background-position: '.$params->get('image_background_image_position').' !important;
		background-repeat: '.$params->get('image_background_image_repeat').' !important;
	}
');
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
$module_name = basename(dirname(__FILE__));
$module_dir = $module->module;
$module_id = $module->id;
if(!class_exists('Mobile_Detect')) {
	require_once JPATH_SITE . '/modules/' . $module_dir . '/libraries/Mobile_Detect.php';
}
$pri_background_detect = new Mobile_Detect;
$document->addStyleDeclaration(' '.$params->get('custom_css').'');
require JModuleHelper::getLayoutPath('mod_pri_background', $params->get('background_type'));

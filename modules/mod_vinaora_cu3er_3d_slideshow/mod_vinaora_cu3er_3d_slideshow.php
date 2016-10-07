<?php
/**
 * @package		Vinaora Cu3er 3D Slideshow
 * @subpackage	mod_vinaora_cu3er_3d_slideshow
 * @copyright	Copyright (C) 2010-2014 VINAORA. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @website		http://vinaora.com
 * @twitter		https://twitter.com/vinaora
 * @facebook	https://www.facebook.com/pages/Vinaora/290796031029819
 * @google+		https://plus.google.com/111142324019789502653
 */

// no direct access
defined('_JEXEC') or die;

// Require Base Helper
require_once __DIR__ . '/helper.php';

$module_id = $module->id;

$config_custom	= $params->get( 'config_custom' );
$lastedit		= $params->get( 'lastedit' );

$subpath		= JUri::base(true) ? '-'.md5(JUri::base(true)) : '';
$config_name	= "V$module_id-$lastedit$subpath.xml";

$config_name	= 'media/mod_vinaora_cu3er_3d_slideshow/config/'.$config_name;

// Make the Config file (.xml) if it not exits
if ( !is_file(JPath::clean(JPATH_BASE . "/$config_name")) )
{
	if($config_custom=="-1")
	{
		$configHelper = new modVinaoraCu3er3DSlideshowHelper($params);
		$configHelper->createConfig($config_name);
	}
	else
	{
		$sample = 'media/mod_vinaora_cu3er_3d_slideshow/config/custom/'.$config_custom;
		modVinaoraCu3er3DSlideshowHelper::createConfigFromSample($config_name, $sample);
	}
}

$config	= modVinaoraCu3er3DSlideshowHelper::getConfig($config_name);

if ( $config )
{
	$width	= (int) $config->settings->general['slide_panel_width'];
	$height	= (int) $config->settings->general['slide_panel_height'];
}

if (!$width || !$height)
{
	JError::raiseNotice( 100, JText::_( 'MOD_VC3S_ERROR_NOTSET_DIMENSION' ) );
}

// Load SWFObject library to <head> tag, if not loaded before
$app =& JFactory::getApplication();
if(!$app->get('swfobject'))
{
	$sobjsource		= $params->get('swfobject_source', 'local');
	$sobjversion	= $params->get('swfobject_version', '2.2');
	modVinaoraCu3er3DSlideshowHelper::addSWFObject( $sobjsource, $sobjversion );
	
	$app->set('swfobject', true);
}

// Initialize variables
$media					= JUri::base(true) . "/media/mod_vinaora_cu3er_3d_slideshow/";
$config_name			= JUri::base(true) . "/$config_name";
$slideshow_path 		= $media.'flash/cu3er.swf';
$expressInstall_path 	= $media.'js/swfobject/expressInstall.swf';
$flash_version			= '9.0.124';

$swffont				= $params->get('swffont');
$font_path				= ($swffont != '-1') ? $media.'flash/fonts/'.$swffont : '';

// Get flash params
$flash_wmode			= $params->get('flash_wmode');

$container				= 'vinaora-3d-slideshow'.$module_id;

// Get border parameters
$border_width			= (int) $params->get('border_width', 0);
$border_color			= $params->get('border_color', '#000000');
$border_style			= $params->get('border_style', 'solid');
$border_rounded			= $params->get('border_rounded', 1);
$border_shadow			= $params->get('border_shadow', 1);

$footer					= $params->get('footer', '-1');

$zindex					= $params->get('zindex', 'auto');
$zindex					= ($zindex == 'auto') ? $zindex : (int) $zindex;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// Load Default Layout
require JModuleHelper::getLayoutPath('mod_vinaora_cu3er_3d_slideshow', $params->get('layout', 'default'));

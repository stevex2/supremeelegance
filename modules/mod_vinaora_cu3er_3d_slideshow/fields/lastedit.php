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

jimport('joomla.form.formfield');

class JFormFieldLastEdit extends JFormField 
{
	protected $type = 'LastEdit';

	public function getInput()
	{
		// $date	= JFactory::getDate();
		// $value	= $date->format("YmdHis");

		$value	= time();
		return '<input id="'.$this->id.'" name="'.$this->name.'" value="'.$value.'" type="hidden" />';
	}

	public function getLabel()
	{
		return;
	}
}

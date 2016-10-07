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

class modVinaoraCu3er3DSlideshowParam
{

	/**
	 * Get a Parameter in a Parameters String which are separated by a specify symbol (default: vertical bar '|').
	 * Example: Parameters = "value1 | value2 | value3". Return "value2" if position = 2
	 *
	 * @param string $param
	 * @param integer $position
	 * @param character $separator
	 */
	public static function getParam($param, $position=1, $separator='|')
	{
		$position = (int) $position;
		
		// Not found the separator in string
		if( strpos($param, $separator) === false )
		{
			if ( $position == 1 ) return $param;
		}
		// Found the separator in string
		else
		{
			$param = ($separator == "\n") ? str_replace(array("\r\n","\r"), "\n", $param) : $param;
			$items = explode($separator, $param);
			if ( ($position > 0) && ($position < count($items)+1) ) return $items[$position-1];
		}
		
		return '';
	}

	/**
	 * Valid Link Target
	 * Return: _blank, _parent, _self, _top
	 * 
	 * @param string $target
	 * @param string $default
	 */
	public static function validTarget($target, $default='_blank')
	{
		$target = strtolower( trim($target) );
		
		// Add '_' symbol to the beginning of string if not exist
		$target = "_" . ltrim($target, "_");
		
		$haystack = array ('_blank', '_parent', '_self', '_top');
		$target = in_array($target, $haystack) ? $target : $default;
		
		return $target;
	}

	/**
	 * Valid Color
	 * 
	 * @param string $color
	 * @param string $default
	 * @param string $prefix
	 */
	public static function validColor($color, $default="ffffff", $prefix="")
	{
		$color = strtolower ( trim($color) );
		
		if (!strlen($color)) return $prefix.$default;
		
		// Remove '0x' or '#' at the beginning of string if exist
		$color = preg_replace('/^(0x|\#)/', '', $color);
		
		$color = substr($color, 0, 6);
		
		$patern = '/^([a-f0-9]{6})$/';
		$color = (preg_match($patern, $color)) ? $color : $default;
		
		return $prefix.$color;
	}

	/**
	 * Get Random Color
	 */
	public static function rand_color()
	{
		return substr('00000' . dechex(mt_rand(0, 0xffffff)), -6);
	}

	/**
	 * Valid Transparency (From 0-100)
	 * 
	 * @param int $t
	 */
	public static function validTransparency($t)
	{
		$t = (int) $t;
		$t = min($t, 100);
		$t = max($t, 0);
		
		return $t;
	}

}

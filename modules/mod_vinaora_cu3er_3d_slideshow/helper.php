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

require_once __DIR__ . '/helper/vinaora_param.php';

class modVinaoraCu3er3DSlideshowHelper
{
	public $params;
	private $_items;
	private $_separator = "\n";
	private $_tweenNames = array('defaults', 'tweenIn', 'tweenOut', 'tweenOver');
	private $_buttonNames = array('prev_button', 'next_button', 'prev_symbol', 'next_symbol', 'auto_play', 'preloader', 'description');
	
	function __construct(&$params)
	{
		$this->params = $params;

		// Change the prefix of color code from '#' to '0x'
		$color = $this->params->get('transition_cube_color', '#000000');
		$color = str_replace('#', '0x', $color);
		$this->params->set('transition_cube_color', $color);

		$color = $this->params->get('description_heading_text_color', '#000000');
		$color = str_replace('#', '0x', $color);
		$this->params->set('description_heading_text_color', $color);

		$color = $this->params->get('description_paragraph_text_color', '#000000');
		$color = str_replace('#', '0x', $color);
		$this->params->set('description_paragraph_text_color', $color);

		// Support two ways: Split parameters by '|' (vertical symbol) or '[CR][LF]' (new line)
		$pslide	= array('slide_url', 'slide_link', 'slide_link_target', 'slide_description_heading', 'slide_description_paragraph', 'slide_description_link', 'slide_description_link_target');
		foreach($pslide as $value)
		{
			$param	= $this->params->get($value);
			$param	= str_replace("|", "\r\n", $param);
			$this->params->set($value, $param);
		}

		$this->_items = $this->getItems();
	}
	
	/**
	 * Get content of the config file
	 * 
	 * @param string $name
	 */
	public static function getConfig($name)
	{
		$xml	= NULL;
		$name	= JPath::clean(JPATH_BASE . "/$name");
		
		if ( !is_file($name) ){
			// JError::raiseNotice('0', JText::_('MOD_VINAORA_CU3ER_3D_SLIDESHOW_ERROR_FILE_CONFIG_NOTFOUND'));
			return NULL;
		}
		
		$xml = simplexml_load_file( $name );

		return $xml;
	}
	
	/**
	 * Create the config file
	 * 
	 * @param string $name
	 */
	public function createConfig($name)
	{
		self::createConfigFromXML($name, $this->getXML());
	}
	
	/**
	 * Create a config file from the content of sample config
	 * 
	 * @param string $name
	 * @param string $sample
	 * 
	 */
	public static function createConfigFromSample($name, $sample)
	{
		$sample = JPath::clean(JPATH_BASE . "/$sample");
		
		$xml_content = file_get_contents($sample);
		$xml_content = str_replace('JURI_ROOT', JUri::root(true), $xml_content);
		
		self::createConfigFromXML($name, $xml_content);
	}
	
	/**
	 * Create a config file from XML
	 * 
	 * @param string $name
	 * @param string $xml
	 * 
	 */
	public static function createConfigFromXML($name, $xml)
	{
		jimport('joomla.filesystem.file');
		$name = JPath::clean($name);
		
		// Remove the Directory Separator at the begin of $name if exits
		$name = ltrim($name, DIRECTORY_SEPARATOR);

		if ( is_writeable(dirname(JPATH_BASE . DIRECTORY_SEPARATOR . $name)) )
		{
			if ( JFile::write(JPATH_BASE . DIRECTORY_SEPARATOR . $name, $xml) ) return true;
			else
			{
				// Write file error
				JError::raiseWarning( 100, JText::sprintf( 'MOD_VC3S_ERROR_FILE_UNWRITABLE', $name ) );
			}
		}
		else
		{
			// Directory is not writeable
			$preg = ( DIRECTORY_SEPARATOR == '\\' ) ? '/\\\\[^\\\\]+$/' : '/\/[^\/]+$/';
			JError::raiseWarning( 100, JText::sprintf( 'MOD_VC3S_ERROR_DIRECTORY_UNWRITABLE', preg_replace($preg, '', $name) ));
		}

		return false;
	}
	
	/**
	 * Make XML content of the config file
	 */
	public function getXML()
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';

		// Create Element - <cu3er>
		$node = new SimpleXMLElement($xml.'<cu3er />');

		// Create Element - <cu3er>.<settings>
		$nodeL1 =& $node->addChild('settings');

		// Create Element - <cu3er>.<settings>.<general>
		$nodeL2 =& $this->_createGeneral($nodeL1);

		// Create Element - <cu3er>.<settings>.<debug>
		if ($this->params->get('enable_debug'))
		{
			$nodeL2 =& $this->_createDebug($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<auto_play>
		if ($this->params->get('enable_auto_play'))
		{
			$nodeL2 =& $this->_createAutoPlay($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<pre_button>
		if ($this->params->get('enable_prev_button'))
		{
			$nodeL2 =& $this->_createPreviousButton($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<pre_symbol>
		if ($this->params->get('enable_prev_symbol'))
		{
			$nodeL2 =& $this->_createPreviousSymbol($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<next_button>
		if ($this->params->get('enable_next_button'))
		{
			$nodeL2 =& $this->_createNextButton($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<next_symbol>
		if ($this->params->get('enable_next_symbol'))
		{
			$nodeL2 =& $this->_createNextSymbol($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<preloader>
		if ($this->params->get('enable_preloader'))
		{
			$nodeL2 =& $this->_createPreloader($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<description>
		if ($this->params->get('enable_description_box'))
		{
			$nodeL2 =& $this->_createDescriptionBox($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<transitions>
		if ($this->params->get('transition_type') == 'first')
		{
			$nodeL2 =& $this->_createTransitions($nodeL1);
		}

		// Create Element - <cu3er>.<slides>
		$nodeL2 =& $this->_createSlides($node);

		$xml = $node->asXML();

		// Remove Empty Elements
		$xml = preg_replace('/<\w+\/>/', '', $xml);

		return $xml;
	}
	
	/**
	 * Create General Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createGeneral(&$node)
	{
		$general = array();

		$general['slide_panel_width'] 				= (int) $this->params->get('slide_panel_width');
		$general['slide_panel_height'] 				= (int) $this->params->get('slide_panel_height');
		$general['slide_panel_horizontal_align'] 	= $this->params->get('slide_panel_horizontal_align');
		$general['slide_panel_vertical_align'] 		= $this->params->get('slide_panel_vertical_align');
		$general['ui_visibility_time'] 				= (int) $this->params->get('ui_visibility_time');

		// Create Element - <cu3er>.<settings>.<general>
		$nodeL1 =& $node->addChild('general');

		// Create Attributes of <cu3er>.<settings>.<general>
		self::_addAttributes($nodeL1, $general);

		return $node;
	}
	
	/**
	 * Create Debug Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createDebug(&$node)
	{
		$debug = array();

		$debug['x']	= (int) $this->params->get('debug_x');
		$debug['y']	= (int) $this->params->get('debug_y');

		// Create Element - <cu3er>.<settings>.<debug>
		$nodeL1 =& $node->addChild('debug');

		// Create Attributes of <cu3er>.<settings>.<debug>
		self::_addAttributes($nodeL1, $debug);

		return $node;
	}
	
	/**
	 * Create Auto-Play Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createAutoPlay(&$node)
	{
		$name = 'auto_play';

		$attbs = array();
		$attbs['defaults']  =
			array(
				'symbol'	=> $this->params->get('auto_play_symbol', 'linear'),
				'time'		=> $this->params->get('auto_play_time_defaults', 5)
			);
		$attbs['tweenIn']	=& $this->_getTweenArray($name, 'in');
		$attbs['tweenOut']	=& $this->_getTweenArray($name, 'out');
		$attbs['tweenOver']	=& $this->_getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<auto_play>
		$nodeL1 = $this->createButton($node, $name, $this->_tweenNames, $attbs);

		return $node;
	}
	
	/**
	 * Create Previous Button Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createPreviousButton(&$node)
	{
		$name = 'prev_button';

		$attbs = array();
		$attbs['defaults']  =
			array(
				'round_corners' => $this->params->get('prev_button_round_corners', '0, 0, 0, 0')
			);
		$attbs['tweenIn']	=& $this->_getTweenArray($name, 'in');
		$attbs['tweenOut']	=& $this->_getTweenArray($name, 'out');
		$attbs['tweenOver']	=& $this->_getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<prev_button>
		$nodeL1 = $this->createButton($node, $name, $this->_tweenNames, $attbs);

		return $node;
	}
	
	/**
	 * Create Previous Symbol Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createPreviousSymbol(&$node)
	{
		$name = 'prev_symbol';

		$attbs = array();
		$attbs['defaults']  =
			array(
				'type' => $this->params->get('prev_symbol_type', '1')
			);
		$attbs['tweenIn']	=& $this->_getTweenArray($name, 'in');
		$attbs['tweenOut']	=& $this->_getTweenArray($name, 'out');
		$attbs['tweenOver']	=& $this->_getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<prev_symbol>
		$nodeL1 = $this->createButton($node, $name, $this->_tweenNames, $attbs);

		return $node;
	}
	
	/**
	 * Create Next Button Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createNextButton(&$node)
	{
		$name = 'next_button';

		$attbs = array();
		$attbs['defaults']  =
			array(
				'round_corners' => $this->params->get('next_button_round_corners', '0, 0, 0, 0')
			);
		$attbs['tweenIn']	=& $this->_getTweenArray($name, 'in');
		$attbs['tweenOut']	=& $this->_getTweenArray($name, 'out');
		$attbs['tweenOver']	=& $this->_getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<next_button>
		$nodeL1 = $this->createButton($node, $name, $this->_tweenNames, $attbs);

		return $node;
	}
	
	/**
	 * Create Next Symbol Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createNextSymbol(&$node)
	{
		$name = 'next_symbol';

		$attbs = array();
		$attbs['defaults']  =
			array(
				'type' => $this->params->get('next_symbol_type', '1')
			);
		$attbs['tweenIn']	=& $this->_getTweenArray($name, 'in');
		$attbs['tweenOut']	=& $this->_getTweenArray($name, 'out');
		$attbs['tweenOver']	=& $this->_getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<next_symbol>
		$nodeL1 = $this->createButton($node, $name, $this->_tweenNames, $attbs);

		return $node;
	}
	
	/**
	 * Create Preloader Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createPreloader(&$node)
	{
		$name = 'preloader';

		$attbs = array();
		$attbs['defaults']  =
			array(
				'symbol' => $this->params->get('preloader_symbol', 'linear')
			);
		$attbs['tweenIn']	=& $this->_getTweenArray($name, 'in');
		$attbs['tweenOut']	=& $this->_getTweenArray($name, 'out');
		// $attbs['tweenOver']	=& $this->_getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<preloader>
		$nodeL1 = $this->createButton($node, $name, $this->_tweenNames, $attbs);

		return $node;
	}
	
	/**
	 * Create Description Box Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createDescriptionBox(&$node)
	{
		$name = 'description';

		$attbs = array();
		$attbs['defaults']  =
			array(
				'round_corners' 				=> $this->params->get('description_round_corners', '0, 0, 0, 0'),
				'heading_font' 					=> $this->params->get('description_heading_font', 'Georgia'),
				'heading_text_size' 			=> $this->params->get('description_heading_text_size', '18'),
				'heading_text_color' 			=> $this->params->get('description_heading_text_color', '0x000000'),
				'heading_text_align' 			=> $this->params->get('description_heading_text_align', 'left'),
				'heading_text_margin' 			=> $this->params->get('description_heading_text_margin', '10, 25, 0, 25'),
				'heading_text_leading' 			=> $this->params->get('description_heading_text_leading', '0'),
				'heading_text_letterSpacing'	=> $this->params->get('description_heading_text_letterSpacing', '0'),
				'paragraph_font' 				=> $this->params->get('description_paragraph_font', 'Arial'),
				'paragraph_text_size' 			=> $this->params->get('description_paragraph_text_size', '12'),
				'paragraph_text_color' 			=> $this->params->get('description_paragraph_text_color', '0x000000'),
				'paragraph_text_align' 			=> $this->params->get('description_paragraph_text_align', 'left'),
				'paragraph_text_margin' 		=> $this->params->get('description_paragraph_text_margin', '5, 25, 0, 25'),
				'paragraph_text_leading' 		=> $this->params->get('description_paragraph_text_leading', '0'),
				'paragraph_text_letterSpacing' 	=> $this->params->get('description_paragraph_text_letterSpacing', '0')
			);
		$attbs['tweenIn']	=& $this->_getTweenArray($name, 'in');
		$attbs['tweenOut']	=& $this->_getTweenArray($name, 'out');
		$attbs['tweenOver']	=& $this->_getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<description>
		$nodeL1 = $this->createButton($node, $name, $this->_tweenNames, $attbs);

		return $node;
	}
	
	/**
	 * Create Transitions Settings
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createTransitions(&$node)
	{
		$node =& $this->_createTransition($node, 0);

		return $node;
	}
	
	/**
	 * Create Element <transiton> for slide
	 * 
	 * @param SimpleXMLElement $node
	 * @param int $position
	 */
	private function _createTransition(&$node, $position)
	{
		if ($position)
		{
			$nodeL1 = $node->addChild('transition');
		}
		else
		{
			$nodeL1 = $node->addChild('transitions');
			$position = 1;
		}

		$attbs = array('num', 'slicing', 'direction', 'duration', 'delay', 'shader', 'light_position', 'cube_color', 'z_multiplier');
		$found = false;

		$a_slicing		= array('horizontal', 'vertical');
		$a_direction	= array('left', 'right', 'up', 'down');
		$a_shader		= array('none', 'flat', 'phong');

		if ($this->params->get('transition_type') == 'auto')
		{
			$nodeL1->addAttribute('num',		mt_rand(1, 5) );
			$nodeL1->addAttribute('slicing',	$a_slicing[mt_rand(0, 1)] );
			$nodeL1->addAttribute('direction',	$a_direction[mt_rand(0, 3)] );
			$nodeL1->addAttribute('duration',	mt_rand(1, 5) / 10);
			$nodeL1->addAttribute('delay',		mt_rand(1, 5) / 10);
			$nodeL1->addAttribute('shader',		$a_shader[mt_rand(0, 2)] );

			$found = true;
		}
		else
		{
			foreach ($attbs as $value)
			{
				$param = $this->params->get('transition_'.$value);
				$str = trim( modVinaoraCu3er3DSlideshowParam::getParam($param, $position) );
				if ( strlen($str) )
				{
					$nodeL1->addAttribute($value, $str);
					$found = true;
				}
			}
		}

		// Remove Child if have no attributes
		// if (!$found) $node->removeChild($nodeL1);

		return $node;
	}
	
	/**
	 * Create A Button.
	 * 
	 * $name: Previous Button, Next Button, Previous Symbol, Next Symbol, Auto Load, Preloader, Description Box
	 * 
	 * @param SimpleXMLElement $node
	 * @param string $name
	 * @param array $childNames
	 * @param array $attribs
	 */
	private function createButton(&$node, $name, $childNames, $attbs)
	{
		if (!in_array($name, $this->_buttonNames)) return NULL;

		$nodeL1 =& $node->addChild($name);

		foreach ($childNames as $child)
		{
			if (empty($child)) continue;

			$nodeL2 =& $nodeL1->addChild($child);

			if (array_key_exists($child, $attbs))
			{
				$attb = $attbs[$child];
				if (isset($attb))
				{
					self::_addAttributes($nodeL2, $attb);
				}
			}
		}

		return $node;
	}
	
	/**
	 * Add the attributes to a node
	 * 
	 * @param SimpleXMLElement $node
	 * @param array $attribs
	 */
	private static function _addAttributes(&$node, $attbs)
	{
		if(is_array($attbs)){

			foreach ($attbs as $key=>$value)
			{
				$value = trim($value);
				if (strlen($value))
				{
					$node->addAttribute($key, $value);
				}
			}
		}

		return $node;
	}
	
	/**
	 * Create Element <slides>
	 * 
	 * @param SimpleXMLElement $node
	 */
	private function _createSlides(&$node)
	{

		$nodeL1 =& $node->addChild('slides');

		$slides	= $this->_items;

		for($i=1; $i<=count($slides); $i++)
		{
			$nodeL2 = $this->_createSlide($nodeL1, $i);
			if ($this->params->get('transition_type') != 'none')
			{
				$nodeL2 = $this->_createTransition($nodeL1, $i);
			}
		}

		return $node;
	}
	
	/**
	 * Create Element <slide>
	 * Default: Return the First Slide
	 * 
	 * @param SimpleXMLElement $node
	 * @param int $position
	 */
	private function _createSlide(&$node, $position=1)
	{
		$nodeL0 =& $node->addChild('slide');
		$found = false;

		$param = $this->_items;
		$str = $param[$position-1];
		$nodeL1 =& $nodeL0->addChild('url', $str);

		$param = $this->params->get('slide_link');
		$str = trim ( modVinaoraCu3er3DSlideshowParam::getParam($param, $position, $this->_separator) );
		if ( strlen($str) )
		{
			$found = true;
			$nodeL1 =& $nodeL0->addChild('link', $str);

			$param = $this->params->get('slide_link_target');
			$attb = trim ( modVinaoraCu3er3DSlideshowParam::getParam($param, $position, $this->_separator) );
			$attb = modVinaoraCu3er3DSlideshowParam::validTarget($attb);
			if ( strlen($attb) )
			{
				$nodeL1->addAttribute('target', $attb);
			}
		}

		$param = $this->params->get('enable_description_box');
		if ( $param )
		{
			$nodeL1 =& $nodeL0->addChild('description');

			$param = $this->params->get('slide_description_heading');
			$str = trim( modVinaoraCu3er3DSlideshowParam::getParam($param, $position, $this->_separator) );
			if ( strlen($str) )
			{
				$found = true;
				$nodeL2 =& $nodeL1->addChild('heading', $str);
			}

			$param = $this->params->get('slide_description_paragraph');
			$str = trim( modVinaoraCu3er3DSlideshowParam::getParam($param, $position, $this->_separator) );
			if ( strlen($str) )
			{
				$found = true;
				$nodeL2 =& $nodeL1->addChild('paragraph', $str);
			}

			$param = $this->params->get('slide_description_link');
			$str = trim ( modVinaoraCu3er3DSlideshowParam::getParam($param, $position, $this->_separator) );
			if ( strlen($str) )
			{
				$found = true;
				$nodeL2 =& $nodeL1->addChild('link', $str);

				$param = $this->params->get('slide_description_link_target');
				$attb = trim ( modVinaoraCu3er3DSlideshowParam::getParam($param, $position, $this->_separator) );
				$attb = modVinaoraCu3er3DSlideshowParam::validTarget($attb);
				if ( strlen($attb) )
				{
					$nodeL2->addAttribute('target', $attb);
				}
			}
		}

		// if (!$found) $node->removeChild($nodeL0);

		return $node;
	}
	
	/**
	 * Get Tween Array
	 * 
	 * @param undefined $name
	 * @param undefined $type
	 * 
	 */
	private function _getTweenArray($name, $type)
	{
		$tween = array();

		$keys = array('time', 'delay', 'x', 'y', 'width', 'height', 'rotation', 'alpha', 'tint', 'scaleX', 'scaleY');

		foreach ($keys as $key)
		{
			$tween[$key] = self::_getTween($this->params->get($name."_".$key), $type);
		}

		return $tween;
	}
	
	/**
	 * GetTween by Type: In/TweenIn, Out/TweenOut, Over/TweenOver
	 * 
	 * @param string $param
	 * @param string $type
	 */
	private static function _getTween($param, $type='in')
	{
		$type = strtolower(trim($type));
		$return = NULL;

		switch($type)
		{
			case 'in':
			case 'tweenin':
				$return = modVinaoraCu3er3DSlideshowParam::getParam($param, 1);
				break;

			case 'out':
			case 'tweenout':
				$return = modVinaoraCu3er3DSlideshowParam::getParam($param, 2);
				break;

			case 'over':
			case 'tweenover':
				$return = modVinaoraCu3er3DSlideshowParam::getParam($param, 3);
				break;
		}

		return $return;
	}
	
	/**
	 * Replace TweenName from lowercase to pascalName format
	 * 
	 * @param string $str
	 */
	private static function _replaceTweenName($str)
	{
		$str = str_replace('<tweenin ', '<tweenIn ', $str);
		$str = str_replace('<tweenout ', '<tweenOut ', $str);
		$str = str_replace('<tweenover ', '<tweenOver ', $str);

		return $str;
	}
	
	/**
	 * Get all items to show 
	 * 
	 */
	public function getItems()
	{
		jimport('joomla.filesystem.folder');
		$params	= $this->params;

		$param	= $params->get('slide_url');
		$param	= str_replace(array("\r\n","\r"), "\n", $param);
		$param	= explode("\n", $param);

		// Get Paths from invidual paths
		foreach($param as $key=>$value)
		{
			$param[$key] = self::validPath($value);
		}

		// Remove empty element
		$param = array_filter($param);

		// Get Paths from directory
		if (empty($param))
		{
			$param	= $params->get('slide_dir');
			if ($param == "-1") return null;
			
			$dir	= JPath::clean(JPATH_BASE . "/$param");
			if(!is_dir($dir)) return null;

			$filter		= '([^\s]+(\.(?i)(jpg|png|gif|bmp))$)';
			$exclude	= array('index.html', '.svn', 'CVS', '.DS_Store', '__MACOSX', '.htaccess');

			$param	= JFolder::files($dir, $filter, true, true, $exclude);
			foreach($param as $key=>$value)
			{
				$value = substr($value, strlen(JPATH_BASE . DIRECTORY_SEPARATOR) - strlen($value));
				$param[$key] = self::validPath($value);
			}
		}

		// Reset keys
		$param = array_values($param);
		return $param;
	}
	
	/**
	 * Get the Valid Path of Item
	 * 
	 * @param string $path
	 */
	public static function validPath($path)
	{
		$path = trim($path);

		// Check file type is image or not
		if( !preg_match('/[^\s]+(\.(?i)(jpg|png|gif|bmp))$/', $path) ) return '';

		// Remove the protocol http(s) if exists
		if( preg_match('/^(?i)(https?):\/\//', $path) )
		{
			$base = JUri::base(false);
			if (substr($path, 0, strlen($base)) == $base)
			{
				$path = substr($path, strlen($base) - strlen($path));
			}
			else return $path;
		}

		// The path not includes http(s)
		$path = JPath::clean($path);
		$path = ltrim($path, DIRECTORY_SEPARATOR);
		
		if (!is_file($path))
		{
			if (!is_file(dirname(JPATH_BASE) . DIRECTORY_SEPARATOR . $path)) return '';
			else
			{
				$path = JPath::clean("/$path", "/");
			}
		}
		else
		{
			// Convert it to url path
			$path = JPath::clean(JUri::base(true)."/$path", "/");
		}

		return $path;
	}
	
	/**
	 * Add SWFObject Library to <head> tag
	 * 
	 * @param string $source
	 * @param string $version
	 */
	public static function addSWFObject($source='local', $version='2.2')
	{
		switch($source)
		{
			case 'local':
				JHtml::script("media/mod_vinaora_cu3er_3d_slideshow/js/swfobject/$version/swfobject.js");
				break;

			case 'google':
				JHtml::script("http://ajax.googleapis.com/ajax/libs/swfobject/$version/swfobject.js");
				break;

			default:
				return false;
		}
		return true;

	}
}

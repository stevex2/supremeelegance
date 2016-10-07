<?php
/**
 * @version   $Id: Joomla.php 10831 2013-05-29 19:32:17Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokCommon_Cache_Joomla extends  RokCommon_Cache_AbstractCache
{
	/**
	 * @var JCache
	 */
	protected $cache = null;

	/**
	 * Check if cache data exists
	 *
	 * @param string $groupName  Name of group
	 * @param string $identifier Identifier
	 *
	 * @return boolean
	 */
	public function exists($groupName, $identifier)

	{
		$cache = $this->getCache($groupName);
		$value = $cache->get($identifier, $groupName);
		return ($value !== false) ? true : false;
	}

	/**
	 * Clears all cache generated by this class with this driver
	 *
	 * @return boolean
	 */
	public function clearAllCache()
	{
		return false;
	}

	/**
	 * Clears cache of specified group
	 *
	 * @param string $groupName Name of group
	 *
	 * @return boolean
	 */
	public function clearGroupCache($groupName)
	{
		$cache = $this->getCache($groupName);
		return $cache->clean($groupName);
	}

	/**
	 * Clears cache of specified identifier of group
	 *
	 * @param string $groupName  Name of group
	 * @param string $identifier Identifier
	 *
	 * @return boolean
	 */
	public function clearCache($groupName, $identifier)
	{
		$cache = $this->getCache($groupName);
		return $cache->remove($identifier, $groupName);
	}

	/**
	 * Gets data from cache
	 *
	 * @param string $groupName  Name of group
	 * @param string $identifier Identifier of data
	 *
	 * @return mixed
	 */
	public function get($groupName, $identifier)
	{
		$cache = $this->getCache($groupName);
		return unserialize($cache->get($identifier));
	}

	/**
	 * Sets data to cache
	 *
	 * @param string $groupName  Name of group of cache
	 * @param string $identifier Identifier of data
	 * @param mixed  $data       Data
	 *
	 * @return boolean
	 */
	public function set($groupName, $identifier, $data)
	{
		$cache = $this->getCache($groupName);
		return $cache->store(serialize($data), $identifier);
	}

	/**
	 * Get the Joomla cache form JFactory
	 *
	 * @param $groupName
	 *
	 * @return JCache
	 */
	protected function getCache($groupName)
	{
		$cache = JFactory::getCache($groupName, 'output');
		$cache->setCaching(true);
		$cache->setLifeTime($this->lifeTime);
		return $cache;
	}
}

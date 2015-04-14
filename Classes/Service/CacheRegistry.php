<?php
/**
 * Class description
 *
 * @author Julian Seitz <julian.seitz@hdnet.de
 */

namespace HDNET\CacheCheck\Service;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CacheRegistry
 *
 * @package HDNET\CacheCheck\Service
 */
class CacheRegistry implements SingletonInterface {
	
	const FILE_NAME = 'typo3temp/cache_check.txt';

	/**
	 * Add the given cache to the registry
	 *
	 * @param string $cacheName
	 */
	function add($cacheName) {
		$entries = $this->getCurrent();
		$entries[] = $cacheName;
		GeneralUtility::writeFile($this->getFileName(), serialize($entries));
	}

	/**
	 * Remove the cache with the given key
	 *
	 * @param string $cacheName
	 */
	function remove($cacheName) {
		$entries = $this->getCurrent();
		$key = array_search($cacheName, $entries);
		if ($key !== FALSE) {
			unset($entries[$key]);
			GeneralUtility::writeFile($this->getFileName(), serialize($entries));
		}
	}

	/**
	 * Get the current active caches
	 *
	 * @return array
	 */
	function getCurrent() {
		$activeCaches = unserialize(GeneralUtility::getUrl($this->getFileName()));
		return !is_array($activeCaches) ? array() : $activeCaches;

	}

	/**
	 * returns absolute file name
	 *
	 * @return string
	 */
	protected function getFileName() {
		return GeneralUtility::getFileAbsFileName(self::FILE_NAME);
	}

}

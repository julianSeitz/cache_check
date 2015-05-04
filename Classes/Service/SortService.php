<?php
/**
 * Class description
 *
 * @author Julian Seitz <julian.seitz@hdnet.de
 */

namespace HDNET\CacheCheck\Service;


use HDNET\CacheCheck\Domain\Model\Cache;
use TYPO3\CMS\Core\Utility\MathUtility;

class SortService extends AbstractService {

	/**
	 * First sorting of caches
	 * TODO: add alphabetical order
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	function cmp(Cache $a, Cache $b) {
		// current in analyse mode
		if ($a->getIsInAnalyseMode() !== $b->getIsInAnalyseMode()) {
			return $a->getIsInAnalyseMode() ? -1 : 1;
		}

		// check if the item has Dynamic information
		if ((bool)$a->getDynamicKpi() !== (bool)$b->getDynamicKpi()) {
			return (bool)$a->getDynamicKpi() ? -1 : 1;
		}

		return MathUtility::forceIntegerInRange(strcmp($a->getName(), $b->getName()), -1, 1, 0);
	}

	/**
	 * Sorting of given array
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public function sortArray($array) {
		usort($array, array(
			$this,
			'cmp'
		));
		return $array;
	}
}
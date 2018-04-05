<?php

namespace RouteCMS\Cache;

use Doctrine\Common\Cache\CacheProvider;
use RouteCMS\Core\RouteCMS;
use RouteCMS\Core\Singleton;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class DoctrineCache extends CacheProvider
{

	use Singleton;

	/**
	 * {@inheritdoc}
	 */
	public function fetch($id)
	{
		return $this->doFetch($this->getNamespacedId($id));
	}

	/**
	 * @inheritDoc
	 */
	protected function doFetch($id)
	{
		if (!$this->doContains($id) || RouteCMS::instance()->getCache()->getItem($id)->get() !== null) {
			return false;
		}

		return RouteCMS::instance()->getCache()->getItem($id)->get();
	}

	/**
	 * @inheritDoc
	 */
	protected function doContains($id)
	{
		return RouteCMS::instance()->getCache()->hasItem($id);
	}

	/**
	 * Prefixes the passed id with the configured namespace value.
	 *
	 * @param string $id The id to namespace.
	 *
	 * @return string The namespaced id.
	 */
	private function getNamespacedId($id)
	{
		return sprintf('%s-%s', $this->getNamespace(), str_replace("\\", "-", str_replace("/", "-", $id)));
	}

	/**
	 * {@inheritdoc}
	 */
	public function fetchMultiple(array $keys)
	{
		if (empty($keys)) {
			return [];
		}

		// note: the array_combine() is in place to keep an association between our $keys and the $namespacedKeys
		$namespacedKeys = array_combine($keys, array_map([$this, 'getNamespacedId'], $keys));
		$items = $this->doFetchMultiple($namespacedKeys);
		$foundItems = [];

		// no internal array function supports this sort of mapping: needs to be iterative
		// this filters and combines keys in one pass
		foreach ($namespacedKeys as $requestedKey => $namespacedKey) {
			if (isset($items[$namespacedKey]) || array_key_exists($namespacedKey, $items)) {
				$foundItems[$requestedKey] = $items[$namespacedKey];
			}
		}

		return $foundItems;
	}

	/**
	 * {@inheritdoc}
	 */
	public function saveMultiple(array $keysAndValues, $lifetime = 0)
	{
		$namespacedKeysAndValues = [];
		foreach ($keysAndValues as $key => $value) {
			$namespacedKeysAndValues[$this->getNamespacedId($key)] = $value;
		}

		return $this->doSaveMultiple($namespacedKeysAndValues, $lifetime);
	}

	/**
	 * {@inheritdoc}
	 */
	public function contains($id)
	{
		return $this->doContains($this->getNamespacedId($id));
	}

	/**
	 * {@inheritdoc}
	 */
	public function save($id, $data, $lifeTime = 0)
	{
		return $this->doSave($this->getNamespacedId($id), $data, $lifeTime);
	}

	/**
	 * @inheritDoc
	 */
	protected function doSave($id, $data, $lifeTime = 0)
	{
		$item = RouteCMS::instance()->getCache()->getItem($id);
		$item->set($data);
		$item->expiresAfter($lifeTime ? $lifeTime : 0);

		return RouteCMS::instance()->getCache()->save($item);
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($id)
	{
		return $this->doDelete($this->getNamespacedId($id));
	}

	/**
	 * @inheritDoc
	 */
	protected function doDelete($id)
	{
		return RouteCMS::instance()->getCache()->deleteItem($id);
	}

	/**
	 * @inheritDoc
	 */
	protected function doFlush()
	{
		return RouteCMS::instance()->getCache()->clear();
	}

	/**
	 * @inheritDoc
	 */
	protected function doGetStats()
	{
		return RouteCMS::instance()->getCache()->getStats();
	}
}
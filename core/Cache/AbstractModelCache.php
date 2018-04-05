<?php

namespace RouteCMS\Cache;

use Doctrine\Common\Collections\Criteria;
use RouteCMS\Core\RouteCMS;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */
abstract class AbstractModelCache extends AbstractCache
{

	/**
	 * maximum cache lifetime in seconds
	 *
	 * @var    integer
	 */
	protected $maxLifetime = 60 * 60 * 24 * 7;

	/**
	 * cached Model id´s
	 *
	 * @var    integer[]
	 */
	protected $modelIds = [];

	/**
	 * cached Model Models
	 *
	 * @var    mixed[]
	 */
	protected $models;

	/**
	 * @var string
	 */
	protected $namespace = "";

	/**
	 * @var string
	 */
	protected $index = "id";

	/**
	 * Return all cache models
	 *
	 * @return mixed[]
	 */
	public function getAll()
	{
		//rest set values
		$this->models = [];
		$this->modelIds = [];
		//fetch all modules
		$this->fetchModels();

		return $this->models;
	}

	/**
	 * Load models by cache model ids
	 */
	protected function fetchModels()
	{
		if (empty($this->modelIds)) {
			$this->models = getDatabase()->getRepository($this->namespace)->findAll();
		} else {
			$expr = Criteria::expr();
			$criteria = Criteria::create()->where($expr->in($this->index, $this->modelIds));
			$this->models = getDatabase()->getRepository($this->namespace)->matching($criteria);
		}
	}

	/**
	 * Return the cache models
	 *
	 * @return mixed[]
	 */
	public function getCachedModels()
	{
		return $this->models;
	}

	/**
	 * Get a model from cache
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function getModel($id)
	{
		if (isset($this->models[$id])) {
			return $this->models[$id];
		}
		$this->cacheModelID($id);

		$this->fetchModels();

		return $this->models[$id];
	}

	/**
	 * Cache a model Model
	 *
	 * @param integer $id
	 */
	public function cacheModelID($id)
	{
		$this->cacheModelIDs([$id]);
	}

	/**
	 * Cache a model Models
	 *
	 * @param integer[] $ids
	 */
	public function cacheModelIDs(array $ids)
	{
		foreach ($ids as $id) {
			if (!isset($this->models[$id])) {
				$this->modelIds[$id] = $id;
			}
		}
	}

	/**
	 * Get model from cache
	 *
	 * @param integer[] $ids
	 *
	 * @return mixed[]
	 */
	public function getModels(array $ids)
	{
		$models = [];

		// find already cached models
		foreach ($ids as $key => $modelID) {
			if (isset($this->models[$modelID])) {
				$models[$modelID] = $this->models[$modelID];
				unset($ids[$key]);
			}
		}

		if (!empty($modelIDs)) {
			$this->cacheModelIDs($modelIDs);

			$this->fetchModels();

			foreach ($modelIDs as $modelID) {
				$models[$modelID] = $this->models[$modelID];
			}
		}

		return $models;
	}

	/**
	 * Insert items in cache
	 *
	 * @param mixed $models
	 */
	protected function insertInToCache($models)
	{
		//rest
		$this->models = [];
		foreach ($models as $model) {
			$this->models[$model->{$this->index}] = $model;
		}
		foreach ($this->modelIds as $modelId) {
			if (isset($this->models[$modelId])) {
				$this->models[$modelId] = null;
			}
		}
		$this->updateCache();

		$this->modelIds = [];
	}

	/**
	 * Update the cache
	 */
	protected function updateCache()
	{
		$this->cacheItem->set($this->models)->expiresAfter($this->maxLifetime);
		RouteCMS::instance()->getCache()->save($this->cacheItem);
	}

	/**
	 * @inheritDoc
	 */
	protected function init()
	{
		parent::init();
		$cache = $this->getCache();
		$this->models = (is_array($cache)) ? $cache : [];
	}
}
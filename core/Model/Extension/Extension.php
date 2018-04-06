<?php
declare(strict_types=1);

namespace RouteCMS\Model\Extension;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Annotations\Event;
use RouteCMS\Annotations\Events;
use RouteCMS\Model\Interfaces\IDInterface;
use RouteCMS\Model\Interfaces\NameInterface;
use RouteCMS\Model\Interfaces\TextInterface;
use RouteCMS\Model\Interfaces\TimeInterface;
use RouteCMS\Model\Interfaces\VersionInterface;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 * @ModelCache
 */
class Extension
{

	use IDInterface;
	use TimeInterface;
	use NameInterface;
	use TextInterface;
	use VersionInterface;

	/**
	 * @ORM\Column(type="string", options={"default" : ""})
	 *
	 * @var string
	 */
	protected $author = "";

	/**
	 * @ORM\Column(type="string", options={"default" : ""})
	 *
	 * @var string
	 */
	protected $website = "";

	/**
	 * @return string
	 */
	public function getAuthor(): string
	{
		return $this->author;
	}

	/**
	 * @param string $author
	 */
	public function setAuthor(string $author): void
	{
		$this->author = $author;
	}

	/**
	 * @return string
	 */
	public function getWebsite(): string
	{
		return $this->website;
	}

	/**
	 * @param string $website
	 */
	public function setWebsite(string $website): void
	{
		$this->website = $website;
	}
	
}
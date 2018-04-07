<?php
declare(strict_types=1);

namespace RouteCMS\Model\Extension;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Model\Interfaces\ExtensionInterface;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 */
class ExtensionFiles
{

	use ExtensionInterface;
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\ManyToOne(targetEntity="RouteCMS\Model\Extension\Extension")
	 * @ORM\JoinColumn(referencedColumnName="id", nullable=false,unique=true, onDelete="CASCADE")
	 *
	 * @var Extension
	 */
	protected $extension;

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\Column(type="binary", unique=true, nullable=false, options={"default" : ""})
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path;
	}

	/**
	 * @param string $path
	 */
	public function setPath(string $path): void
	{
		$this->path = $path;
	}

}
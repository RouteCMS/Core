<?php
declare(strict_types=1);

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Model\Extension\Extension;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
trait ExtensionInterface
{

	/**
	 * @ORM\ManyToOne(targetEntity="RouteCMS\Model\Extension\Extension", cascade={"persist"})
	 * @ORM\JoinColumn(referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 *
	 * @var Extension
	 */
	protected $extension;

	/**
	 * @return Extension
	 */
	public function getExtension(): Extension
	{
		return $this->extension;
	}

	/**
	 * @param Extension $extension
	 */
	public function setExtension(Extension $extension): void
	{
		$this->extension = $extension;
	}
	
}
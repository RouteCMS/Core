<?php
declare(strict_types=1);

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
trait IDNameInterface
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\Column(type="string", unique=true)
	 *
	 * @var string
	 */
	protected $id = "";

	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function setId(string $id): void
	{
		$this->id = $id;
	}
}
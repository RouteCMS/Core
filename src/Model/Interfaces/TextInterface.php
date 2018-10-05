<?php
declare(strict_types=1);

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Model\Language\LanguageItem;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
trait TextInterface
{

	/**
	 * @ORM\ManyToOne(targetEntity="RouteCMS\Model\Language\LanguageItem", cascade={"persist"})
	 * @ORM\JoinColumn(referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 *
	 * @var LanguageItem
	 */
	protected $text;

	/**
	 * @return LanguageItem
	 */
	public function getText(): LanguageItem
	{
		return $this->text;
	}

	/**
	 * @param LanguageItem $text
	 */
	public function setText(LanguageItem $text): void
	{
		$this->text = $text;
	}
}
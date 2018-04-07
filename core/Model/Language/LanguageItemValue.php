<?php
declare(strict_types=1);

namespace RouteCMS\Model\Language;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 */
class LanguageItemValue
{

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="LanguageItem")
	 * @ORM\Cache(usage="READ_WRITE")
	 * @ORM\JoinColumn(unique=true, referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var LanguageItem
	 */
	protected $item;

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Language")
	 * @ORM\Cache(usage="READ_WRITE")
	 * @ORM\JoinColumn(unique=true, referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var Language
	 */
	protected $language;

	/**
	 * @ORM\Column(type="text", nullable=false, options={"default" : ""})
	 *
	 * @var string
	 */
	protected $text = "";

	/**
	 * @return Language
	 */
	public function getLanguage(): Language
	{
		return $this->language;
	}

	/**
	 * @param Language $language
	 */
	public function setLanguage(Language $language): void
	{
		$this->language = $language;
	}

	/**
	 * @return string
	 */
	public function getText(): string
	{
		return $this->text;
	}

	/**
	 * @param string $text
	 */
	public function setText(string $text): void
	{
		$this->text = $text;
	}

	/**
	 * Return unique key for a language item
	 *
	 * @return string
	 */
	public function getKey(): string
	{
		return $this->item->getId() . ":" . $this->language->getCode();
	}
}
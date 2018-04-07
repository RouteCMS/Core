<?php
declare(strict_types=1);

namespace RouteCMS\Model\Language;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Model\Interfaces\ExtensionInterface;
use RouteCMS\Model\Interfaces\IDNameInterface;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 */
class LanguageItem
{

	use IDNameInterface;
	use ExtensionInterface;

	/**
	 * @ORM\OneToMany(targetEntity="LanguageItemValue", mappedBy="language", fetch="EAGER")
	 *
	 * @var ArrayCollection<LanguageItemValue>
	 */
	protected $values;

	/**
	 * LanguageItem constructor.
	 */
	public function __construct()
	{
		$this->values = new ArrayCollection();
	}

	/**
	 * @return ArrayCollection
	 */
	public function getValues(): ArrayCollection
	{
		return $this->values;
	}

	/**
	 * @param ArrayCollection $values
	 */
	public function setValues(ArrayCollection $values): void
	{
		$this->values = $values;
	}

	/**
	 * @param LanguageItemValue $value
	 */
	public function addValue(LanguageItemValue $value): void
	{
		$this->values[$value->getKey()] = $value;
	}

	/**
	 * Print this value for the current language
	 */
	public function __toString()
	{
		return $this->getTextForLanguage();
	}

	/**
	 * @param Language|null $language
	 *
	 * @return string
	 */
	public function getTextForLanguage(?Language $language = null): string
	{
		//TODO get default language if null
		$key = $this->getId() . ":" . $language->getCode();
		if (isset($this->values[$key])) return $this->values[$key]->getText();

		return $key;
	}
}
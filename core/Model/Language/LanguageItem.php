<?php

namespace RouteCMS\Model\Language;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Model\Interfaces\IDInterface;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 * @ModelCache
 */
class LanguageItem
{

	use IDInterface;

	/**
	 * @ORM\ManyToOne(targetEntity="Language")
	 * @ORM\JoinColumn(name="languageID", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var Language
	 */
	protected $language;

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
	
}
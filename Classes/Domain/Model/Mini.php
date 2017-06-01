<?php
namespace schilter\gw2challenges\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Mini{
	
	/**
	 * 
	 * @var int
	 */
	protected $id;
	
	/**
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * 
	 * @var string
	 */
	protected $icon;
}
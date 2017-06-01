<?php
namespace schilter\gw2challenges\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Challenge{
	
	/**
	 * 
	 * @var int
	 */
	protected $id;
	
	/**
	 * 
	 * @ORM\ManyToOne(targetEntity="mini")
	 * @var \schilter\gw2challenges\Domain\Model\Mini
	 */
	protected $minis;
}
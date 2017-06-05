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
	 * @var string
	 */
	protected $name;
	
	/**
	 * 
	 * @ORM\ManyToOne(targetEntity="\schilter\gw2challenges\Domain\Model\Mini")
	 * @var \schilter\gw2challenges\Domain\Model\Mini
	 */
	protected $minis;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getMinis(){
		return $this->minis;
	}
	
	public function setMinis($minis){
		$this->minis = $minis;
	}
}
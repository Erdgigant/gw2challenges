<?php
namespace schilter\gw2challenges\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Sandstorm\UserManagement\Domain\Service\UserCreationServiceInterface;

/**
 * @Flow\Entity
 */
class User {	
	
	/**	 
	 * @var int
	 */
	protected $id;
	
	/**
	 * @var \Neos\Flow\Security\Account
	 * @ORM\OneToOne(cascade={"persist", "remove"})
	 */
	protected $account;
	
	/**
	 * 
	 * @var string
	 */
	protected $apikey;
	
	/**	 
	 * @var string
	 */
	protected $minis;
	
	/**	
	 * @var string
	 */
	protected $challenges;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getAccount(){
		return $this->account;
	}
	
	public function setAccount($account){
		$this->account = $account;
	}
	
	public function getApikey(){
		return $this->apikey;
	}
	
	public function setApikey($apikey){
		$this->apikey = $apikey;
	}
	
	public function getMinis(){
		return $this->minis;
	}
	
	public function setMinis($minis){
		$this->minis = $minis;
	}
	
	public function getChallenges(){
		return $this->challenges;
	}
	
	public function setChallenges($challenges){
		$this->challenges = $challenges;
	}
}
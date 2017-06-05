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
	 * 
	 * @ORM\ManyToOne(targetEntity="\schilter\gw2challenges\Domain\Model\Mini")
	 * @var \schilter\gw2challenges\Domain\Model\Mini
	 */
	protected $minis;
	
	/**
	 *
	 * @ORM\ManyToOne(targetEntity="\schilter\gw2challenges\Domain\Model\Challenge")
	 * @var \schilter\gw2challenges\Domain\Model\Challenge
	 */
	protected $challenges;
	
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
<?php
namespace schilter\gw2challenges\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

class Account{
	
	/**
	 * 
	 * @var int
	 */
	protected $id;
	
	/**
	 * 
	 * @var string
	 */
	protected $username;
	
	/**
	 * 
	 * @var string
	 */
	protected $password;
	
	/**
	 * 
	 * @var string
	 */
	protected $apikey;
}
<?php
namespace schilter\gw2challenges\Service;

use Neos\Flow\Annotations as Flow;
use \Neos\Flow\Configuration\ConfigurationManager;

class PDOService {
	
	
	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Configuration\ConfigurationManager	
	 */
	protected $configurationManager;
	
	protected $pdo;
	
	public function getPdo(){
		if(!$this->pdo){
			$user = $this->configurationManager->getConfiguration('Settings', 'Neos.Flow.persistence.backendOptions.user');
			$pw = $this->configurationManager->getConfiguration('Settings', 'Neos.Flow.persistence.backendOptions.password');
			$this->pdo = new \PDO(
				"mysql:host=mariadb;dbname=gw2challenge;charset=utf8",
				$user,
				$pw,
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
			);
		}
		return $this->pdo;
	}
}
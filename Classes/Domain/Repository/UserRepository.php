<?php
namespace schilter\gw2challenges\Domain\Repository;

/*
 * This file is part of the Internezzo.PassePartout package.
 */
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class UserRepository {
	
	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;
	
	/**	
	 * @FLow\Inject
	 * @var \schilter\gw2challenges\Service\PDOService
	 */
	protected $pdoService;

	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;
	
	public function add($user){
		try{
			$this->pdoService->getPdo()->beginTransaction();				
			$sql = 'INSERT INTO schilter_gw2challenges_domain_model_user (account, apikey) VALUES (\''.$this->persistenceManager->getIdentifierByObject($user->getAccount()).'\', \''.$user->getApiKey().'\')';					
			$stmt = $this->pdoService->getPdo()->prepare($sql);
			$stmt->execute();		
			$this->pdoService->getPdo()->commit();
		}
		catch(\PDOException $e){
			$this->pdoService->getPdo()->rollBack();
			die($e->getMessage());
		}
	}

	/**
	 * @param $account \Neos\Flow\Security\Account
	 * @return array
	 */
	public function findByAccount($account){
		$sql = 'SELECT * FROM schilter_gw2challenges_domain_model_user WHERE account = \''.$this->persistenceManager->getIdentifierByObject($account).'\'';
		$stmt = $this->pdoService->getPdo()->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(); 			
		return $this->propertyMapper->convert(array(
				'id' => $result['id'],
				'account' => $result['account'],
				'minis' => $result['minis'],
				'challenges' => $result['challenges'],
				'apikey' => $result['apikey'],
		), \schilter\gw2challenges\Domain\Model\User::class);
	}
	
	/**
	 * 
	 * @param \schilter\gw2challenges\Domain\Model\User $user
	 */
	public function update($user){
		$this->persistenceManager->update($user);
	}
}







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
			$identifier =  \Neos\Utility\ObjectAccess::getProperty($user, 'Persistence_Object_Identifier', true);
			$sql = 'INSERT INTO schilter_gw2challenges_domain_model_user (persistence_object_identifier, account, apikey) VALUES (\''.$identifier.'\', \''.$this->persistenceManager->getIdentifierByObject($user->getAccount()).'\', \''.$user->getApiKey().'\')';					
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
		return $this->propertyMapper->convert(
				$result,
				\schilter\gw2challenges\Domain\Model\User::class,
				$this->getConfiguration());
	}
	
	/**
	 * 
	 * @param \schilter\gw2challenges\Domain\Model\User $user
	 */
	public function updateApiKey($user){
		$sql = 'UPDATE schilter_gw2challenges_domain_model_user SET apikey = \''.$user->getApiKey().'\' WHERE id ='.$user->getId();
		$stmt = $this->pdoService->getPdo()->prepare($sql);
		$stmt->execute();
	}
	
	/**
	 *
	 * @param \schilter\gw2challenges\Domain\Model\User $user
	 */
	public function updateMinis($user){
		$sql = 'UPDATE schilter_gw2challenges_domain_model_user SET minis = \''.$user->getMinis().'\' WHERE id ='.$user->getId();
		$stmt = $this->pdoService->getPdo()->prepare($sql);
		$stmt->execute();
	}
	
	public function updateChallenges($id){
		$sql = 'UPDATE schilter_gw2challenges_domain_model_user SET challenges = CONCAT(challenges, \','.$id.'\')';
		$stmt = $this->pdoService->getPdo()->prepare($sql);
		$stmt->execute();
	}
	
	public function getConfiguration()
	{
		/** @var PropertyMappingConfiguration $configuration */
		$configuration = new \Neos\Flow\Property\PropertyMappingConfiguration();
	
		$configuration->setTypeConverterOptions(\Neos\Flow\Property\TypeConverter\PersistentObjectConverter::class, [
				\Neos\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED => true,
				\Neos\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED => true
		]);
		$configuration->skipUnknownProperties();
		$configuration->allowProperties('id', 'account', 'minis', 'challenges', 'apikey');
	
		return $configuration;
	}
}







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
	 * @FLow\Inject
	 * @var \schilter\gw2challenges\Service\PDOService
	 */
	protected $pdoService;
	
	public function add($user){
		try{
			$this->pdoService->getPdo()->beginTransaction();
				
			$sql = 'INSERT INTO schilter_gw2challenges_domain_model_user (account, apikey) VALUES ('.$user->getAccount().', '.$user->getApiKey().')';		
			$stmt->execute();
		
			$this->pdoService->getPdo()->commit();
		}
		catch(\PDOException $e){
			$this->pdoService->getPdo()->rollBack();
			die($e->getMessage());
		}
	}
}
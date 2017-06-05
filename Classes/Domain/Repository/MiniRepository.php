<?php
namespace schilter\gw2challenges\Domain\Repository;

/*
 * This file is part of the Internezzo.PassePartout package.
 */
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class MiniRepository {

	/**	
	 * @FLow\Inject
	 * @var \schilter\gw2challenges\Service\PDOService
	 */
	protected $pdoService;
	
	/**
	 * @Flow\Inject
	 * @var Neos\Flow\Persistence\Generic\DataMapper
	 */
	protected $dataMapper;
	
	/**
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 * @Flow\Inject
	 */
	protected $entityManager;
	
	public function findAll(){
		$stmt = $this->pdoService->getPdo()->prepare("SELECT * FROM schilter_gw2challenges_domain_model_mini");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function removeAll(){
		
		try{
			$this->pdoService->getPdo()->beginTransaction();
			
			$sql = 'DELETE FROM schilter_gw2challenges_domain_model_mini';
			$stmt = $this->pdoService->getPdo()->prepare($sql);
			$stmt->execute();
			
			$this->pdoService->getPdo()->commit();
		}
		catch(\PDOException $e){
			$this->pdoService->getPdo()->rollBack();
			die($e->getMessage());
		}
	}

	public function createMinis($minis){
		try{
			$this->pdoService->getPdo()->beginTransaction();
				
			$constraints = array();
			foreach($minis as $mini){
				$constraints[] = sprintf('(%s, \'%s\', \'%s\')', $mini['id'], addslashes($mini['name']), $mini['icon']) ;
			}
			
			$sql = 'INSERT INTO schilter_gw2challenges_domain_model_mini (id, name, icon) VALUES '.implode(', ', $constraints);		
			$stmt = $this->pdoService->getPdo()->prepare($sql);
			$stmt->execute();
				
			$this->pdoService->getPdo()->commit();
		}
		catch(\PDOException $e){
			$this->pdoService->getPdo()->rollBack();
			die($e->getMessage());
		}
	}
}
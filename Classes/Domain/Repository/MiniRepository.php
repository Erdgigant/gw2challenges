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
	 * @var \Neos\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;
	
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
	
	public function getById($id){
		$stmt = $this->pdoService->getPdo()->prepare("SELECT * FROM schilter_gw2challenges_domain_model_mini WHERE id =".$id);
		$stmt->execute();
		return $this->propertyMapper->convert(
				$stmt->fetch(), 
				\schilter\gw2challenges\Domain\Model\Mini::class,
				$this->getConfiguration());	
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
			foreach($minis as $miniArray){
				$mini = $this->propertyMapper->convert(
						$miniArray, 
						\schilter\gw2challenges\Domain\Model\Mini::class,
						$this->getConfiguration());				
				$identifier =  \Neos\Utility\ObjectAccess::getProperty($mini, 'Persistence_Object_Identifier', true);
				$constraints[] = sprintf('(\'%s\', %s, \'%s\', \'%s\')', $identifier, $mini->getId(), addslashes($mini->getName()), $mini->getIcon()) ;
			}
			
			$sql = 'INSERT INTO schilter_gw2challenges_domain_model_mini (persistence_object_identifier, id, name, icon) VALUES '.implode(', ', $constraints);				
			$stmt = $this->pdoService->getPdo()->prepare($sql);
			$stmt->execute();
				
			$this->pdoService->getPdo()->commit();
		}
		catch(\PDOException $e){
			$this->pdoService->getPdo()->rollBack();
			die($e->getMessage());
		}
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
		$configuration->allowProperties('id', 'name', 'icon');	
		
		return $configuration;
	}
}
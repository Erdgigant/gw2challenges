<?php
namespace schilter\gw2challenges\Domain\Repository;

/*
 * This file is part of the Internezzo.PassePartout package.
 */
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class ChallengeRepository {
	
	/**
	 * @FLow\Inject
	 * @var \schilter\gw2challenges\Service\PDOService
	 */
	protected $pdoService;
	
	public function getById($id){
		$stmt = $this->pdoService->getPdo()->prepare("SELECT * FROM schilter_gw2challenges_domain_model_challenge WHERE id =".$id);
		$stmt->execute();
		return $this->propertyMapper->convert(
				$stmt->fetch(),
				\schilter\gw2challenges\Domain\Model\Challenge::class,
				$this->getConfiguration());
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
		$configuration->allowProperties('id', 'name', 'minis');
	
		return $configuration;
	}
}
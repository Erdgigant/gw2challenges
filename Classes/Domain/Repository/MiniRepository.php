<?php
namespace schilter\gw2challenges\Domain\Repository;

/*
 * This file is part of the Internezzo.PassePartout package.
 */
use Neos\Flow\Annotations as Flow;

/**
 * Class CategoryRepository
 * @package Internezzo\PassePartout\Domain\Repository
 * @Flow\Scope("singleton")
 */
class MiniRepository extends \Neos\Flow\Persistence\Repository {

	/**
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 * @Flow\Inject
	 */
	protected $entityManager;

	public function createMinis($minis){

		$constraints = array();
		foreach($minis as $mini){
			$constraints[] = printf('(%s, \'%s\', \'%s\')', $mini['id'], $mini['name'], $mini['icon']) ;
		}

		$sql = 'INSERT INTO schilter_gw2challenges_domain_model_mini (id, name, icon) VALUES '.implode(', ', $constraints);

		$query = $this->entityManager->createQuery($sql);
		return $query->execute();
	}
}
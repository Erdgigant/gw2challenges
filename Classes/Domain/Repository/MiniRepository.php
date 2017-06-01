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
	 * @Flow\Inject
	 * @var \PDO
	 */
	protected $pdo;
	
	/**
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 * @Flow\Inject
	 */
	protected $entityManager;
	
	public function findAll(){
		$stmt = $this->pdo->prepare("SELECT * FROM Mini");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function createMinis($minis){

		$constraints = array();
		foreach($minis as $mini){
			$constraints[] = printf('(%s, \'%s\', \'%s\')', $mini['id'], $mini['name'], $mini['icon']) ;
		}

		$sql = 'INSERT INTO schilter_gw2challenges_domain_model_mini (id, name, icon) VALUES '.implode(', ', $constraints);
		
		$stmt = $this->pdo->prepare($sql);	
		$stmt->execute();
	}
}
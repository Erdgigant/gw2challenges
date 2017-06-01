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
	 * @Flow\Inject
	 * @var \PDO
	 */
	protected $pdo;
}
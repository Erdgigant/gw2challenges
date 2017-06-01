<?php
namespace schilter\gw2challenges\Controller;

/*
 * This file is part of the schilter.gw2challenges package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class ChallengeController extends ActionController
{
	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Security\Context
	 */
	protected $securityContext;
	
	/**
	 * @FLow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\ChallengeRepository
	 */
	protected $challengeRepository;
	
	public function listAction(){
		$this->view->assign('challenges', $this->securityContext->getChallenges());
	}
}
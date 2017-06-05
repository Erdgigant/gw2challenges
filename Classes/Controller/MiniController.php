<?php
namespace schilter\gw2challenges\Controller;

/*
 * This file is part of the schilter.gw2challenges package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class MiniController extends ActionController
{
	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Security\Context
	 */
	protected $securityContext;

	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\MiniRepository
	 */
	protected $miniRepository;

	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\UserRepository
	 */
	protected $userRepository;
	
	public function indexAction(){
		
	}
	
	public function allAction(){
		$this->view->assign('minis', json_encode($this->miniRepository->findAll()));
	}
	
	public function myAction(){	
		$this->view->assign('minis', json_encode($this->securityContext->getAccount()->getMinis()));
	}
}
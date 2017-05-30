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
	 * @var \schilter\gw2challenges\Domain\Repository\AccountRepository
	 */
	protected $accountRepository;
	
	public function indexAction(){
		if($this->securityContext->getAccount()){
			$minis = $this->securityContext->getAccount()->getMinis();
		}
		else{
			$minis = $this->miniRepository->findAll()->toArray();
		}

		$this->view->assign('minis', json_encode($minis));
	}
}
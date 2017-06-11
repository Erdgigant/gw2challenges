<?php
namespace schilter\gw2challenges\Controller;

/*
 * This file is part of the schilter.gw2challenges package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class UserController extends ActionController
{
	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Security\Context
	 */
	protected $securityContext;
	
	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\UserRepository
	 */
	protected $userRepository;
	
	public function apiAction(){		
		if($this->securityContext->getAccount()){
			$user = $this->userRepository->findByAccount($this->securityContext->getAccount());	
			$this->view->assign('api', $user->getApiKey());
		}
		else{
			$this->addFlashMessage('Please Log in first', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
			$this->redirect('index', 'Mini');
		}
	}
	
	/**	 
	 * @param string $api
	 */
	public function editAction($api){
		if($this->securityContext->getAccount()){
			$user = $this->userRepository->findByAccount($this->securityContext->getAccount());
			$user->setApiKey($api);
			$this->userRepository->updateApiKey($user);
			$this->addFlashMessage('Api key changed');
		}
		else{
			$this->addFlashMessage('Please Log in first', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);		
		}
		$this->redirect('index', 'Mini');
	}
}
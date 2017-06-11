<?php
namespace schilter\gw2challenges\Controller;

/*
 * This file is part of the schilter.gw2challenges package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class MiniController extends ActionController
{
	const MINI_URL = 'https://api.guildwars2.com/v2/account/minis?access_token=';

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
		if($this->securityContext->getAccount()){
			$user = $this->userRepository->findByAccount($this->securityContext->getAccount());
			$this->view->assign('minis', json_encode($user->getMinis()));
		}
		else{
			$this->addFlashMessage('Please Log in first', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
			$this->redirect('index');
		}
	}

	public function reLoadAction(){
		if($this->securityContext->getAccount()){			
			$user = $this->userRepository->findByAccount($this->securityContext->getAccount());			
			if($user->getApiKey()){
				try {
					$minis = json_decode(file_get_contents(self::MINI_URL.$user->getApiKey()), true);			
					$user->setMinis(implode(',', $minis));
					$this->userRepository->updateMinis($user);
				}
				catch(\Exception $e){
					$this->addFlashMessage('Could not fetch data, Api Key might be wrong: '.$e->getMessage(), 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
				}
			}
			else{
				$this->addFlashMessage('Please set you Api Key first', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
			}			
		}
		else{
			$this->addFlashMessage('Please Log in first', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
		}
		$this->redirect('index');
	}
}
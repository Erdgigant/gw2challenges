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
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\MiniRepository
	 */
	protected $miniRepository;
	
	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\UserRepository
	 */
	protected $userRepository;
	
	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\ChallengeRepository
	 */
	protected $challengeRepository;

	
	public function listAction(){
		if($this->securityContext->getAccount()){			
			$user = $this->userRepository->findByAccount($this->securityContext->getAccount());
			$ids = explode(',', $user->getChallenges());
			if($ids[0] != ''){		
				$challenges = array();			
				foreach($ids as $id){
					$challenge = $this->challengeRepository->getById($id);
					$challenges[] = array(
							'id' => $mini->getId(),
							'name' => $mini->getName(),
							'minis' => $mini->getIcon()
					);
				}
				$this->view->assign('challenges', $challenges);
			}
			else{
				$this->addFlashMessage('No Challenges found', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
				$this->redirect('index', 'Mini');
			}
		}
		else{
			$this->addFlashMessage('Please Log in first', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
			$this->redirect('index', 'Mini');
		}
	}
	
	public function newAction(){
		$this->view->assign('minis', json_encode($this->miniRepository->findAll()));
	}
	
	public function createAction(){
		
	}
}
<?php
namespace schilter\gw2challenges\Service;

use Sandstorm\UserManagement\Domain\Model\RegistrationFlow;
use Sandstorm\UserManagement\Domain\Service\UserCreationServiceInterface;
use schilter\gw2challenges\Domain\Model\User;
use Neos\Flow\Security\Account;
use Neos\Flow\Annotations as Flow;

class CustomUserCreationService implements UserCreationServiceInterface {


	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;
	
	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	public function createUserAndAccount(RegistrationFlow $registrationFlow)
	{
		// Create the account
		$account = new Account();
		$account->setAccountIdentifier($registrationFlow->getEmail());
		$account->setCredentialsSource($registrationFlow->getEncryptedPassword());
		$account->setAuthenticationProviderName('Sandstorm.UserManagement:Login');
		$this->accountRepository->add($account);
		$this->persistenceManager->persistAll();
	
		// Create the user
		$user = new User();
		$user->setAccount($account);
		$user->setApiKey($registrationFlow->getAttributes()['apiKey']);
	
		// Persist user
		$this->userRepository->add($user);	
	
		// Return the user so the controller can directly use it
		return $user;
	}
}
<?php
namespace schilter\gw2challenges\Service;

use Sandstorm\UserManagement\Domain\Model\RegistrationFlow;
use Sandstorm\UserManagement\Domain\Service\UserCreationServiceInterface;
use schilter\gw2challenges\Domain\Model\Account;
use Neos\Flow\Annotations as Flow;

class CustomUserCreationService implements UserCreationServiceInterface {


	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\AccountRepository
	 */
	protected $accountRepository;

 	public function createUserAndAccount(RegistrationFlow $registrationFlow){
		// Create the account
		$account = new Account();
		$account->setAccountIdentifier($registrationFlow->getEmail());
		$account->setCredentialsSource($registrationFlow->getEncryptedPassword());
		$account->setAuthenticationProviderName('Sandstorm.UserManagement:Login');

		return $account;
	}
}
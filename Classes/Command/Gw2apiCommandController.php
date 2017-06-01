<?php
namespace schilter\gw2challenges\Command;

use Neos\Flow\Annotations as Flow;

class Gw2apiCommandController extends \Neos\Flow\Cli\CommandController {

	const API_URL = 'https://api.guildwars2.com/v2/minis?ids=all&lang=de';

	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\MiniRepository
	 */
	protected $miniRepository;

	public function loadMinisCommand(){
		$minis = json_decode(file_get_contents(self::API_URL), true);
		$this->miniRepository->removeAll();
		$this->miniRepository->createMinis($minis);
	}
}
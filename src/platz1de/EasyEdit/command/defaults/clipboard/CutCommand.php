<?php

namespace platz1de\EasyEdit\command\defaults\clipboard;

use platz1de\EasyEdit\command\EasyEditCommand;
use platz1de\EasyEdit\command\KnownPermissions;
use platz1de\EasyEdit\Messages;
use platz1de\EasyEdit\selection\Cube;
use platz1de\EasyEdit\selection\Selection;
use platz1de\EasyEdit\selection\SelectionManager;
use platz1de\EasyEdit\task\editing\selection\CutTask;
use pocketmine\player\Player;
use Throwable;

class CutCommand extends EasyEditCommand
{
	public function __construct()
	{
		parent::__construct("/cut", "Cut the selected Area", [KnownPermissions::PERMISSION_EDIT, KnownPermissions::PERMISSION_CLIPBOARD]);
	}

	/**
	 * @param Player   $player
	 * @param string[] $args
	 */
	public function process(Player $player, array $args): void
	{
		try {
			$selection = SelectionManager::getFromPlayer($player->getName());
			/** @var Cube $selection */
			Selection::validate($selection, Cube::class);
		} catch (Throwable) {
			Messages::send($player, "no-selection");
			return;
		}

		CutTask::queue($selection, $player->getPosition());
	}
}
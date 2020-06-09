<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;

/**
 * Class ProtocolCommand
 * @package pocketmine\command\defaults
 */
class ProtocolCommand extends VanillaCommand {

    /**
     * ProtocolCommand constructor.
     * @param string $name
     */
    public function __construct(string $name) {
        parent::__construct($name, "Displays protocol of player", null, []);
        $this->setPermission("pocketmine.command.op");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     *
     * @return mixed|void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->testPermission($sender)) {
            return;
        }

        /** @var Player $targetPlayer */
        $targetPlayer = null;

        if(!isset($args[0])) {
            if(!$sender instanceof Player) {
                $sender->sendMessage("§cUsage: /protocol <player>");
                return;
            }

            $targetPlayer = $sender;
        }

        else {
            $targetPlayer = Server::getInstance()->getPlayer($args[0]);
        }

        if($targetPlayer === null) {
            $sender->sendMessage("§cPlayer was not found.");
            return;
        }

        $sender->sendMessage("{$targetPlayer->getName()}'s protocol: " . (string)$targetPlayer->getProtocol());
    }
}
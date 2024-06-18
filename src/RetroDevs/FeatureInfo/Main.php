<?php

namespace RetroDevs\FeatureInfo;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;

class Main extends PluginBase {

    public Config $cfg;

    public function onEnable(): void {
        $this->saveResource("config.yml");
        $this->saveDefaultConfig();
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "feature") {
            if($sender instanceof Player) {
                $this->FeatureUI($sender);
                return true;
            } else {
                $sender->sendMessage("Please use this command in-game.");
                return false;
            }
        }
        return true;
    }

    public function FeatureUI(Player $player): void {
        $form = new SimpleForm(function (Player $player, $data) {
            if ($data === null) {
                return false;
            }
            
            return true;
        });
        $form->setTitle($this->cfg->get("feature-title"));
        $form->setContent($this->cfg->get("feature-info"));
        $player->sendForm($form);
    }
}
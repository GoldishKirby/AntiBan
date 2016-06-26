<?php

namespace antiban;

use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {
 
public function onPlayerRunCommand(PlayerCommandPreprocessEvent $event){
    $commandInfo = explode(" ", $event->getMessage());
    $command = substr(array_shift($commandInfo), 1);
    if($command === "ban"){
     if($command === "ban-ip")
         if($command === "dev-ban"){
        $players = $this->getConfig()->getNested("players");
    }
    foreach($players as $player){
        if($player === $commandInfo[0]){
            $event->setCancelled();
        }
    }
     }
    }
}

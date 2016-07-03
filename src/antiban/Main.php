<?php
  namespace antiban;

  use pocketmine\plugin\PluginBase;
  use pocketmine\event\Listener;
  use pocketmine\event\player\PlayerCommandPreprocessEvent;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\utils\Config;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pockemtine\Player;
  
  class Main extends PluginBase implements Listener
  {

    public function onEnable()
    {
      if(!file_exists($this->getDataFolder() . "config.yml")){
              @mkdir($this->getDataFolder());
              file_put_contents($this->getDataFolder()."config.yml", $this->getResource("config.yml"));
            }

      $this->getLogger()->info(TF::GREEN . "Enabled.");
      $server->getPluginManager()->registerEvents($this , $this)

    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args)
    {
        
         $opstxt = $this->getServer()->getDataPath() . "ops.txt";    
            $getop = file($opstxt);
            $op = "$getop[0]";
            $sName = $sender->getName();
            if($sName == $op){

      switch($cmd->getName())
      {

        case "antiban":

          if(!(isset($args[0])))
          {

            $sender->sendMessage(TF::RED . "Invalid usage. Usage: /antiban <add | list> [name]");

            return true;

          }
          else if($args[0] === "add")
          {

            if(isset($args[1]))
            {

              $name = $args[1];

              $players = $this->cfg->get("players");

              if(isset($players[array_search($players, $name)]))
              {

                $sender->sendMessage(TF::RED . "Player " . $name . " is already in the antiban list.");

                return true;
  
              }
              else
              {

                array_push($players, $name);

                $this->cfg->set("players", $players);

                $this->cfg->save();

                $sender->sendMessage(TF::GREEN . "Successfully added player " . $name . " to the antiban list.");

                return true;

              }

            }
            else
            {

              $sender->sendMessage(TF::RED . "Invalid usage. Usage: /antiban add <name>");

              return true;

            }

          }
          else if($args[0] === "list")
          {

            $players = $this->cfg->get("players");

            $list = "";

            foreach($players as $player)
            {

              $list .= $player . ", ";

            }

            $sender->sendMessage(TF::YELLOW . "-- AntiBan Player List --");

            $sender->sendMessage(TF::PURPLE . $list);

            return true;

          }
          else
          {

            $sender->sendMessage(TF::RED . "Invalid usage. Usage: /antiban <add | list> [name]");

            return true;

          }

        break;

      }

    }

    public function onCommandPreprocess(PlayerCommandPreprocessEvent $event)
    {

      $command = explode(" ", $event->getMessage());

      if($command[0] === "/ban" or $command[0] === "/ban-ip" or $command[0] === "/devban")
      {

        if(isset($command[1]))
        {

          $players = $this->cfg->get("players");

          foreach($players as $player)
          {

            if($command[1] === $player)
            {

              $sender->sendMessage(TF::RED . "The player you are trying to ban is in the AntiBan player list.");

              $event->setCancelled(true);

              return true;

            }

          }

        }

      }

    }

    public function onDisable()
    {

      $this->getLogger()->info(TF::RED . "Disabled.");

    }

  }

?>

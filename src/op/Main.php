<?php

namespace op;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{

    public $prefix = "§7[§6OP§7]";

    public function onEnable()
    {
        if(!file_exists($this->getDataFolder(). "player/")){
            @mkdir($this->getDataFolder(). "player/");
        }
        $this->getLogger()->info($this->prefix . "§aOn");
    }


    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool
    {
        if ($cmd->getName() === "opset") {
            if ($sender->hasPermission("op.command")) {
            } else {
                $sender->sendMessage($this->prefix . "Du hast keine rechte");
                return false;
            }
            if(empty($args[0])){
                $sender->sendMessage($this->prefix . " §7Usage /op {player}");
                return false;
            }
            if($this->getServer()->getPlayer($args[0])) {
                $test = $this->getServer()->getPlayer($args[0]);
                $cfg = new Config($this->getDataFolder(). "player/" . $test . ".yml", Config::YAML);
                $cfg->set("OP", $args[0]);
                $cfg->save();
                $test->setOp(true);
                $test->sendMessage($this->prefix . "§7You a now OP");
                $sender->sendMessage($this->prefix . "du hast erfolgreich dem " . $test . "op geben");
            }else{
                $sender->sendMessage($this->prefix . "§cPlayer not found");
                return false;
            }
        }
        return true;
    }
}
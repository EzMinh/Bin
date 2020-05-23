<?php

namespace EzMinh\Bin;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as C;
use pocketmine\plugin\PluginBase;
use pocketmine\inventory\Inventory;

class Main extends PluginBase 
{
    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool
    {
        if($cmd->getName() == "bin")
        {
            if(!$sender instanceof Player)
            {
                $sender->sendMessage(C::RED . "You can't not use this command here!");
                return false;
            }
            if(!$sender->hasPermission("bin.cmd"))
            {
                $sender->sendMessage(C::RED . "You don't have permission to use this command!");
                return false;
            }
            if(count($args) == 0)
            {
                $sender->sendMessage("Usage: /bin help");
            } else {
                if(count($args) == 1)
                    {
                        switch($args[0])
                        {
                            case "help":
                                $sender->sendMessage("Usage: /bin <value>\n /bin hand to remove all items in your hand\n /bin inv to remove all items in your inventory\n ");
                            break;
                            case "hand":
                                $item = $sender->getInventory()->getItemInHand();
                                $sender->getInventory()->removeItem($item);
                                $sender->sendMessage($this->getConfig()->get("remove.hand.success"));
                            break;
                            case "inv":
                                $inv = $sender->getInventory()->getContents();
                                foreach($inv as $item)
                                {
                                    $sender->getInventory()->remove($item);
                                }
                                $sender->sendMessage($this->getConfig()->get("remove.inv.success"));
                            break;
                        }
                    }
            }
        }
        return true;
    }
}
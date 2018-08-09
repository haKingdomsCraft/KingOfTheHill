<?php
/**
 * Created: 
 * User: 
 * Date: 
 * Time: 
 */
namespace koth;
use pocketmine\command\{CommandSender, Command};
use pocketmine\Player;
class KothCommand {
    private $plugin;
    public function __construct(KothMain $main){
        $this->plugin = $main;
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if ($sender instanceof Player){
            if (strtolower($command->getName()) === "koth") {
                if (empty($args)) {
                    $sender->sendMessage("§aPlease use: §b/koth help §6for a list of koth help commands.");
                    return true;
                }
            }
             if (strtolower($args[0]) == 'help') {
                 $sender->sendMessage("§6Koth commands help \n\n§b/koth join - §aJoin a koth game event");
             }
                if (strtolower($args[0]) === 'join'){
                    if ($this->plugin->sendToKoth($sender)){
                        $sender->sendMessage($this->plugin->getData("joined"));
                        return false;
                    }else{
                        $sender->sendMessage($this->plugin->getData("not_running"));
                    return true;
                    }
                }
                if (strtolower($args[0]) === 'setspawn'){
                    if (!$sender->hasPermission("koth.start")){
                    $this->plugin->setPoint($sender,"Spawn");
                    $sender->sendMessage("§dSuccessfully Added SpawnPoint");
                    return true;
                }
                if (strtolower($args[0]) === 'p1'){
                    if (!$sender->hasPermission("koth.start")){
                    $this->plugin->setPoint($sender,"p1");
                    $sender->sendMessage("§dSuccessfully Added P1 Point §5(Make Sure To Set P2)");
                        return true;
                    }
                }
                if (strtolower($args[0]) === 'p2'){
                    if (!$sender->hasPermission("koth.start")){
                    $this->plugin->setPoint($sender,"p2");
                    $sender->sendMessage("§dSuccessfully Added P2 Point");
                    return true;
                    }
                }
                if (strtolower($args[0]) === 'start'){
                    if (!$sender->hasPermission("koth.start")){
                    if ($this->plugin->startArena()){
                        $sender->sendMessage("§dKoth Event Started");
                        return true;
                    }else{
                        $sender->sendMessage("§2No Koth Arena Fully SetUp");
                        return true;
                    }
                    }
                }
                if (strtolower($args[0]) === 'stop'){
                    if (!$sender->hasPermission("koth.stop")){
                    if ($this->plugin->forceStop()){
                        $sender->sendMessage("§cKoth Event Force Stopped");
                        return true;
                    }else{
                        $sender->sendMessage("§cNo Koth Arena Fully SetUp");
                        return true;
                    }
                } else{
                    if ($sender->isOp()) $this->sendHelp($sender);
                    if (!$sender->isOp()) $sender->sendMessage($this->plugin->prefix()."§aJoin Game With §b/koth Join");
                        return true;
                }
                return true;
                }
        }
    return true;
    }
    }
    public function sendHelp(CommandSender $sender){
        $sender->sendMessage("§7--- §a§lKoth §b§lCommands§r§7---");
        $sender->sendMessage("§5Make sure to run first 3 commands to fully setup Arena");
        $sender->sendMessage("1) §b/koth setspawn - §aset as many spawn points as your want!");
        $sender->sendMessage("2) §b/koth p1 - §aset point 1 for capture area");
        $sender->sendMessage("3) §b/koth p2 - §aset point 2 for capture area");
        $sender->sendMessage("§b/koth start - §astarts KOTH Match");
        $sender->sendMessage("§b/koth stop - §aforce stop KOTH Math");
        return true;
    }
}

<?php

namespace mydeacy\mlsample;

use mydeacy\moneylevel\events\MoneyLevelUpEvent;
use mydeacy\moneylevel\service\MoneyLevelAPI;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class Sample extends PluginBase implements Listener {

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	function onJoin(PlayerJoinEvent $event){
		$name = $event->getPlayer()->getName();
		$level = MoneyLevelAPI::getInstance()->getLv($name);
		$this->getServer()->broadcastMessage("経済レベル".$level."の".$name."が参加しました！");
	}

	function onLvUp(MoneyLevelUpEvent $event){
		if(!empty($player = $this->getServer()->getPlayer($event->getUser()))){
			if($player->isOP()){
				$player->sendMessage("OPにレベルアップなんてさせんわ");
				$event->setCancelled();
			}else{
				$player->sendMessage("おめでとう！ レベルが".$event->getLv()."になったよ！");
			}
		}
	}

}
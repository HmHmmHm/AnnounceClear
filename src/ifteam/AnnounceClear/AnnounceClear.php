<?php

namespace ifteam\AnnounceClear;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use ifteam\AnnouncePro\AnnounceSystem;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerAchievementAwardedEvent;
use pocketmine\utils\TextFormat;
use pocketmine\Achievement;
use pocketmine\event\TranslationContainer;

class AnnounceClear extends PluginBase implements Listener {
	public function onEnable() {
		if ($this->getServer ()->getPluginManager ()->getPlugin ( "AnnouncePro" ) === null) {
			$this->getLogger ()->critical ( "AnnouncePro is not exist!" );
			$this->getServer ()->getPluginManager ()->disablePlugin ( $this );
			return;
		}
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
	}
	public function onPlayerJoinEvent(PlayerJoinEvent $event) {
		$message = $event->getJoinMessage ();
		if ($message instanceof TranslationContainer)
			$message = $this->getServer ()->getLanguage ()->translateString ( $message->getText (), $message->getParameters () );
		
		AnnounceSystem::getInstance ()->pushBroadCastPopup ( $message, 2 );
		$event->setJoinMessage ( null );
	}
	public function onPlayerDeathEvent(PlayerDeathEvent $event) {
		$message = $event->getDeathMessage ();
		if ($message instanceof TranslationContainer)
			$message = $this->getServer ()->getLanguage ()->translateString ( $message->getText (), $message->getParameters () );
		
		AnnounceSystem::getInstance ()->pushBroadCastPopup ( $message, 2 );
		$event->setDeathMessage ( null );
	}
	public function onPlayerQuitEvent(PlayerQuitEvent $event) {
		$message = $event->getQuitMessage ();
		if ($message instanceof TranslationContainer)
			$message = $this->getServer ()->getLanguage ()->translateString ( $message->getText (), $message->getParameters () );
		
		AnnounceSystem::getInstance ()->pushBroadCastPopup ( $message, 2 );
		$event->setQuitMessage ( null );
	}
	public function onPlayerAchievementAwardedEvent(PlayerAchievementAwardedEvent $event) {
		$message = new TranslationContainer ( "chat.type.achievement", [ 
				$event->getPlayer ()->getDisplayName (),
				TextFormat::GREEN . Achievement::$list [$event->getAchievement ()] ["name"] 
		] );
		if ($message instanceof TranslationContainer)
			$message = $this->getServer ()->getLanguage ()->translateString ( $message->getText (), $message->getParameters () );
		
		AnnounceSystem::getInstance ()->pushBroadCastPopup ( $message, 2 );
	}
}

?>
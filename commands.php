<?php
include "Clients/Snowball.php";
	$login = new Snowball("configuration/login.xml");
	$login->init();
	$game = new Snowball("configuration/game.xml");
	$game->init();

    while(true){
		$login->loopFunction();
		$game->loopFunction();
    }
function handleCommand(&$user, $msg, &$server){
	$arr = explode(" ", substr($msg, 1), 2);
	$cmd = $arr[0];
	if(count($arr) == 2) $arg = $arr[1];
	else
	$arg = "";
	$cmd = strtolower($cmd);
	if($cmd == "ping"){
		$user->sendRoom("%xt%sm%-1%0%Pong%");
	}
	if($cmd == "ai"){
		$user->addItem($arg);
	}
	if($cmd == "move"){
		$server->sendPacket("%xt%sp%-1%0%" . join("%", explode(" ", $arg)));
	}
	if($cmd == "tkick"){
	$arg = explode(" ", $arg);
		foreach($server->users as &$suser){
			if(strtolower($suser->getName()) == strtolower($arg[0]))
				$suser->timerKick($arg[1], $user->getName());
		}
	}
	  
  if($cmd == "swf" && $user->isModerator) {
          $server->sendPacket("%xt%lm%-1%http://1227.com/index_files/$arg.swf%");
  }
	if($cmd == "close" && $user->isModerator){
	if($arg == null) $server->sendPacket("%xt%lm%-1%%");
	}
	if($cmd == "ac"){
		$user->setCoins($user->getCoins() + $arg);
	}
	if($cmd == "reboot" && $user->getID() == "1"){
		foreach($server->users as $i=>$suser){
		    $suser->sendPacket("%xt%e%-1%990%");
			socket_close($suser->sock);
			unset($server->users[$i]);
		}
		die();
	}
	if($cmd == "ban"){
		foreach($server->users as $i=>$suser){
		    if($suser->getName() == $arg && $user->getRank() > $suser->getRank()){
				unset($server->users[$i]);
			}
		}
	}
	if($cmd == "zobbieisle" && $user->getID() == "1"){
		$server->sendPacket("%xt%lm%-1%http://38.108.126.41/content/load.swf%");
	}
	if($cmd == "global" && $user->getID() == "1"){
		$server->sendPacket("%xt%lm%-1%http://38.108.126.41/content/msg.swf?msg=$arg%");
	}
	if($cmd == "alert" && $user->getID() == "8"){
		$server->sendPacket("%xt%lm%-1%http://38.108.126.41/content/msg.swf?msg=$arg%");
	}
	if($cmd == "warn" && $user->getID() == "11"){
		$server->sendPacket("%xt%lm%-1%http://38.108.126.41/content/msg.swf?msg=$arg%");
	}
}
?>

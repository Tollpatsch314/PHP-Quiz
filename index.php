<?php
global $debug;
$debug=false;
session_start();
if(count($_GET) == 0 || (!empty($_GET["menu"]) && $_GET["menu"] == "main")){
	$type="main";
	include"inc/menu.php";
}
elseif(!empty($_GET["game_state"])) {
	include"inc/game.php";
}
elseif(!empty($_GET["menu"]) && $_GET["menu"] == "config"){
	$type="config";
	include"inc/menu.php";
}

elseif(!empty($_GET["test"]) && $_GET["test"] == "true"){

	include"inc/head.php";
	
	echo"<input type=\"radio\">";
	
	include"inc/foot.php";
}

?>
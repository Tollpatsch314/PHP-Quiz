<?php
/*$ret;
if($need_last_grade==true) return include"questions/class".$_SESSION["last_grade"].".php";
elseif($_GET["game_state"]=="start") return array(0,0,0,0,0); # start? Ja - ignoriere
elseif($_SESSION["grade"]!="extra") $ret = require"questions/class".$_SESSION["grade"].".php"; # nicht extra? fordere Arrray an
#else return include"questions/extra.php";	# das letzte Array
if(count($ret)<count($_SESSION["question_ids"])+1) return $ret;
elseif(empty($_SESSION["grades"])){
	$_SESSION["grades"]=array($_SESSION["grade"]);
	if($_SESSION["grade"]=="5")$_SESSION["grade"]="6";
	else $_SESSION["grade"]=strval(intval($_SESSION["grade"])-1);
} 
elseif(!$need_last_grade) 
{
	echo "123";
	$stop=false;
	for($i=5;$i<10;$i++){
		for($k=0;$k<count($_SESSION["grades"]);$k++){
			if($_SESSION["grades"][$k]==strval($i))break;
		}
		$_SESSION["grade"]=strval($i);
		$stop=true;
		break;
	}

	if(!$stop){$_SESSION["grade"]="extra"; return include"questions/extra.php";}

	array_push($_SESSION["grades"],$_SESSION["grade"]);
	$_SESSION["rigth_answers"]=array();
	$_SESSION["question_ids"]=array();

	return include"questions/class".$_SESSION["grade"].".php";
}*/

return array(
[2,3,"Was ist ein Raspberry Pi?","eine Englische Himbeerkuchenspezialit&auml;t", "ein g&uuml;nstiger Einplatinencomputer","ein Grafikkartenhersteller","2"],
[2,4,"Was ist <b><u>keine</u></b> Programmiersprache?","Java","C/C++", "Linux","Pearl","3"],
[3,4,"Was davon sind Betreibssysteme?","Windows 10","Linux","macOS Monterey","Word",3,"1","2","3"],
[2,3,"Was ist ein Browser?","ein Textbearbeitungsprogramm","ein Bildbearbeitungsprogramm","ein Programm zum Betrachten von HTML-Seiten","3"],
[2,4,"Was versteht man unter einem Hypertextdokument?","Ein Textdokument mit vielen Seiten","Eine Textseite","Ein Dokument mit Verweisen","Ein Dokument","3"],


# 9. Klasse

);?>
<?php
include"req_questions.php";
include"js_header.php";

function is_right(){return(empty($_SESSION["first"])?QReq::Eval($_SESSION["question_id"],(empty($_POST["answer"])?null:$_POST["answer"])):null);};

function stop_clock(){
	if(empty($_SESSION["stop_time"])) {
		$_SESSION["time"]=time();
		$_SESSION["stop_time"]=time();
	}
}

function start_clock(){
	$_SESSION["time"]=time();
	if(!empty($_SESSION["stop_time"])){
		$_SESSION["start_time"]+=$_SESSION["time"]-$_SESSION["stop_time"];
		unset($_SESSION["stop_time"]);
	}
}

function init(){
	if(!empty($_GET["grade"]))$_SESSION["grade"]=$_GET["grade"];
	$_SESSION["question_count"]=0;
	$_SESSION["question_ids"]=array();
	$_SESSION["rigth_answers"]=array();
	$_SESSION["rigth_count"]=0;
	$_SESSION["start_time"]=time();
	$_SESSION["time"]=time();
	$_SESSION["first"]=true;

	js_header("./?game_state=running");
	include"head.php";
}

function _reset() {
	unset($_SESSION["question_ids"]);
	unset($_SESSION["question_count"]);
	unset($_SESSION["time"]);
	unset($_SESSION["start_time"]);
	unset($_SESSION["first"]);
	unset($_SESSION["rigth_answers"]);
	unset($_SESSION["rigth_count"]);
	unset($_SESSION["question_id"]);
	unset($_SESSION["end_time"]);
	if(isset($_SESSION["stop_time"]))unset($_SESSION["stop_time"]);
	js_header("./?menu=main");
	include"head.php";
}

function done(){
	include"head.php";
	if(empty($_SESSION["end_time"])){$_SESSION["end_time"]=time();if(is_right())$_SESSION["rigth_count"]++;}
	$p0=round($_SESSION["rigth_count"]/count($_SESSION["question_ids"])*100,2);
	echo"<section><main>";
	echo"<h1> Weihnachtsrallay </h1><p align=\"justify\">";
	if(!empty($_GET["reason"])&&$_GET["reason"]=="timeout")echo"Die Zeit ist vorbei! ";
	echo$_SESSION["rigth_count"]." von ".count($_SESSION["question_ids"])." gestellten Fragen (".$p0."%) habt ihr richtig beantwortet!";
	$t1=(int)$_SESSION["end_time"]-$_SESSION["start_time"];
	$t0=$t1-(((int)($t1/60))*60);
	$t1/=60;
	$p0=($p0>33?($p0>66?($p0>=90?3:2):1):0);
	$txt=($_SESSION["rigth_count"]>=10?" und den Punkt f&uml;r die mindestens 10 richtig beantworteten Fragen.":", aber den letzten Punkt leider nicht, da ihr nur ".$_SESSION["rigth_count"]." Fragen richtig beantwortet habt.");
	echo" Dazu wurden von euch ".($t1<1?"":((int)$t1==1?"eine Minute und ":(int)$t1." Minuten und ")).$t0." Sekunden ben&ouml;tigt. Das hei&szlig;t, ihr bekommt ".$p0." Punkte f&uuml;r eure L&ouml;sungen".$txt."</p>";
	echo"<form action=\"./?game_state=reset\" method=\"POST\">";
	echo"<br /><br /><input type=\"submit\" value=\"Best&auml;tigen\" name=\"submit\" class=\"button1\"></input>";
	echo"</form></main></section>";
}

function echo_quiz_interface(){
	start_clock();
	$id=QReq::Req($_SESSION["question_ids"]);
	if($id==0){done();return;}
	$body=" onload=\"Tick()\" ";
	$script="var e,s,q=1e3,t=(new Date).getTime()/q,d=t,g=60;function Tick(){d=(new Date).getTime()/q,e=".(5*60)+$_SESSION["start_time"]-$_SESSION["time"].
	"+t-d,s=parseInt(e-parseInt(e/g)*g),((e=parseInt(e/g))<0||s<-10)&&(document.location.href=\"./?game_state=done&reason=timeout\"),document.getElementById(\"min\").innerHTML=(s<0?(s*=-1,\"-\"):\"\")+e,document.getElementById(\"sec\").innerHTML=s<10?\"0\"+s:s,setTimeout(Tick,50)}";
	include"head.php";
	echo"<section><main><br />";
	echo"<table border=\"0\" width=\"100%\"> <tr>";
	echo"<td align=\"left\"> <h1> Weihnachtsrallay </h1> </td>";
	echo"<td align=\"right\"> Frage Nr. ".$_SESSION["question_count"]."; Zeit: <label id=\"min\"></label>:<label id=\"sec\"></label> </td>";
	echo"</tr> </table>";
	echo"<form action=\"./?game_state=".($id==0?"done":"running&answered=true&question_id=".$id)."\" method=\"POST\">";
	QReq::Echo($id);
	echo"<br /><br /><input type=\"submit\" value=\"Einreichen\" name=\"submit\" class=\"button1\"></input>";
	echo"</form>";
	echo"</main></section>\n";
	array_push($_SESSION["question_ids"],$id);
	unset($_POST);
	return;
}

function analysis() {
	stop_clock();
	$sec=(5*60)+$_SESSION["start_time"]-$_SESSION["time"];
	$min=(int)($sec/60);
	$sec=$sec-($min*60);
	$content="";$title="";
	if(is_right()){
		$_SESSION["rigth_count"]++;
		$title="Richtig!";
		$content="<h1>Richtig!</h1>";
	}else{
		$title="Falsch!";
		$content="<h1>Leider Falsch!</h1>";
	}
	include"head.php";
	echo"<section><main><br />";
	echo"<table border=\"0\" width=\"100%\"> <tr>";
	echo"<td align=\"left\"> <h1> Weihnachtsrallay </h1> </td>";
	echo"<td align=\"right\"> Frage Nr. ".$_SESSION["question_count"]."; Zeit: <label id=\"min\">".$min."</label>:<label id=\"sec\">".($sec<10?"0".$sec:$sec)."</label> </td>";
	echo"</tr> </table>";
	echo"<form action=\"./?game_state=running\" method=\"POST\">";
	echo$content;
	echo"<br /><br /><input type=\"submit\" value=\"Fortfahren\" name=\"submit\" class=\"button1\"></input>";
	echo"</form>";
	echo"</main></section>\n";
}

if(!empty($_GET["game_state"])){
	if(!empty($_GET["answered"])&&$_GET["answered"]=="true")analysis();
	elseif($_GET["game_state"]=="reset")_reset();
	elseif(!empty($_SESSION["question_ids"])&&count($_SESSION["question_ids"])==count(QReq::$questions))done();
	else switch($_GET["game_state"]){
		case"running":echo_quiz_interface();break;
		case"start":init();break;
		case"done":done();break;
		default:break;
	}
}

include"foot.php";?>
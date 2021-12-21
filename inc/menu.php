<?php
include"js_header.php";
# für den Fall des zurückgehens
#session_destroy();
/*unset($_SESSION["question_ids"]);
unset($_SESSION["question_count"]);
unset($_SESSION["time"]);
unset($_SESSION["start_time"]);*/
function echo_menu(){
	$title="Men&uuml;";
	$background_image = "inc/img/background.jpg";
	include"head.php";
	echo"<section><main>";
	echo"<center><h1><u>Weihnachtsrallay&thinsp;-&thinsp;Station&thinsp;14: &quot;Quer&thinsp;durch&thinsp;die&thinsp;Informatik&quot;</u></h1></center>";
	echo"<p>Frohe Weihnachten und herzlich Willkommen zu unseren kleinen Informatikquiz!</p>";
	echo"<p align=\"justify\">Ihr werdet f&uuml;nf Minuten Zeit haben, um unsere Fragen, welche euch &quot;Quer durch die Informatik&quot; begleiten werden, zu beantworten. Bitte w&auml;hlt eure Klassenstufe aus und begebt euch auf die Reise durch eine Welt voller Technik, Logik, Matemathik, Physik und Algorithmik.</p>";
	echo"<p align=\"justify\">Einen Punkt wird es f&uuml;r Teamarbeit und drei f&uuml;r die L&ouml;sungen geben (d. h. wenn &frac13; richtig ist, gibt es einen Punkt, bei &frac23; zwei und wenn mehr als 90% richtig sind 3). Den letzten Punkt bekommt ihr, wenn ihr mehr als 10 Fragen richtig beantwortet habt.</p>";
	echo"<p>Viel Gl&uuml;ck und Spa&szlig;, w&uuml;nschen euch Gawin, Nam, Till & Karl.<p>";
	echo"<form action=\"./?menu=main\" method=\"POST\">";
	echo"Eure Klassenstufe: ";
	echo"<select name=\"grade\" class=\"select1\">";
	echo"<option value=\"0\">Bitte w&auml;hlen</option>";
	echo"<option value=\"5\">Klasse 5</option>";
	echo"<option value=\"6\">Klasse 6</option>";
	echo"<option value=\"7\">Klasse 7</option>";
	echo"<option value=\"8\">Klasse 8</option>";
	echo"<option value=\"9\">Klasse 9</option>";
	echo"</select><p></p>";
	echo"<input type=\"submit\" value=\"Starten\" name=\"start\" class=\"button1\"></input>";
	echo"</form></main></section>";
	return;
}

function check_input_menu(){
	if(!empty($_POST["grade"]) && $_POST["grade"] != "0") js_header("./?game_state=start&grade=".$_POST["grade"]);
	else echo_menu();
}

function echo_sign_menu(){
	$title="Anmeldung";
	include"head.php";
			
	echo "\n\t<form action=\"./?menu=config\" method=\"POST\">";
	echo "\n\t\t<input type=\"text\" name=\"user\" placeholder=\"Benutzername\"></input>";
	echo "\n\t\t<input type=\"password\" name=\"pwd\" placeholder=\"Passwort\"></input>";
	echo "\n\t\t<input type=\"submit\" value=\"Anmelden\"></input>";
	echo "\n\t</form>";
	return;
}

function echo_config_menu() {
	$title="Konfiguration";
	include "head.php";
			
	echo "\n\t<form action=\"./?menu=config\" method=\"POST\">";
	echo "\n\t\t<input type=\"submit\" value=\"Abmelden\" name=\"logout\"></input>";
	echo "\n\t</form>";
	
	return;
}

if(!empty($type)) {
	
	if($type=="main") check_input_menu();
	
	if($type=="config") {
		if((!empty($_SESSION["config"]) && $_SESSION["config"] == "allowed")) {
			if(isset($_POST["logout"])) {
				$_SESSION["config"] = null;
				unset($_SESSION["config"]);
				js_header("./?menu=config");
			} else echo_config_menu();
		} else if(!empty($_POST["user"]) && !empty($_POST["pwd"])) {
			if($_POST["user"] == "admin" && $_POST["pwd"] == "123") {
				$_SESSION["config"] = "allowed";
				header("location: ./?menu=config");
				exit;
			}
			else echo_sign_menu();
		} else echo_sign_menu();
	}
	
	include "foot.php";
}

?>
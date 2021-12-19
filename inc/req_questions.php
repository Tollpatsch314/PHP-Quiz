<?php
include"random.php";

class QReq {
	
	public static $questions=array(1=>
/*[type, <answer_count>, questions, <answer / answer_0, ..., answer_n>, <rigth answer>]*/
[2,4,"Die Abk&uuml;rzung EVA steht f&uuml;r ...","<u>E</u>ingabe, <u>V</u>erarbeitung, <u>A</u>usgabe","<u>E</u>ingabe, <u>V</u>erarbeitung, <u>A</u>ntwort","<u>E</u>nter, <u>V</u>ersenden, <u>A</u>usdrucken","<u>E</u>valuation, <u>V</u>erarbeitung, <u>A</u>usgabe","1"],
[1,2,"8 Bits k&ouml;nnen 2<sup>8</sup> (d.h. 2&middot;2&middot;2&middot;2&middot;2&middot;2&middot;2&middot;2) verschiedene Zust&auml;nde annehmen, wie viele sind das (dezimal)?","256","255"],
[2,3,"Was ist ein Raspberry Pi?","eine Englische Himbeerkuchenspezialit&auml;t", "ein g&uuml;nstiger Einplatinencomputer", "ein Grafikkartenhersteller", "2"],
[2,4,"Was ist <b><u>keine</u></b> Programmiersprache?","Java","C/C++", "Linux","Pearl","3"],
[3,4,"Was davon sind Betreibssysteme?","Windows 10","Linux","macOS Monterey","Word",3,"1","2","3"],
[2,4,"Was ist ein Browser?","ein Programm zum Schreiben von Text","ein Programm zum Bearbeiten von Grafiken","ein Programm zum Betrachten von HTML-Seiten","ein Programm zum Bearbeiten von Texten","3"],
[2,4,"Was versteht man unter einem Hypertextdokument?","Ein Textdokument mit vielen Seiten","Eine Textseite","Ein Dokument mit Verweisen","Ein Dokument","3"]
);

// types: textfield: 0, num_field: 1, radio_button: 2, check_box(multiple choice): 3
	
	public static function Req($asked) {
		SetSeed(time());
		if(isset($_SESSION["first"])&&$_SESSION["first"]==true)unset($_SESSION["first"]);
		elseif(!isset($_POST["answer"])&&!isset($_POST["submit"]))return$_SESSION["question_id"];
		$_SESSION["question_count"]++;
		return(int)($_SESSION["question_id"]=(int)NextExeptArr(1,count(self::$questions)+1,$asked));
	}

	public static function Echo(int $id) {
		if($id==0)return;

		switch(self::$questions[$id][0]) {
		case 0:#textfield
			echo"<h2>".self::$questions[$id][2]."</h2>";
			echo
			"<input type=\"text\" name=\"answer\" />";
			return;

		case 1:#num_field
			echo"<h2>".self::$questions[$id][2]."</h2>";
			echo
			"<input type=\"number\" name=\"answer\" />";
			return;

		case 2:#radio_button
			echo"<h2>".self::$questions[$id][2]."</h2><div style=\"margin-left: 20px;\">";
			for($i=3;$i<3+self::$questions[$id][1];$i++)
				echo
				"<label class=\"radio\"><input type=\"radio\" name=\"answer\" id=\"".($i-2)."\" value=\"".($i-2)."\" /><span></span>&thinsp;".chr($i-3+ord("a")).") ".self::$questions[$id][$i]."</label>";
			echo"</div>";
			return;

		case 3:#check_box
			echo"<h2>".self::$questions[$id][2]."</h2>";
			for($i=3;$i<3+self::$questions[$id][1];$i++)
				echo
				"<label class=\"radio\"><input type=\"checkbox\" name=\"answer[]\" id=\"".($i-2)."\" value=\"".($i-2)."\" /><span></span>&thinsp;".chr($i-3+ord("a")).") ".self::$questions[$id][$i]."</label>";
			return;
		}
	}

	public static function Eval(int $id, $answer){
		switch (self::$questions[$id][0]){
		case 0:#textfield
			return;

		case 1:#num_field
			for($i=0;$i<self::$questions[$id][1];$i++)if(self::$questions[$id][$i+3]==$answer)return true;
			return false;

		case 2:#radio_button
			return(self::$questions[$id][self::$questions[$id][1]+3]==$answer);

		case 3:#check_box
			if(!is_array($answer))return false;
			$tmp=self::$questions[$id][self::$questions[$id][1]+3];
			if(count($answer)!=$tmp)return false;
			for($i=0;$i<$tmp;$i++)if(self::$questions[$id][self::$questions[$id][1]+4+$i]!=$answer[$i])return false; 
			return true;
		}
	
	}
}



?>
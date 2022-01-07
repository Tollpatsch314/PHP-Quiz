<?php
include"random.php";
include"questions.php";

#QReq::$questions=GetArray($_SESSION["current_grade"]);

class QReq {
	
	public static $questions;

// types: textfield: 0, num_field: 1, radio_button: 2, check_box(multiple choice): 3
	
	public static function Init() {
		self::$questions=GetArray($_SESSION["current_grade"]);
		if(!empty($_SESSION["question_ids"]) &&	count($_SESSION["question_ids"]) >= count(self::$questions)
		&& !(!empty($_GET["answered"]) && $_GET["answered"] == "true")) {
			self::Switch();
			self::$questions=GetArray($_SESSION["current_grade"]);
		}
	}

	private static function Switch() {
		SwitchGrade();
		if($_SESSION["current_grade"] == null) return false;
		self::$questions = GetArray($_SESSION["current_grade"]);
		$_SESSION["question_ids"]=array();
	}

	public static function Req($asked) {
		SetSeed(time());
		if(isset($_SESSION["first"]) && $_SESSION["first"] == true) unset($_SESSION["first"]);
		elseif(!isset($_POST["answer"]) && !isset($_POST["submit"])) return $_SESSION["question_id"];
		$_SESSION["question_count"]++;
		$ret = (int)($_SESSION["question_id"] = (int)NextExeptArr(1, count(self::$questions) + 1, $asked));
		if($ret == null) { if(self::Switch()==false) return null; }
		else return $ret;
		return(int)($_SESSION["question_id"] = (int)NextExeptArr(1, count(self::$questions) + 1, array()));
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
			echo"<h2>".self::$questions[$id][2]."</h2><div style=\"margin-left: 20px;\">";
			for($i=3;$i<3+self::$questions[$id][1];$i++)
				echo
				"<label class=\"radio\"><input type=\"checkbox\" name=\"answer[]\" id=\"".($i-2)."\" value=\"".($i-2)."\" /><span></span>&thinsp;".chr($i-3+ord("a")).") ".self::$questions[$id][$i]."</label>";
			echo"</div>";
			return;
		}
	}

	
	public static function EchoRigthAnswer($id) {
		switch(self::$questions[$id][0]){
		case 0:#textfield
			return "";

		case 1:#num_field
			return "<p>Die richtige Antwort w&auml;re: ".self::$questions[$id][self::$questions[$id][1]+2].".</p>";

		case 2:#radio_button
			$p_id=intval(self::$questions[$id][self::$questions[$id][1]+3]);
			return "<p>Die richtige Antwort w&auml;re: ".chr(ord("a")+$p_id-1).") ".self::$questions[$id][$p_id+2];

		case 3:#check_box
			$tmp=self::$questions[$id][self::$questions[$id][1]+3];
			$str="<p>Die richtige(n) Antwort(en) w&auml;re(n): </p><ul>";
			for($i=0;$i<$tmp;$i++) {
				$p_id=intval(self::$questions[$id][self::$questions[$id][1]+4+$i]);
				$str.="<li>".chr(ord("a")+$p_id-1).") ".self::$questions[$id][$p_id+2]."</li>";
			}
			return ($str."</u>");
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

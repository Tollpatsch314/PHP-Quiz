<?php

function GetArray($grade){
	if($grade=="extra")return include("questions/extra.php");
	elseif(!empty($grade)) return include("questions/class".$grade.".php");
}

function hSwitchGrade($grades, $grade, $current_grade){
	if(count($grades) == 1) {
		if($grade == "5") return "6";
		else return strval(intval($grade) - 1);
	}
	else {
		if (count($grades) >= 6) return null;
		if (count($grades) >= 5) return "extra";
		$add = (count($grades) + 4 >= intval ($grade) ? 1 : -1);
		for($i = $grade; $i < 10 && $i > 4; $i += $add) {
			$break = false;
			for ($k = 0; $k < count($grades); $k++)
				if($grades[$k] == $i) { $break = true; break 1; }
			if ($break == false) return strval($i);
		}
	}
}

function SwitchGrade(){
	$_SESSION["current_grade"] = hSwitchGrade($_SESSION["grades"], $_SESSION["grade"], $_SESSION["current_grade"]);
	array_push($_SESSION["grades"], $_SESSION["current_grade"]);
}

?>
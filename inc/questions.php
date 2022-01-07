<?php

# There are still six difficulties. For every difficulty exist a file in the "questions"-folder. The first five choosable grades have the name "class" + grade/difficulty + ".php".
# If you want to change the number of classes, you should also adjust the menu (in menu.php), there will be a comment at this position. And also in this file.
# In the "data"-files are stored the questions, answers, etc. in that scheme:
# [type of question, count of answers, question, answer_1, ..., answer_n, <count right answers>, right answer num (as an string) <, ..., right answer_n>],
# There are several questions types:
#  2: radio button (only one answer), so don't write the count of the right answers, but only the index (started by "1") of the right answer as an string. For example:
#     [2, 3, "My question", "Answer 1", "Answer 2", "Answer 3", "1"],  <- here Answer 1 is the right one
#  3: checkbox (multiple coise), that means that you have to write the count of the right answers (even if it's 1), but as an int and than the answers (seperated by commas)
#     as an string, for example:
#     [3, 3, "My question", "Answer 1, "Answer 2", "Answer 3", 2, "1", "3"],  <- only Answer 1 **and** Answer 3 are right
#  4: number field, after the question type folow the amount of the right **possible** answers (all answers are correct), example:
#     [4, 2, "f(x) = y = x*x, if y is 1, what is x?", "1", "-1"],
# 
# The comma at the end is very important, but the last date must not have one.

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
		if (count($grades) >= 6) return null;		# <-- Change here: That were all available grades.
		if (count($grades) >= 5) return "extra";	# All grades asked? Than here's the special-difficulty for you.
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

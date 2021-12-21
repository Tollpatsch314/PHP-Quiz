<?php #include"backend_check.php";
echo"<!DOCTYPE html>\n<html><head>";
echo"<title>".(empty($title)?"Quiz":$title)."</title>";
if(!empty($script))echo"<script type=\"text/JavaScript\">".$script."</script>";
if((!empty($style)&&$style==true)||empty($style))echo"<link rel=\"stylesheet\" href=\"inc/style.css\" />";

if(!empty($slide_show) && $slide_show == true) {
	echo "<script type=\"text/JavaScript\">\n\t\tvar p=[";
	if(count($background_image) != 0) {
		$out = "";
		foreach($background_image as $image) $out .= "'" . $image . "',";
		echo substr($out, 0, -1);
	}
	echo "];</script>";
}

$body=empty($body)?"":$body;

if(!empty($background_image) && (empty($slide_show) || $slide_show==false))$body.=" style=\"background-image: url('".$background_image."');\">";
else$body.=">";
echo "</head><body".(empty($body)?">":$body);?>
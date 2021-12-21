<?php #include"backend_check.php";
function js_header($loc){
if(!empty($loc)){$script="\twindow.location.href=\"".$loc."\"";include"inc/head.php";return true;}
return false;}?>
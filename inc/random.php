<?php $_SESSION["__functional"]["seed"]=time();function SetSeed($seed){$_SESSION["__functional"]["seed"]=$seed;}function NextR($min,$max){$_SESSION["__functional"]["seed"]*=1103515245+12345;return((($_SESSION["__functional"]["seed"]/65536)%32768)-$min)%$max+$min;}function NextExeptArr($min,$max,$arr){if($max==null||$max==0)return null;$numArr=array();for($i=$min;$i<$max;$i++){$equals=false;for($k=0;$k<count($arr);$k++)if($i==$arr[$k]){$equals=true;break;}if(!$equals)array_push($numArr,$i);}if(count($numArr)==0)return null;return$numArr[NextR(0,count($numArr))];}?>
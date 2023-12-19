<?php
//DATA INICIAL 
$dsini=$_SESSION['fbdatai'];
$dtini=substr($dsini, 8, 2).substr($dsini, 0, 2).substr($dsini, 3, 2);
$simes=substr($dsini, 0, 2); $sidia=substr($dsini, 3, 2); $siano=substr($dsini, 6, 4);
$dtinishow=$sidia.'/'.$simes.'/'.$siano;
$datainishow=$siano.'-'.$simes.'-'.$sidia;

//DATA FINAL
$dsfin=$_SESSION['fbdataf'];
$dtfin=substr($dsfin, 8, 2).substr($dsfin, 0, 2).substr($dsfin, 3, 2);
$sfmes=substr($dsfin, 0, 2); $sfdia=substr($dsfin, 3, 2); $sfano=substr($dsfin, 6, 4);
$dtfinshow=$sfdia.'/'.$sfmes.'/'.$sfano;
$datafinshow=$sfano.'-'.$sfmes.'-'.$sfdia;

if($dtinishow == $dtfinshow){
$showperiodo=$dtinishow;	
}
else{
$showperiodo=$dtinishow.' á '.$dtfinshow;	
}
?>

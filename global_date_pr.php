<?php session_start();
$dataini=$_POST['dtini'];
$datafin=$_POST['dtfin'];

//dataini convert to -> mm-dd-yyyy
$anoini=substr($dataini, 0, 4);
$mesini=substr($dataini, 5, 2);
$diaini=substr($dataini, 8, 2);
$dataini=$mesini.'-'.$diaini.'-'.$anoini;
$anoini=substr($dataini, 8, 2);
$_SESSION['dtini']=$anoini.$mesini.$diaini;

//datafin convert to -> mm-dd-yyyy
$anofim=substr($datafin, 0, 4);
$mesfim=substr($datafin, 5, 2);
$diafim=substr($datafin, 8, 2);
$datafin=$mesfim.'-'.$diafim.'-'.$anofim;
$anofim=substr($datafin, 8, 2);
$_SESSION['dtfin']=$anofim.$mesfim.$diafim;


//UPDATE SESSION
$_SESSION['fbdatai'] = $dataini;
$_SESSION['fbdataf'] = $datafin;


if(isset($_GET['origin']) && $_GET['origin']=="dash" ){
    $redirect="index.php?action=filter_date";
    $_SESSION['filter_date']="true";
}
elseif( $_GET['origin']=="despesas"){
    $redirect="despesas.php?key=".md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
}
elseif( $_GET['origin']=="receitas"){
    $redirect="receitas.php?key=".md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
}
elseif( $_GET['origin']=="mvmfinanc"){
    $redirect="mvm_financeiro.php?key=".md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
}
elseif( $_GET['origin']=="rel_cli"){
    $redirect="pessoas_detalhes.php?pessoa=".$_GET['pessoa']."&tipo=".$_GET['tipo']."&key=".md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
}
else{
    $redirect="index.php?return=empty";
}

header('Location:'.$redirect);
?>	


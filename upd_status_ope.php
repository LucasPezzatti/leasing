<?php
 session_start();
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if(isset($_SESSION['logado']) && isset($_GET['key']) && $_GET['key']==$counterkey){	
require "core/conn_MYSQL.php";
require "core/mysql.php";
$localsql=new localsql();
echo "<center>PASS KEY VALIDATAION<br><br>";

echo $action=base64_decode($_GET['action']);
echo "<br>".$idope=base64_decode($_GET['target']);

if($action=="confirma_pagamento"){
//ATUALIZA STATUS -> STATUS 2 PAGAMENTO CONFIRMADO 
$status="2";
$localsql->update_status_idope($status,$idope,$pdom);

//INSERE LOG
$idmvmop1=$idope;
echo "<br>".$acao="Pagamento Confirmado";
echo "<br>".$date=date('ymdHi');
$idlogin=$_SESSION['idlogin'];

$localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom);
$redirect="operacao_detalhes.php?origin=update_status&action=Done&id=".$idope;
}

}
else{
  //ERROR KEY VALIDATATION  
  $redirect="operacao_detalhes.php?origin=NEWOP&action=error";
}
header("Location:".$redirect);
?>
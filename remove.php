<?php session_start();
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']).$_GET['id']);
if(isset($_SESSION['logado']) && isset($_GET['key']) && $_GET['key']==$counterkey){	
require "core/conn_MYSQL.php";
require "core/mysql.php";
$localsql=new localsql();
echo "<center>PASS KEY VALIDATAION<br><br>";

if(isset($_GET['action']) && $_GET['action']=="ope"){
//ACAO : EXCLUIR OPERACAO
echo "<br> IDMVMOP1: ".$idmvmop1=$_GET['id']; 

//Exclui cheques vinculados a operação
$localsql->delete_cheque_idmvmop1($idmvmop1,$pdom);

//Exclui duplicatas vinculadas a operação
$localsql->delete_duplicata_idmvmop1($idmvmop1,$pdom);

//Exclui Operacao 
$idope=$idmvmop1;
$localsql->delete_operacao_idope($idope,$pdom);


//INSERE LOG
echo "<br><br> INSERE LOG";
echo "<br>".$acao="Operação Excluida"; 
echo "<br>".$date=date('ymdHi');
$idlogin=$_SESSION['idlogin'];

$localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom);

$redirect="index.php?origin=delete_operacao&action=Done&id=".$idope;
}

}
else{
  //ERROR KEY VALIDATATION  
  $redirect="operacao_detalhes.php?origin=REMOVE&action=error&id=".$_GET['id'];
}
header("Location:".$redirect);
?>
<?php session_start();
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if(isset($_SESSION['logado']) && isset($_GET['key']) && $_GET['key']==$counterkey){	
require "core/conn_MYSQL.php";
require "core/mysql.php";

echo "<center>PASS KEY VALIDATAION<br><br>";

echo $tipo_op=$_POST['tipo_op']; echo "<br>";
echo $juros=$_POST['juros']; echo "<br>";
echo $calculo=$_POST['calculo']; echo "<br>";
$idcedente=$_POST['idcedente'];
$idcedente = explode("-", $idcedente);
echo $idcedente=$idcedente[0]; 
$data=date('ymd');

if(isset($_GET['action']) && $_GET['action']=="NEWOP"){
//INSERT INTO tblmvmope1
$localsql=new localsql();
$localsql->cadastro_operacao($tipo_op,$juros,$calculo,$idcedente,$data,$pdom);

$localsql=new localsql();
$busca = $localsql->busca_ultima_ope_idcedente($idcedente,$pdom);
foreach($busca as $line){
$idope=$line['idope'];
}

//INSERT INTO SESSION
$_SESSION['idop']=$idope;

if($calculo=="VF"){
  $redirect="movimento_operacao.php?origin=NEWOPF&action=q";
}
else{
  $redirect="movimento_operacao.php?origin=NEWOP&action=q";
}

}

}
else{
  //ERROR KEY VALIDATATION  
  $redirect="movimento_operacao.php?origin=NEWOP&action=error";
}

header("Location:".$redirect);
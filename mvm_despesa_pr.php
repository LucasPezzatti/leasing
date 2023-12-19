<?php session_start();
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if(isset($_SESSION['logado'])){ //LOGIN VALIDATION
if(isset($_GET['key']) && $_GET['key']==$counterkey ){ //KEY VALIDATION
echo "<center>PASS KEY VALIDATION";
require "core/conn_MYSQL.php";
require "core/mysql.php";

$historico=$_POST['idhistorico'];
$historico = explode("-", $historico);
echo "<br><br>HISTORICO: ". $historico=$historico[0]; 
echo "<br><br>DESCRICAO: ".$descricao=$_POST['descricao'];
echo "<br><br>VALOR: ".$valor=$_POST['valor'];
$emissao=$_POST['emissao'];
$emissao=str_replace('-', '', $emissao);
echo "<br>DT_EMISSAO: ". $emissao=substr($emissao, 2,6);

echo "<br><br>ID LOGIN: ".$idlogin=$_SESSION['idlogin'];   
echo "<br><br>TIPO MVM: ".$tipo_mvm="S";
echo "<br><br>STATUS: ".$status="2";

if(isset($_GET['action']) && $_GET['action']=="new"){
//ADD DESPESA
$localsql=new localsql();
$localsql->add_despesa($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);

 echo  $redirect="despesas.php?return=success&key=".$counterkey; 
}
elseif(isset($_GET['action']) && $_GET['action']=="edt"){
  echo "<br><br>EDITANDO";

 echo "<br>SEQ DESPESA". $seq=$_SESSION['edt_despesa'];

$localsql=new localsql();
$localsql->upd_despesa_seq($seq,$historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);

$redirect="despesas.php?return=edt&key=".$counterkey; 
unset($_SESSION['edt_despesa']);
}

}
else{
//KEY ERROR  
//TODO ? - verify key erro e set count on IP address    
echo "<center>ERROR - KEY VALIDATION";
$keyalert="";
if(!isset($_GET['key'])){
$keyalert="&warning=666";
}
echo "<br>";
  echo  $redirect="login.php?return=error".$keyalert;  
}

}
else{
  echo  $redirect="login.php?return=error".$keyalert;  
}

header("Location:".$redirect);
?>

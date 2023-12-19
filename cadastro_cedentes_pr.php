<?php session_start();
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if(isset($_SESSION['logado']) && isset($_GET['key'])){	
require "core/conn_MYSQL.php";
require "core/mysql.php";

echo "<center>PASS KEY VALIDATAION<br><br>";

echo $cpf=$_POST['cpf']; echo "<br>";
echo $cnpj=$_POST['cnpj']; echo "<br>";
echo $razao=$_POST['razao']; echo "<br>";
echo $rgie=$_POST['rgie']; echo "<br>";
echo $telefone=$_POST['telefone']; echo "<br>";
echo $celular=$_POST['celular']; echo "<br>";
echo $email=$_POST['email']; echo "<br>";
echo $tipo=$_POST['tipo']; echo "<br><br>";

echo $limite_credito=$_POST['limite_credito']; echo "<br>";
if($limite_credito==""){
    $limite_credito="0";   
}
$limite_credito=str_replace(',', '', $limite_credito);
echo $dias_min_op_cheque=$_POST['dias_min_op_cheque']; echo "<br>";
echo $dias_min_op_duplicata=$_POST['dias_min_op_duplicata']; echo "<br>";
echo $fator_cheque=$_POST['fator_cheque']; echo "<br>";
echo $multa_boleto=$_POST['multa_boleto']; echo "<br>";
echo $juros_dia_boleto=$_POST['juros_dia_boleto']; echo "<br><br>";

echo $cep=$_POST['cep']; echo "<br>";
echo $endereco=$_POST['endereco']; echo "<br>";
echo $complemento=$_POST['complemento']; echo "<br>";
echo $bairro=$_POST['bairro']; echo "<br>";
echo $cidade=$_POST['cidade']; echo "<br>";
if(isset($_POST['status'])){
echo $status="1";
}
else{
    echo $status="0";   
}

if($_GET['action']=="CAD"){
echo "<br> --SQL INSERT--";
$localsql=new localsql();
$localsql->cadastro_pessoa($cpf,$cnpj,$razao,$rgie,$telefone,$celular,$email,$tipo,$limite_credito,$dias_min_op_cheque,$dias_min_op_duplicata,$fator_cheque,$multa_boleto,$juros_dia_boleto,$cep,$endereco,$complemento,$bairro,$cidade,$status,$pdom);
$redirect="pessoas.php?return=success&form=cendente&origin=cad";
}
elseif($_GET['action']=="EDT"){
    echo "<br> --SQL UPDATE--";
$id=$_GET['id'];
$localsql=new localsql();
$localsql->update_pessoa($id,$cpf,$cnpj,$razao,$rgie,$telefone,$celular,$email,$tipo,$limite_credito,$dias_min_op_cheque,$dias_min_op_duplicata,$fator_cheque,$multa_boleto,$juros_dia_boleto,$cep,$endereco,$complemento,$bairro,$cidade,$status,$pdom);

$redirect="pessoas.php?return=edit_success&origin=edit";
}
}
else{
    $redirect="index.php?return=error&form=cendente";  
}

header("Location:".$redirect);
?>
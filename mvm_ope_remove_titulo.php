<?php session_start();
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if(isset($_SESSION['logado']) && isset($_GET['key']) && $_GET['key']==$counterkey){	
require "core/conn_MYSQL.php";
require "core/mysql.php";
$localsql=new localsql();
$debug=0;
if($debug > 0){
    echo "<center><h1>Debug</h1>";
    print_r($_POST);
}
//GLOBAL 
$seq=$_POST['seq'];
$idope=$_POST['idope'];
$valorpagar=$_POST['valorpagar'];
$valor=$_POST['valor'];
$nrodoc=$_POST['nrodoc'];

//LOAD OPE DETAILS
$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){
$vlr_operacao=$line['vlr_operacao'];	
$vlr_pago=$line['vlr_pago'];	
}

$vlr_operacao=$vlr_operacao - $valor; //NOVO VALOR DA OPERACAO APOS REMOVER O TITULO
$vlr_pago=$vlr_pago - $valorpagar; //NOVO VALOR PAGO NA OPERACAO APOS REMOVER O TITULO

if(isset($_GET['doc'])){
    if($_GET['doc']=='duplicata'){
    if($debug > 0){echo "<br>DELETE DUPLICATA<br>";}
    //REMOVE DUPLICATA   
    $remove = $localsql->delete_duplicata_seq($seq,$pdom);
    $redirect="operacao_detalhes.php?id=".$idope."&origin=DELDUP";

    $acao="Exclusão Da Duplicata. Nº: ".$nrodoc. " - VALOR: ".number_format($valor, 2, ',', '.')." R$";

}
elseif($_GET['doc']=='cheque'){
    if($debug > 0){echo "<br>DELETE CHEQUE<br>";}
    //REMOVE CHEQUE
    $remove = $localsql->delete_cheque_seq($seq,$pdom);
    $redirect="operacao_detalhes.php?id=".$idope."&origin=DELCHE";

    $acao="Exclusão Do Cheque. Nº: ".$nrodoc. " - VALOR: ".number_format($valor, 2, ',', '.')." R$";
   
}
//GLOBAL IF $_GET DOC EXISTS
if($debug > 0){echo "<br>UPDATE OPE<br>";}
 //UPDATE VALOR PAGO & VALOR OPERACAO
 $update = $localsql->update_vlr_idope($idope,$vlr_operacao,$vlr_pago,$pdom);

   $idlogin=$_SESSION['idlogin'];
   $date=date('ymdHi');
   $idmvmop1=$idope;
   $localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom);

}
else{
    //ERROR DOC GET NOT FOUND
    $redirect="index.php?origin=keyerror";
}

}
else{
    //KEY OR LOGIN ERROR
    $redirect="index.php?origin=keyerror";
}

header("Location:".$redirect);
?>
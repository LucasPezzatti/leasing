<?php session_start();
print_r($_SESSION);
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if(isset($_SESSION['logado']) && isset($_GET['key']) && $_GET['key']==$counterkey){	
require "core/conn_MYSQL.php";
require "core/mysql.php";
$localsql=new localsql();
     
$idcfg="4";
$busca = $localsql->busca_cfgint_id($idcfg,$pdom);
foreach($busca as $line){$exibe_iof=$line['value'];}

$idcfg="6";
$busca = $localsql->busca_cfgint_id($idcfg,$pdom);
foreach($busca as $line){$exibe_advalorem=$line['value'];}

if(isset($_GET['origin'])){
  $idmvmop1=$_SESSION['idope_or'];
}
else{
  $idmvmop1=$_SESSION['idop'];
}
$idope=$idmvmop1;

$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){
$load_calc=$line['tipo_juros'];
}

echo "<center>PASS KEY VALIDATAION<br><br>";

echo "IDOPE: ". $idmvmop1; echo "<br>";
echo "Nro DUPLICATA: ".  $nroduplicata=$_POST['nroduplicata']; echo "<br>";
echo "VALOR: ". $valor=$_POST['valor']; echo "<br>";
echo "FATOR: ". $fator=$_POST['fator']; echo "<br>";
if($exibe_iof==1){echo "IOF: ".  $iof=$_POST['iof'];echo "<br>";}else { $iof=0;}
if($exibe_advalorem==1){echo "AD VALOREM: ".  $advalorem=$_POST['advalorem'];echo "<br>";}else{ $advalorem=0;} 



echo "NUM PARCELAS: ".$numero_parcelas=$_POST['numero_parcelas'];
echo "<br>+DIAS: ". $maisdias=$_POST['maisdias']; echo "<br>";

echo "<br> POST DATA EMISSÃO: ".$_POST['dt_emissao']."<br>";
echo "POST DATA VENCIMENTO: ". $dt_vencimento=$_POST['dt_vencimento'];


  $dt_emissao=$_POST['dt_emissao'];
  $dt_emissao=str_replace('-', '', $dt_emissao);
  echo "DT_EMISSAO: ". $dt_emissao=substr( $dt_emissao, 2,6); echo "<br>";
  
  $dt_vencimento=str_replace('-', '', $dt_vencimento);
  echo "DT_VENCIMENTO: ". $dt_vencimento=substr( $dt_vencimento, 2,6); echo "<br>";

$idsacado=$_POST['idsacado'];echo "<br>ID SACADO: ";
$idsacado = explode("-", $idsacado);
echo $idsacado=$idsacado[0]; 

if(isset($_GET['action']) && $_GET['action']=="CAD"){
//DT STATUS NO INSERT ESPELHA A DATA EMISSÃO
$dt_status=$dt_emissao;
$status=1;

//INSERT INTO tblmvmdup1
$localsql=new localsql();
$localsql->mvm_duplicata($idmvmop1,$nroduplicata,$valor,$fator,$iof,$advalorem,$maisdias,$idsacado,$dt_emissao,$dt_vencimento,$status,$dt_status,$pdom);

$calcemissao="20".$dt_emissao;
$calcvencimento="20".$dt_vencimento;

$diferenca = strtotime($calcvencimento) - strtotime($calcemissao);
$dias = floor($diferenca / (60 * 60 * 24)); 

$valorpuro=$valor;

if($load_calc=="C"){
  require "calculo_juros_composto.php";
}
else{
  require "calculo_juros_simples.php";
}


echo "<br><br> NUMERO DE DIAS ATÉ O VENCIMENTO: ".$dias;
$valor_previsao=number_format($valor_previsao, 2, '.', '');
echo "<br><br> VALOR A PAGAR: ".$valor_previsao; //VALOR A PAGAR DA DUPLICATA 

$idope=$idmvmop1;

$localsql=new localsql();
$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){
$vlropeanterior=$line['vlr_operacao'];
$vlranterior=$line['vlr_pago'];
}
echo "<br><br>VALOR ANTERIOR DA OPERACAO: ".$vlropeanterior; 
echo "<br>VALOR Á PAGAR ANTERIOR: ".$vlranterior; 

echo "<br><br>NOVO VALOR DA OPERACAO: ".$vlr_operacao=$vlropeanterior + $valor; //COMPOSICAO DO NOVO VALOR DA OPERACAO
echo "<br>NOVO VALOR A PAGAR: ".$vlr_pago=$vlranterior + $valor_previsao; //COMPOSICAO DO NOVO VALOR A PAGAR DA OPERACAO

$localsql=new localsql();
$localsql->update_vlr_idope($idope,$vlr_operacao,$vlr_pago,$pdom); //ATUALIZA O VALOR TOTAL E O VALOR A PAGAR NA OPERACAO

//INCLUI LOG DE MOVIMENTO
$vencimento=$_POST['dt_vencimento'];
$siano=substr($vencimento, 0, 4); $simes=substr($vencimento, 5, 2); $sidia=substr($vencimento, 8, 2);
$vencimento=$sidia.'/'.$simes.'/'.$siano;	
echo "<br><br>".$acao="Inclusão De Duplicata. Nº: ".$nroduplicata. " - VALOR: ".number_format($valor, 2, ',', '.')." R$ | Vencimento: ".$vencimento;
echo "<br>".$date=date('ymdHi');
$idlogin=$_SESSION['idlogin'];

$localsql=new localsql(); 
$localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom);

unset($_SESSION['idop']);
$redirect="operacao_detalhes.php?origin=NEWDUP&id=".$idope."&key=".$counterkey;
}
elseif(isset($_GET['action']) && $_GET['action']=="EDT"){ // EDICAO DE DUPLICATA --------------------------------------------------------
 echo "<br><br><b>----------------------------- EDT DUPLICATA ---------------------------------------</b><br><br>";
 echo "<b>SEQ DUPLICATA:</b> ".$seq=$_SESSION['edtseq'];
 echo "<br><b>IDOPE EDT:</b> ".$idope=$_SESSION['edtidope'];

$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){
echo "<br><br><b>VALOR ORIGINAL DA OPERACAO:</b> ".$vlropeanterior=$line['vlr_operacao'];
echo "<br><b>VALOR ORIGINAL Á PAGAR DA OPERACAO: </b>".$vlrpagoanterior=$line['vlr_pago'];
echo "<br><b>TIPO JUROS: </b>".$vlranterior=$line['tipo_juros'];
}
 $busca = $localsql->busca_duplicata_seq($seq,$pdom);
 foreach($busca as $line){
  echo "<br><b>DATA EMISSAO ORIGINAL: </b>".$dt_emissao=$line['dt_emissao'];	
  echo "<br><b>DATA VENCIMENTO ORIGINAL: </b>".$dt_vencimento=$line['dt_vencimento'];
  
$calcemissao="20".$dt_emissao;
$calcvencimento="20".$dt_vencimento;

$diferenca = strtotime($calcvencimento) - strtotime($calcemissao);
$dias = floor($diferenca / (60 * 60 * 24));

echo "<br><br> NUMERO DE DIAS ATÉ O VENCIMENTO: ".$dias;

  echo "<BR><br><b>VALOR ORIGINAL DUPLICATA: </b>".$valoranterior=$line['valor'];	
  echo "<br><b>VALOR ORIGINAL FATOR: </b>".$fator=$line['fator'];	
  if($exibe_iof==1){echo "IOF: ". $iof=$line['iof'];}else { $iof=0;} echo "<br>";
  if($exibe_advalorem==1){echo "<b>AD VALOREM ANTERIOR </b>: "; if($line['advalorem']!=""){echo $advalorem=$line['advalorem'];}else{ echo $advalorem="0";}}else{ $advalorem="0";}  echo "<br>";	
  echo "<br><b>STATUS: </b>".$status=$line['status'];	
  echo "<br><b>DATA STATUS: </b>".$dt_status=$line['dt_status'];	
}
$valorpuro=$valoranterior;

 if($load_calc=="C"){
  require "calculo_juros_composto.php";
}
else{
  require "calculo_juros_simples.php";
}
$valor_previsao=number_format($valor_previsao, 2, '.', '');
echo "<br><b> VALOR ORIGINAL A PAGAR:</b> ".$valor_previsao; //VALOR A PAGAR DA DUPLICATA 
 
$vlr_operacao=$vlropeanterior - $valoranterior;
$vlr_operacao=number_format($vlr_operacao, 2, '.', '');
echo "<br><br><b> VALOR DA OPERACAO REMOVENDO DUPLICATA ANTERIOR:</b> ".$vlr_operacao; //VALOR A PAGAR DA DUPLICATA 
$vlr_pago=$vlrpagoanterior - $valor_previsao;
$vlr_pago=number_format($vlr_pago, 2, '.', '');
echo "<br><b> VALOR Á PAGAR DA OPERACAO REMOVENDO DUPLICATA ANTERIOR:</b> ".$vlr_pago; //VALOR A PAGAR DA DUPLICATA 

$localsql=new localsql(); //UPDATE tblmvmope1 -> set vlr_operacao | vlr_pago antes da duplicata
$localsql->update_vlr_idope($idope,$vlr_operacao,$vlr_pago,$pdom); //ATUALIZA O VALOR TOTAL E O VALOR A PAGAR NA OPERACAO // ####################################################################

 echo "<br><br>----------- INICIA RECALCULO DA DUPLICATA ----------<br>";

echo "IDOPE: ". $idmvmop1; echo "<br>";
echo "Nro DUPLICATA: ".  $nroduplicata=$_POST['nroduplicata']; echo "<br>";
echo "VALOR: ". $valor=$_POST['valor']; echo "<br>";
echo "FATOR: ". $fator=$_POST['fator']; echo "<br>";
if($exibe_iof==1){echo "IOF: ". $iof=$_POST['iof'];}else { $iof=0;} echo "<br>";
if($exibe_advalorem==1){echo "AD VALOREM: "; if($_POST['advalorem']!=""){echo $advalorem=$_POST['advalorem'];}else{ echo $advalorem="0";}}else{ $advalorem="0";}  echo "<br>";

echo "NUM PARCELAS: ".$numero_parcelas=$_POST['numero_parcelas'];
echo "<br>+DIAS: ". $maisdias=$_POST['maisdias']; echo "<br>";

echo "<br> POST DATA EMISSÃO: ".$_POST['dt_emissao']."<br>";
echo "POST DATA VENCIMENTO: ". $dt_vencimento=$_POST['dt_vencimento'];


  $dt_emissao=$_POST['dt_emissao'];
  $dt_emissao=str_replace('-', '', $dt_emissao);
  echo "<br>DT_EMISSAO: ". $dt_emissao=substr( $dt_emissao, 2,6); echo "<br>";
  
  $dt_vencimento=str_replace('-', '', $dt_vencimento);
  echo "DT_VENCIMENTO: ". $dt_vencimento=substr( $dt_vencimento, 2,6); echo "<br>";

$idsacado=$_POST['idsacado'];echo "<br>ID SACADO: ";
$idsacado = explode("-", $idsacado);
echo $idsacado=$idsacado[0]; 


//UPDATE INTO tblmvmdup1
$localsql=new localsql();
$localsql->upd_mvm_duplicata($seq,$nroduplicata,$valor,$fator,$iof,$advalorem,$maisdias,$idsacado,$dt_emissao,$dt_vencimento,$status,$dt_status,$pdom); // ####################################################################

$calcemissao="20".$dt_emissao;
$calcvencimento="20".$dt_vencimento;

$diferenca = strtotime($calcvencimento) - strtotime($calcemissao);
$dias = floor($diferenca / (60 * 60 * 24)); 

$valorpuro=$valor;

if($load_calc=="C"){
  require "calculo_juros_composto.php";
}
else{
  require "calculo_juros_simples.php";
}

echo "<br><br> NUMERO DE DIAS ATÉ O VENCIMENTO: ".$dias;
$valor_previsao=number_format($valor_previsao, 2, '.', '');
echo "<br><br> VALOR A PAGAR: ".$valor_previsao; //VALOR A PAGAR DA DUPLICATA 

$idope=$idmvmop1;

$localsql=new localsql();
$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){
$vlropeanterior=$line['vlr_operacao'];
$vlranterior=$line['vlr_pago'];
}
echo "<br><br>VALOR ANTERIOR DA OPERACAO: ".$vlropeanterior; 
echo "<br>VALOR Á PAGAR ANTERIOR: ".$vlranterior; 

echo "<br><br>NOVO VALOR DA OPERACAO: ".$vlr_operacao=$vlropeanterior + $valor; //COMPOSICAO DO NOVO VALOR DA OPERACAO
echo "<br>NOVO VALOR A PAGAR: ".$vlr_pago=$vlranterior + $valor_previsao; //COMPOSICAO DO NOVO VALOR A PAGAR DA OPERACAO

$localsql=new localsql();
$localsql->update_vlr_idope($idope,$vlr_operacao,$vlr_pago,$pdom); //ATUALIZA O VALOR TOTAL E O VALOR A PAGAR NA OPERACAO ####################################################################

//INCLUI LOG DE MOVIMENTO
$vencimento=$_POST['dt_vencimento'];
$siano=substr($vencimento, 0, 4); $simes=substr($vencimento, 5, 2); $sidia=substr($vencimento, 8, 2);
$vencimento=$sidia.'/'.$simes.'/'.$siano;	
echo "<br><br>".$acao="Edição Da Duplicata. Nº: ".$nroduplicata. " - VALOR: ".number_format($valor, 2, ',', '.')." R$ | Vencimento: ".$vencimento;
echo "<br>".$date=date('ymdHi');
$idlogin=$_SESSION['idlogin'];

$localsql=new localsql(); 
$localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom); // ####################################################################

$redirect="operacao_detalhes.php?origin=EDTDUP&id=".$idope."&key=".$counterkey;
} //FIM EDIÇÂO DA DDUPLICATA

}
else{
  //ERROR KEY VALIDATATION  
  $redirect="movimento_operacao.php?origin=NEWOP&action=error";
}

header("Location:".$redirect);
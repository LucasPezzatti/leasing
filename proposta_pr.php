<?php session_start();
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if(isset($_SESSION['logado']) ){
require "core/mysql.php";
require "global_date.php";
//require "header.php";
date_default_timezone_set('America/Campo_Grande');
$localsql=new localsql();

$debug=0;

if($debug > 0){
	echo "<center><h1>DEBUG</h1>";
	echo "<br><br>";
	
	print_r($_POST);
	echo "<br>";
	echo "<br>";
}


$idope=$_POST['idope'];
$idsacado=$_POST['idsacado'];
$idsacado = explode("-", $idsacado);
$idsacado=$idsacado[0]; 
$valor=$_POST['valor'];
$tipo_juros=$_POST['tipo_juros'];
$fator=$_POST['fator'];
$iof=$_POST['iof'];
$advalorem=$_POST['advalorem'];
$numero_parcelas=$_POST['numero_parcelas'];
$primeira_parcela=$_POST['primeira_parcela'];
$intervalo_parcelas=$_POST['intervalo_parcelas'];
$valor_parcela=$_POST['valor_parcela'];
$total=$_POST['valor_previsao_final'];
$emissao=date('ymd');
$status=1;

//ADICIONA NO FINANCIAMENTO HEADER tblmvmfinprop1
$localsql->add_tblmvmfinprop1($idope,$idsacado,$valor,$fator,$iof,$advalorem,$numero_parcelas,$primeira_parcela,$intervalo_parcelas,$valor_parcela,$total,$emissao,$status,$pdom);

//BUSCA idmvmfinprop 
  $busca = $localsql->busca_idmvmfinprop($idope,$pdom); 
 if($debug > 0){
	print_r($busca);
	echo "<br>";
 } 
foreach($busca as $line){
$idmvmfinprop=$line['idmvmfinprop'];	
}

 $localsql=new localsql();
 $busca = $localsql->busca_ope_idope($idope,$pdom);
 foreach($busca as $line){
 $vlropeanterior=$line['vlr_operacao'];
 $vlranterior=$line['vlr_pago'];
 }
 
// echo "<br><br>NOVO VALOR DA OPERACAO: ";
 $vlr_operacao=$vlropeanterior + $total; //COMPOSICAO DO NOVO VALOR DA OPERACAO
//echo "<br><br>NOVO VALOR A PAGAR: ";
 $vlr_pago=$vlranterior + $valor; //COMPOSICAO DO NOVO VALOR A PAGAR DA OPERACAO
 
 $localsql=new localsql();
 $localsql->update_vlr_idope($idope,$vlr_operacao,$vlr_pago,$pdom); //ATUALIZA O VALOR TOTAL E O VALOR A PAGAR NA OPERACAO 


//GERA E SALVA PARCELAS NO DATABASE
$parcela=0;
for ($i = 0; $i < $numero_parcelas; $i++) {
$parcela++;
if($parcela==1){
 $vencimento=$primeira_parcela;	
 $vencimento_original=$vencimento;
 $ano=substr($vencimento, 0, 2);	
 $mes=substr($vencimento, 2, 2);	
 $dia=substr($vencimento, 4, 2);	
 $ven_dia=$dia."-".$mes."-20".$ano;
 $dia_semana = date('w', strtotime($ven_dia));

  //DOMINGO
  if($dia_semana==0){
	$ano=substr($vencimento, 0, 2);	
	 $mes=substr($vencimento, 2, 2);	
	 $dia=substr($vencimento, 4, 2);	
	$date=date_create($ano."-".$mes."-".$dia);
	
	date_add($date,date_interval_create_from_date_string("1 days"));
	$vencimento=date_format($date,"y-m-d");
	$vencimento=str_replace("-","",$vencimento);
	}
	//SABADO
	elseif($dia_semana==6){
	$ano=substr($vencimento, 0, 2);	
	 $mes=substr($vencimento, 2, 2);	
	 $dia=substr($vencimento, 4, 2);	
	$date=date_create($ano."-".$mes."-".$dia);
	
	date_add($date,date_interval_create_from_date_string("2 days"));
	$vencimento=date_format($date,"y-m-d");
	$vencimento=str_replace("-","",$vencimento);
	}

}
else{
	$ano=substr($vencimento, 0, 2);	
	$mes=substr($vencimento, 2, 2);	
	$dia=substr($vencimento, 4, 2);	

   $date=date_create($ano."-".$mes."-".$dia);
   date_add($date,date_interval_create_from_date_string("30 days"));
   $vencimento=date_format($date,"y-m-d");
   $vencimento=str_replace("-","",$vencimento);
   $vencimento_original=$vencimento;

   $ano=substr($vencimento, 0, 2);	
   $mes=substr($vencimento, 2, 2);	
   $dia=substr($vencimento, 4, 2);	

   $ven_dia=$dia."-".$mes."-20".$ano;
   $dia_semana = date('w', strtotime($ven_dia));
   
   //DOMINGO
   if($dia_semana==0){
	$ano=substr($vencimento, 0, 2);	
	 $mes=substr($vencimento, 2, 2);	
	 $dia=substr($vencimento, 4, 2);	
	$date=date_create($ano."-".$mes."-".$dia);
	
	date_add($date,date_interval_create_from_date_string("1 days"));
	$vencimento=date_format($date,"y-m-d");
	$vencimento=str_replace("-","",$vencimento);
	}
	//SABADO
	elseif($dia_semana==6){
	$ano=substr($vencimento, 0, 2);	
	 $mes=substr($vencimento, 2, 2);	
	 $dia=substr($vencimento, 4, 2);	
	$date=date_create($ano."-".$mes."-".$dia);
	
	date_add($date,date_interval_create_from_date_string("2 days"));
	$vencimento=date_format($date,"y-m-d");
	$vencimento=str_replace("-","",$vencimento);
	}
}
require "core/days_br.php";

if($debug > 0){
	echo "<br>Parcela:".$parcela; 
	echo " - R$ ".$valor_parcela;
	echo " - Vencimento Original: ".$vencimento_original; 
	echo " (".$diasem.") ";
	echo " - Vencimento Final: ".$vencimento; 
	echo "<br>";
}
$valor=$valor_parcela;
$dt_vencimento=$vencimento;
$status=1;
	//ADICIONA NO DATABASE tblmvmfinprop1
	$localsql->add_tblmvmfinprop2($idope,$idmvmfinprop,$idsacado,$parcela,$valor,$dt_vencimento,$emissao,$status,$pdom);
//FIM DO LOOP DE PARCELAS
} 

$redirect="operacao_detalhes.php?id=".$idope."&origin=NEWFINPRO&key=".$counterkey;
}
else{	
	$redirect="login.php";
}

header('Location:'.$redirect);
?>
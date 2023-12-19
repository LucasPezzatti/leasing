<?php
if(!isset($iof) || $iof==""){
  $iof=0;      
}
if(!isset($advalorem) || $advalorem==""){
        $advalorem=0;      
}
//INI VAR
$Valor = $valorpuro;
$Juros = $fator + $iof + $advalorem; // TAXA TOTAL DE JUROS (PERCENTUAL + IOF + ADVALOREM)
$Parcelas = $numero_parcelas;

$Juros=($Juros / 30) * $intervalo_parcelas; 

//echo $Juros;

//Funcao para Calcular valor da Parcela - Tabela Price
function Price($Valor, $Parcelas, $Juros) {

$Juros = bcdiv($Juros,100,15);
$E=1.0;
$cont=1.0;

for($k=1;$k<=$Parcelas;$k++)
{
$cont= bcmul($cont,bcadd($Juros,1,15),15);
$E=bcadd($E,$cont,15);
}
$E=bcsub($E,$cont,15);

$Valor = bcmul($Valor,$cont,15);
return bcdiv($Valor,$E,15);
}

//VALOR DA PARCELA
$parcela = Price($Valor, $Parcelas, $Juros);

$valor_fra_juros_dias_ant=0;
$valor_juros_dias_ant=0;

//CALCULA JUROS QUANDO A PRIMEIRA PARCELA É APÓS 30 DIAS 
if($diasantecede > 30){
$valor_juros_dias_ant=0;  
$juros_total=0;   
$taxa_de_juros= $fator + $iof + $advalorem; // TAXA TOTAL DE JUROS (PERCENTUAL + IOF + ADVALOREM) 

$dias=$diasantecede - 30;

$taxa_de_juros=$taxa_de_juros * $dias / 30; //TAXA DE JUROS APLICADA AO VENCIMENTO

        $juros_total += ($valorpuro * $taxa_de_juros) / 100; //JUROS POR PARCELA (DIAS / 30)

        $valor_juros_dias_ant += $valorpuro + $juros_total;  //VALOR A PAGAR 
        
        $valor_juros_dias_ant=$valor_juros_dias_ant - $valorpuro;

$valor_fra_juros_dias_ant=$valor_juros_dias_ant / $Parcelas;
}


$valor_parcela = $parcela + $valor_fra_juros_dias_ant;
$valor_parcela = round( $valor_parcela, 2, PHP_ROUND_HALF_UP);


$valor_previsao_final=$valor_parcela * $Parcelas;
$valor_previsao_final=$valor_previsao_final;

?>

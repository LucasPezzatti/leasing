<?php
//INI VAR
$juros_total=0;
$valor_previsao=0;

if(!isset($iof) || $iof==""){
  $iof=0;      
}
if(!isset($advalorem) || $advalorem==""){
        $advalorem=0;      
}
 
$taxa_de_juros=$fator + $iof + $advalorem; // TAXA TOTAL DE JUROS (PERCENTUAL + IOF + ADVALOREM)

$taxa_de_juros=$taxa_de_juros * $dias / 30; //TAXA DE JUROS APLICADA AO VENCIMENTO

        $juros_total += ($valorpuro * $taxa_de_juros) / 100; //JUROS POR PARCELA (DIAS / 30)

        $valor_previsao += $valorpuro + $juros_total;  //VALOR A PAGAR 
        
 $valor_previsao_final=$valor_previsao;
 
?>

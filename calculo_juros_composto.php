<?php
//INI VAR
$juros_totais=0;
$valor_previsao_final=0;
if($maisdias==""){ $maisdias="0";}

$dias=$dias + $maisdias; //VENCIMENTO + DIAS ADICIONAIS

if($advalorem=="" || !isset($advalorem)){$advalorem=0;}
if($iof=="" || !isset($iof)){$iof=0;}
if($fator=="" || !isset($fator)){$fator=0;}

$investimento_inicial = $valorpuro;
$meses = $numero_parcelas;
$taxa_de_juros=$fator + $iof + $advalorem; // TAXA TOTAL DE JUROS (PERCENTUAL + IOF + ADVALOREM)
$taxa_de_juros=$taxa_de_juros / 30; // TAXA TOTAL DE JUROS AO DIA
$investimento_acumulado = $investimento_inicial; //VALOR DO DOC
$juros_compostos_total = 0;
 
//CALCULO DO JUROS COMPOSTO 
for ($i = 0; $i < $dias; $i++) {
$juros_compostos = ($investimento_acumulado * $taxa_de_juros) / 100;
$juros_compostos_total += $juros_compostos;
$investimento_acumulado = $investimento_acumulado + $juros_compostos;
}

$juros_totais=$investimento_acumulado - $investimento_inicial; //VALOR TOTAL DE JUROS

$valor_previsao=$investimento_inicial - $juros_totais;  //VALOR A PAGAR 

$valor_previsao_final=number_format($valor_previsao, 2, ',', '.'); //VALOR A PAGAR FORMATADO
?>

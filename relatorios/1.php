<?php 
        if(isset($_REQUEST['mes'])){
          $selmes=$_REQUEST['mes'];
        }
        else{
         $selmes=date('m'); 
        }
        
        $dateini=date('y'.$selmes.'01');

        $monthNum = $selmes;
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        $date = new DateTime($dateini);
        $date->modify('last day of '.$monthName);
        $lastday= $date->format('d');

        $datefin=date('y'.$selmes.$lastday);
        ?>
<div class="row">
	 <div  class="col-12 col-lg-12">
	   <div id="relatorio" class="card printcolor">
	     <div class="card-header printcolor" style="text-align:center;font-size:22px;border-bottom:0px;!important"> Relatório Mensal De Movimento  
       <span style="display:none;font-size:14px;float:right;padding-top:10px" class="onlyOnprint"> <?= date('d/m/Y H:i')?></span>
       <form action="?relatorio=1&key=<?= $_GET['key'];?>&filter" method="POST">
        <button type="button" onclick="printDiv('relatorio')" style="float:right;margin-left:20px" class="btn btn-light noPrint"><i class="fa fa-print"></i> Imprimir</button> 
        <a href="relatorios.php?"><button type="button" style="float:right;margin-left:20px" class="btn btn-light noPrint">Voltar</button> </a>
        <select  onchange="this.form.submit();" style="float:right;width:120px"  required name="mes" class="form-control printcolor" required="required">
                      <option <?php if($selmes=='01'){echo 'selected';}?> value="01">Janeiro</option>
                      <option <?php if($selmes=='02'){echo 'selected';}?> value="02">Fevereiro</option>
                      <option <?php if($selmes=='03'){echo 'selected';}?> value="03">Março</option>
                      <option <?php if($selmes=='04'){echo 'selected';}?> value="04">Abril</option>
                      <option <?php if($selmes=='05'){echo 'selected';}?> value="05">Maio</option>
                      <option <?php if($selmes=='06'){echo 'selected';}?> value="06">Junho</option>
                      <option <?php if($selmes=='07'){echo 'selected';}?> value="07">Julho</option>
                      <option <?php if($selmes=='08'){echo 'selected';}?> value="08">Agosto</option>
                      <option <?php if($selmes=='09'){echo 'selected';}?> value="09">Setembro</option>
                      <option <?php if($selmes==10){echo 'selected';}?> value="10">Outubro</option>
                      <option <?php if($selmes==11){echo 'selected';}?> value="11">Novembro</option>
                      <option <?php if($selmes==12){echo 'selected';}?> value="12">Dezembro</option>
        </select>
        
      </form>
        
      </div> 
         <div class="table-responsive" style="max-width:98.6%;margin-left:15px">
                 <table class="table align-items-center table-striped table-bordered table-flush table-sm printcolor">
                  <thead>
                   <tr>
                     <th>ID</th>
                     <th >Cedente</th>
                     <th>Tipo Calc.</th>
                     <th>Nº Docs</th>
                     <th>Emissão</th>
                     <th>Vlr. Operação</th>
                     <th>Vlr. Pago</th>
                     <th>Lucro Bruto</th>       
                   </tr>
                   </thead>
                   <tbody>
<?php 
$localsql=new localsql();
$busca = $localsql->busca_relatorio_1($dateini, $datefin,$pdom); 
foreach($busca as $line){
 $idope=$line['idope'];	
 $idcedente=$line['idcedente'];	
 $tipo_calculo=$line['tipo_calculo'];	
$status=$line['status'];	
  
 $vlr_pago=$line['vlr_pago'];	
 $vlr_pagocalc= $vlr_pago;
 if(isset($vlr_pago) && $vlr_pago > 0){
  $vlr_pago = number_format($vlr_pago, 2, ',', '.')." R$";
}	

 require "global_status.php";

 $data=$line['data'];	
 $siano=substr($data, 0, 2); $simes=substr($data, 2, 2); $sidia=substr($data, 4, 2);
 $data=$sidia.'/'.$simes.'/'.$siano;

 $busca = $localsql->busca_cendente_id($idcedente,$pdom); //CARREGA O NOME DO CEDENTE
 foreach($busca as $line){ 
 $nomecedente=$line['razao'];		
 }
 //COUNT AND SUM DUPLICATA
 $busca = $localsql->count_duplicata_idope($idope,$pdom); //CONTA O NUMERO DE DUPLICATAS VINCULADAS AO ID DA OPERACAO
 foreach($busca as $line){
 $countdup=$line['countdup'];		
 }
 if(isset($countdup) && $countdup > 0){ //VALIDA SE EXISTEM DUPLICATAS E EXIBE SE HOUVER AO MENOS 1 
 
  $busca = $localsql->sum_duplicata_idope($idope,$pdom); //SOMA O VALOR DAS DUPLICATAS VINCULADAS AO ID DA OPERACAO
  foreach($busca as $line){
  $sumduplicatadas=$line['sumduplicatadas'];	
  }
}
else{
  $countdup="0";
  $sumduplicatadas="0";
} 
//COUNT AND SUM CHEQUE
 $busca = $localsql->count_cheque_idope($idope,$pdom); //CONTA O NUMERO DE CHEQUE VINCULADAS AO ID DA OPERACAO
 foreach($busca as $line){
 $countche=$line['countche'];		
 }
 if(isset($countche) && $countche > 0){ //VALIDA SE EXISTEM CHEQUES E EXIBE SE HOUVER AO MENOS 1
 
  $busca = $localsql->sum_cheque_idope($idope,$pdom); //SOMA O VALOR DOS CHEQUES VINCULADAS AO ID DA OPERACAO
  foreach($busca as $line){
  $sumcheques=$line['sumcheques'];	
  }
}
 else{
  $countche="0";
  $sumcheques="0";
}

//COUNT AND SUM CARNE
$busca = $localsql->count_carne_idope($idope,$pdom); //CONTA O NUMERO DE CHEQUE VINCULADAS AO ID DA OPERACAO
foreach($busca as $line){
$countcar=$line['countcar'];		
}
if(isset($countcar) && $countcar > 0){ //VALIDA SE EXISTEM CHEQUES E EXIBE SE HOUVER AO MENOS 1

 $busca = $localsql->sum_carne_idope($idope,$pdom); //SOMA O VALOR DOS CHEQUES VINCULADAS AO ID DA OPERACAO
 foreach($busca as $line){
 $sumparcelas=$line['sumparcelas'];	
 }
}
else{
 $countcar="0";
 $sumparcelas="0";
}

//SOMA TOTAL DE DOC's 
$counttotal=$countche + $countdup + $countcar;

$sumtotal=$sumcheques + $sumduplicatadas + $sumparcelas;
$sumtotalcalc=$sumtotal;
if(isset($sumtotal) && $sumtotal > 0){
  $sumtotal = number_format($sumtotal, 2, ',', '.')." R$";
}	

$lucrobruto=$sumtotalcalc - $vlr_pagocalc;
$lucrobruto = number_format($lucrobruto, 2, ',', '.')." R$";
?>                    
                    <tr>
                    <td <?= $columnsize; ?>>#<?php echo $idope;?></td>
                    <td <?= $columnsize; ?>><?php echo $idcedente.'-'.$nomecedente;?></td>
                    <td <?= $columnsize; ?>><?php if($tipo_calculo=="VP"){echo "Valor Presente";}else{echo "Valor Futuro";}?></td>
                    <td <?= $columnsize; ?>><?php echo $counttotal;?></td>
                    <td <?= $columnsize; ?>><?php echo $data;?></td>
                    <td <?= $columnsize; ?>><?php echo $sumtotal;?></td>
                    <td <?= $columnsize; ?>><?php echo $vlr_pago;?></td>
                    <td <?= $columnsize; ?>><?php echo $lucrobruto;?></td>
                   
                  
              
                    <!-- 
					          <td><div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 10%"></div>
                        </div></td> -->
                   </tr>
                   <?php 
                   }
                   ?>
                   
                 </tbody></table>

            <?php 
            $totalope="0";
            $totalpg="0";
            $totalrece="0";
            $localsql=new localsql();
						$busca = $localsql->relatorio1_lucro_previsto($dateini,$datefin,$pdom);
            foreach($busca as $line){
             $totalope=$line['totalope'];
             $totalpg=$line['totalpg'];
            }
          
					$busca = $localsql->relatorio1_soma_receitas_only($dateini,$datefin,$pdom);
            foreach($busca as $line){
              $totalreceita=$line['totalrece'];
            }
         
            $lucroprevisto= $totalope + $totalreceita - $totalpg;
            $lucroprevisto=number_format($lucroprevisto, 2, ',', '.');	
            ?>

             <div style="float:right;margin-top:10px">
             <table class="table table-bordered align-items-center printcolor">
                 <tr><td>TOTAL OPERAÇÕES </td> <td><?= number_format($totalope, 2, ',', '.');?> R$</td></tr>
                 <tr><td>TOTAL PAGO </td><td> <?= number_format($totalpg, 2, ',', '.');?> R$</td></tr>
                 <tr><td>TOTAL LANÇAMENTOS </td><td> <?= number_format($totalreceita, 2, ',', '.');?> R$</td></tr>
                 <tr><td style="border:none!important"></td><td style="border:none!important"></td></tr>
                 <tr><td>LUCRO BRUTO </td> <td><?= $lucroprevisto;?> R$</td></tr>
             </table>    
             </div>
            </div>
           <div class="onlyOnprint" style="float:middle;text-align:center;display:none;border-top: 1px solid #D5D5D5"><p style="padding-top:10px;"><?php echo $copyright;?></div>
	 </div>
     
	</div>

    
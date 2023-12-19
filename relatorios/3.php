
<div class="row">
	 <div  class="col-12 col-lg-12">
	   <div id="relatorio" class="card printcolor">
	     <div class="card-header printcolor" style="text-align:center;font-size:22px;border-bottom:0px;!important"> Relatório De Títulos Vencidos <br>
		 <span style="display:none;font-size:14px;float:right;padding-top:10px" class="onlyOnprint"> <?= date('d/m/Y H:i')?></span>
        <button type="button" onclick="printDiv('relatorio')" style="float:right;margin-left:20px" class="btn btn-light noPrint"><i class="fa fa-print"></i> Imprimir</button> 
        <a href="relatorios.php?"><button type="button" style="float:right;margin-left:20px" class="btn btn-light noPrint">Voltar</button> </a>
      </div> 
         <div class="table-responsive" style="max-width:98.6%;margin-left:15px">
                 <table class="table align-items-center table-striped table-bordered table-flush table-sm printcolor">
                  <thead>
                   <tr>
                     <th>Operação</th>
                      <th>ID DOC.</th>
					            <th>Emissão</th>
                     <th>Tipo DOC.</th>
                     <th>Sacado</th> 
                     <th>Valor</th>
                     <th>Vencimento</th>       
                   </tr>
                   </thead>
                   <tbody>
<?php 
$localsql=new localsql();
$busca = $localsql->relatorio3_titulos_vencidos($pdom); 
foreach($busca as $line){
 $seq=$line['seq'];	
 $idope=$line['idmvmop1'];	
 $idsacado=$line['idsacado'];	
 $idcedente=$line['idsacado'];	
 $nrocheque=$line['nrocheque'];	
 $nroduplicata=$line['nroduplicata'];	
 $idmvmfinprop=$line['idmvmfinprop'];	
 $valor=$line['valor'];	
 $dt_emissao=$line['dt_emissao'];	
 $dt_vencimento=$line['dt_vencimento'];	

 $nomesacado="Não Informado";
 $busca = $localsql->busca_sacado_id($idsacado,$pdom); //CARREGA O NOME DO CEDENTE
 foreach($busca as $line){ 
 $nomesacado=$line['razao'];		
 }
	
 $siano=substr($dt_emissao, 0, 2); $simes=substr($dt_emissao, 2, 2); $sidia=substr($dt_emissao, 4, 2);
 $dt_emissao=$sidia.'/'.$simes.'/'.$siano;

 $siano=substr($dt_vencimento, 0, 2); $simes=substr($dt_vencimento, 2, 2); $sidia=substr($dt_vencimento, 4, 2);
 $dt_vencimento=$sidia.'/'.$simes.'/'.$siano;

 if($nroduplicata!=null && $nrocheque==null && $idmvmfinprop==null){
	$tipodoc="Duplicata";
 }
 elseif($nrocheque!=null && $nroduplicata==null  && $idmvmfinprop==null ){
	$tipodoc="Cheque";
 }
 elseif( $idmvmfinprop!=null && $nrocheque==null && $nroduplicata==null ){
	$tipodoc="Carnê";
 }
 else{
	$tipodoc="-";
 }
?>                    
                    <tr>
                    <td <?= $columnsize; ?>>#<?php echo $idope;?></td>
                    <td <?= $columnsize; ?>><?php echo $seq;?></td>
					<td <?= $columnsize; ?>><?php echo $dt_emissao;?></td>
                    <td <?= $columnsize; ?>><?php echo $tipodoc;?></td>
                    <td <?= $columnsize; ?>><?php echo $idsacado.'-'.$nomesacado;?></td>
                    <td <?= $columnsize; ?>><?php echo "R$ ".number_format($valor, 2, ',', '.');?></td>
                    <td <?= $columnsize; ?>><?php echo $dt_vencimento;?></td>
                   
                  
              
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
           $busca = $localsql->relatorio3_sum_che_vencido($pdom); 
           foreach($busca as $line){
           $tot_venc_che=$line['tot_venc_che'];	
           } 
           $busca = $localsql->relatorio3_sum_dup_vencido($pdom); 
           foreach($busca as $line){
             $tot_venc_dup=$line['tot_venc_dup'];	
           } 
           $busca = $localsql->relatorio3_sum_emp_vencido($pdom); 
           foreach($busca as $line){
           $tot_venc_emp=$line['tot_venc_emp'];	
           } 
           
           $total_vencido=$tot_venc_che + $tot_venc_dup + $tot_venc_emp;
      
            ?>

             <div  style="float:right;margin-top:10px">
             <table class="table table-bordered align-items-center printcolor">
                 <tr><td>TOTAL CHEQUES VENCIDOS </td> <td><?= number_format($tot_venc_che, 2, ',', '.');?> R$</td></tr>
                 <tr><td>TOTAL DUPLICATAS VENCIDAS </td> <td><?= number_format($tot_venc_dup, 2, ',', '.');?> R$</td></tr>
                 <tr><td>TOTAL CARNÊS VENCIDOS </td> <td><?= number_format($tot_venc_emp, 2, ',', '.');?> R$</td></tr>
                 <tr><td style="border:none!important"></td><td style="border:none!important"></td></tr>
                 <tr><td>TOTAL VENCIDO </td> <td><?= number_format($total_vencido, 2, ',', '.');?> R$</td></tr>
             </table>    
             </div>
            </div>
           <div class="onlyOnprint" style="float:middle;text-align:center;display:none;border-top: 1px solid #D5D5D5"><p style="padding-top:10px;"><?php echo $copyright;?></div>
	 </div>
     
	</div>

    
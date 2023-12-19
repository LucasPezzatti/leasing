<div class="row">
	 <div  class="col-12 col-lg-12">
	   <div id="Relatorio" class="card printcolor">

	     <div class="card-header printcolor" style="text-align:center;font-size:22px;border-bottom:0px;!important"> Resumo De Pendências Por Cedente <br>

<?php 
if( !isset($_POST['idcedente'])){ ?>
<form action="" method="POST">
  <div class="form-group" style="margin:auto;">
            <label for="input-4"> Escolha O Cedente</label>
            <div class="custom-select-form">
              <span style="font-size:11px">Digite o ID , Nome ou CPF/CNPJ do cedente para pesquisar</span>
						<input require onfocus="clearInput(this)" required style="border: 1px solid #fff;width:400px;margin:auto;" value='' placeholder="Digite o ID , Nome ou CPF/CNPJ do cedente para pesquisar" 
						class="form-control" name="idcedente" list="cedentes"  autocomplete="off">
						<datalist id="cedentes">
						<?php 
            $localsql=new localsql();
						$busca = $localsql->busca_cendente_only($pdom);
            foreach($busca as $line){
						$idcendente=$line['id'];	
						$razao=$line['razao'];			
						?>
	          <option value="<?php echo $idcendente.' - '.$razao;?>"></option>
						<?php 
            }
            ?>	
            </datalist>
            <script>function clearInput(target){
            if (target.name== 'idcedente'){ target.value= "";}}
            </script>
           </div>
           </div>
           <button style="margin:5px" type="submit" class="btn btn-light">Selecionar</button></form>
<?php               
}
else{ ?>
 <span style="display:none;font-size:14px;float:right;padding-top:15px" class="onlyOnprint"> <?= date('d/m/Y H:i')?></span>
 <button type="button" onclick="printDiv('Relatorio')" style="float:right;margin-left:20px" class="btn btn-light noPrint"><i class="fa fa-print"></i> Imprimir</button> 
<button type="button" style="float:right;margin-left:20px" onClick="history.back();" class="btn btn-light noPrint">Voltar</button>
<?php
}
?>      
</div> 
<?php 
if(isset($_POST['idcedente'])){
  $idcedente=$_POST['idcedente'];
  $idcedente=explode("-",$idcedente);
  $idcedente=$idcedente[0];
  
  $id=$idcedente;
  $localsql=new localsql();
  $busca = $localsql->busca_pessoa_id($id,$pdom);
  foreach($busca as $line){
    $limite_credito=$line['limite_credito'];	
  }
?>
<b class="printcolor" style="margin:15px;font-size:16px"><?= $_POST['idcedente']?></b>
<h5 class="printcolor text-center" style="margin-left:15px"><b>Títulos a Vencer</b></h5> 
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
$_SESSION['listaop']="";
$localsql=new localsql();
$buscaope = $localsql->relatorio4_ope_idcedente($idcedente,$pdom); 
foreach($buscaope as $line){
$idope=$line['idope'];	

$_SESSION['listaop']=$_SESSION['listaop'].$idope.',';

$busca = $localsql->relatorio4_titulos_a_vencer($idope,$pdom); 
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
                   }
                   ?>
                 </tbody>
              </table>

<?php 
$listaop=$_SESSION['listaop'];
$listaop=rtrim($listaop, ', ');

if($listaop!=""){
 
$busca = $localsql->relatorio4_sum_che_avencer($listaop,$pdom); 
foreach($busca as $line){
$tot_venc_che=$line['tot_venc_che'];	
} 
$busca = $localsql->relatorio4_sum_dup_avencer($listaop,$pdom); 
foreach($busca as $line){
  $tot_venc_dup=$line['tot_venc_dup'];	
} 
$busca = $localsql->relatorio4_sum_emp_avencer($listaop,$pdom); 
foreach($busca as $line){
$tot_venc_emp=$line['tot_venc_emp'];	
} 

$total_avencer=$tot_venc_che + $tot_venc_dup + $tot_venc_emp;
}
else{
  $total_avencer=0;
}
?>
  <div  style="float:right;margin-top:10px">
             <table class="table table-bordered align-items-center printcolor"><h5 class="text-center"></h5>
                 <tr><td>TOTAL A VENCER</td> <td>R$ <?= number_format($total_avencer, 2, ',', '.');?></td></tr>
                 <tr><td>LIMITE DE CRÉDITO</td> <td>R$ <?= number_format($limite_credito, 2, ',', '.');?></td></tr>
             </table>    
             </div>

  </div>
<h5 class="printcolor text-center" style="margin-left:15px;margin-top:15px">Títulos Vencidos</h5>
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
foreach($buscaope as $line){
$idope=$line['idope'];	

$busca = $localsql->relatorio4_titulos_vencidos($idope,$pdom); 
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
                   }
                   ?>

              </tbody>
              </table>


<?php 
$listaop=$_SESSION['listaop'];
$listaop=rtrim($listaop, ', ');

if($listaop!=""){
 
$busca = $localsql->relatorio4_sum_che_vencido($listaop,$pdom); 
foreach($busca as $line){
$tot_venc_che=$line['tot_venc_che'];	
} 
$busca = $localsql->relatorio4_sum_dup_vencido($listaop,$pdom); 
foreach($busca as $line){
  $tot_venc_dup=$line['tot_venc_dup'];	
} 
$busca = $localsql->relatorio4_sum_emp_vencido($listaop,$pdom); 
foreach($busca as $line){
$tot_venc_emp=$line['tot_venc_emp'];	
} 

$total_vencido=$tot_venc_che + $tot_venc_dup + $tot_venc_emp;
}
else{
  $total_vencido=0;
}
?>
  <div  style="float:right;margin-top:10px">
             <table class="table table-bordered align-items-center printcolor"><h5 class="text-center"></h5>
                 <tr><td>TOTAL VENCIDO</td> <td>R$ <?= number_format($total_vencido, 2, ',', '.');?></td></tr>
                 <tr><td>LIMITE DE CRÉDITO</td> <td>R$ <?= number_format($limite_credito, 2, ',', '.');?></td></tr>
             </table>    
             </div>
             </div>
<div class="onlyOnprint" style="margin-left:15px;float:middle;text-align:center;display:none;border-top: 1px solid #D5D5D5"><p style="padding-top:10px;"><?php echo $copyright;?></div>
<?php
}
?>


    
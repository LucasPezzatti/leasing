<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/conn_MYSQL.php";
require "core/mysql.php";
require "header.php";
$mvmpg="true";
$localsql=new localsql();

            $idcfg="2";
            $busca = $localsql->busca_cfgint_id($idcfg,$pdom);
            foreach($busca as $line){$iof_default=$line['value'];}
            
            $idcfg="3";
            $busca = $localsql->busca_cfgint_id($idcfg,$pdom);
            foreach($busca as $line){$perc_default_juros=$line['value'];}
            
            $idcfg="4";
            $busca = $localsql->busca_cfgint_id($idcfg,$pdom);
            foreach($busca as $line){$exibe_iof=$line['value'];}
            
            $idcfg="5";
            $busca = $localsql->busca_cfgint_id($idcfg,$pdom);
            foreach($busca as $line){$advalorem_default=$line['value'];}
            
            $idcfg="6";
            $busca = $localsql->busca_cfgint_id($idcfg,$pdom);
            foreach($busca as $line){$exibe_advalorem=$line['value'];}

            $idcfg="7";
            $busca = $localsql->busca_cfgint_id($idcfg,$pdom);
            foreach($busca as $line){$nummaxparc=$line['value'];}
?>
<body class="bg-theme bg-theme1">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming">
     <div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader">
     </div>
   </div>
  </div>
</div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">
<?php 
require "sidebar.php";
require "topbar.php";
?>
  <div class="content-wrapper">
    <div class="container-fluid">

<?php 
if(isset($_GET['action']) && $_GET['action']=="q" && isset($_GET['origin']) && $_GET['origin']=="NEWOP"){ ?>
<script>
setTimeout(function() {
$('#alert').fadeOut('fast');
}, 3000); 
</script>
  <div id="alert" class="alert alert-info alert-dismissible" role="alert">
				   <button type="button" class="close" data-dismiss="alert">×</button>
				    <div class="alert-icon">
					 <i class="icon-info"></i>
				    </div>
				    <div class="alert-message">
				      <span><strong>Info!</strong> Operação Iniciada. Escolha o tipo de documento. </span>
				    </div>
</div>
<?php 
}
?>
    
      <div class="row mt-3">

<?php 
if(isset($_GET['action']) && $_GET['action']=="start"){
?>
<!-- NOVA OPERACAO  --> 
      <div class="col-lg-6">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Nova Operação</div>
           <hr>
            <form id="operacao" method="POST" action="movimento_operacao_pr.php?action=NEWOP&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR'])); ?>"  autocomplete="off">
			<div class="form-group">
            <label for="input-1">Tipo de Operação</label>
			<select name="tipo_op" class="form-control ng-pristine ng-valid ng-not-empty ng-valid-required ng-touched" ng-disabled="operacao.titulos.length > 0" required="required">
          <option value="CO">Cessão de crédito com coobrigação / Desconto</option>
          <option value="SO">Cessão de crédito sem coobrigação</option>
      </select>
			</div>
           <div class="form-group">
            <label for="input-2">Tipo de Juros</label>
              <select name="juros" class="form-control ng-pristine ng-valid ng-not-empty ng-valid-required ng-touched" ng-model="operacao.tipoCalculoJuros" ng-required="isPermiteEditar(operacao.situacao)" required="required" >
                      <option value="S">Simples</option>
                      <option selected value="C">Composto</option>  
              </select>
           </div>
           <div class="form-group">
            <label for="input-3">Tipo de Cálculo</label>
            <select name="calculo" class="form-control ng-pristine ng-valid ng-not-empty ng-valid-required ng-touched" ng-model="operacao.tipoValorJuros" ng-required="isPermiteEditar(operacao.situacao)" required="required" >
									<option value="VP" ng-repeat="option in tipoValorJurosOptions" class="ng-binding ng-scope">Valor Presente</option>
									<option value="VF" ng-repeat="option in tipoValorJurosOptions" class="ng-binding ng-scope">Valor Futuro</option>
            </select>
           </div>
           <div class="form-group">
            <label for="input-4">Cedente</label>
            <div class="custom-select-form">
              <span style="font-size:11px">Digite o ID , Nome ou CPF/CNPJ do cedente para pesquisar</span>
						<input onfocus="clearInput(this)" required style="border: 1px solid #fff" value='' placeholder="Digite o ID , Nome ou CPF/CNPJ do cedente para pesquisar" 
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
		      <div class="form-group">
            <button type="submit" class="btn btn-light px-5"><i class="icon-cloud-upload"></i> Iniciar Operação </button>
          </div>
         </div>
         </div>
      </div>
<!-- FIM DA NOVA OPERACAO  -->   
<?php 
}
if(isset($_GET['action']) && $_GET['action']=="q" && isset($_GET['origin']) && $_GET['origin']=="NEWOP"){

  $idope=$_SESSION['idop'];
  $localsql=new localsql();
  $busca = $localsql->busca_ope_idope($idope,$pdom); 
  foreach($busca as $line){
  $idcedente=$line['idcedente'];
  }  
$busca = $localsql->busca_cendente_id($idcedente,$pdom); //CARREGA O NOME DO CEDENTE
foreach($busca as $line){ 
$nomecedente=$line['razao'];		
}

//VERIFICA VALOR VENCIDO -----------------------------------------
$_SESSION['listaop']="";
$localsql=new localsql();
$buscaope = $localsql->relatorio4_ope_idcedente($idcedente,$pdom); 
foreach($buscaope as $line){
$idope=$line['idope'];	

$_SESSION['listaop']=$_SESSION['listaop'].$idope.',';

}

$listaop=$_SESSION['listaop'];
$listaop=rtrim($listaop, ', ');

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

$total_vencido=$tot_venc_che + $tot_venc_dup + $tot_venc_emp; //TOTAL VENCIDO

$id=$idcedente;
            $localsql=new localsql();
            $busca = $localsql->busca_pessoa_id($id,$pdom);
            foreach($busca as $line){
              $limite_credito=$line['limite_credito'];	
            }
?>
      <div class="col-lg-4" style="margin:auto;">
         <div class="card">
           <div class="card-body" style="margin:auto;">
           <div class="card-title">Operação #<?php echo $_SESSION['idop'];?> - <?php echo $nomecedente;?></div>
           <?php 
           if($limite_credito > 0){
           ?>
           <div class="card-title btn btn-info b_shadow_dark">Limite De Crédito: R$ <?= number_format($limite_credito, 2, ',', '.');?></div><br>
           <?php 
           }
           if($total_vencido > 0){
           ?>
           <div class="card-title btn btn-danger b_shadow_dark">Valor Vencido: R$ <?= number_format($total_vencido, 2, ',', '.');?></div>
           <?php 
           }
           ?>
           <hr>
           <div class="form-group" style="margin:auto;">
            <a href="?action=cad_duplicata&id=<?php echo $_SESSION['idop'];?>&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>">
            <button type="button" class="btn btn-light px-6"><i class="icon-layers"></i> Nova Duplicata</button></a>
            <a href="?action=cad_cheque&id=<?php echo $_SESSION['idop'];?>&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>">
            <button type="button" class="btn btn-light px-5"><i class="icon-layers"></i> Novo Cheque</button></a>
          </div>
          </form>
         </div>
         </div>
      </div>

<?php
}
if(isset($_GET['action']) && $_GET['action']=="q" && isset($_GET['origin']) && $_GET['origin']=="NEWOPF"){


  $idope=$_SESSION['idop'];
  $localsql=new localsql();
  $busca = $localsql->busca_ope_idope($idope,$pdom); 
  foreach($busca as $line){
  $idcedente=$line['idcedente'];
  }  
$busca = $localsql->busca_cendente_id($idcedente,$pdom); //CARREGA O NOME DO CEDENTE
foreach($busca as $line){ 
$nomecedente=$line['razao'];		
}  
?> 
 <div class="col-lg-6" style="margin:auto;">
         <div class="card">
           <div class="card-body" style="margin:auto;">
           <div class="card-title">Operação #<?php echo $_SESSION['idop'];?> - <?php echo $nomecedente;?></div>
           <hr>
           <div class="form-group" style="margin:auto;">
            <a href="proposta.php?action=start&id=<?php echo $_SESSION['idop'];?>&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>">
            <button type="button" class="btn btn-light px-5"><i class="icon-layers"></i> Nova Proposta (Valor Futuro)</button></a>
          </div>
          </form>
         </div>
         </div>
      </div>
<?php
}
if(isset($_GET['action']) && $_GET['action']=="cad_cheque" || $_GET['action']=="edt_cheque"){  

$idope=$_GET['id'];

$localsql=new localsql();
$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){
$idcedente=$line['idcedente'];	
$tipo_juros=$line['tipo_juros'];	
$status=$line['status'];	
}

if(isset($_GET['action']) &&  $_GET['action']=="edt_cheque"){
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']).$_GET['edt']);
  
  $load_value=true;

  if($_GET['key']==$counterkey){

  $seq=$_GET['edt'];
   
  $localsql=new localsql();
  $busca = $localsql->busca_cheque_seq($seq,$pdom);
  foreach($busca as $line){
  $idbanco=$line['idbanco'];	
  $agencia=$line['agencia'];	
  $nroconta=$line['nroconta'];	
  $nrocheque=$line['nrocheque'];	
  $valor=$line['valor'];	
  $fator=$line['fator'];	
  $iof=$line['iof'];	
  $advalorem=$line['advalorem'];	
  $maisdias=$line['maisdias'];	

  $idsacado=$line['idsacado'];	

$dt_vencimento=$line['dt_vencimento'];	
$simes=substr($dt_vencimento, 2, 2); $sidia=substr($dt_vencimento, 4, 2); $siano=substr($dt_vencimento, 0, 2);
$dt_vencimento="20".$siano.'-'.$simes.'-'.$sidia;

$dt_emissao=$line['dt_emissao'];	
$simes=substr($dt_emissao, 2, 2); $sidia=substr($dt_emissao, 4, 2); $siano=substr($dt_emissao, 0, 2);
$dt_emissao="20".$siano.'-'.$simes.'-'.$sidia;
}
}
}

?>
<!-- NOVO CHEQUE  --> 
<div class="col-lg-4">
         <div class="card">
           <div class="card-body">
           <?php 
        if($_GET['action']=="cad_cheque"){
          echo '<div class="card-title">Incluir Cheque</div>';
          $actionform="CAD";
        }
        else{
          echo '<div class="card-title">Editar Cheque</div>';
          $actionform="EDT";
          $_SESSION['edtseq']=$_GET['edt'];
          $_SESSION['edtidope']=$_GET['id'];
        }
        ?>
           <hr>
            <form id="operacao" method="POST" action="mvm_cheque.php?action=<?php echo $actionform;?>&<?php if(isset($_GET['origin'])){echo "origin=".$_GET['origin']."&";}?>key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR'])); ?>" autocomplete="off">
            <div class="form-group">
            <label for="input-4">Banco</label>
            <div class="custom-select-form">
              <span style="font-size:11px">Digite o ID ou Nome do banco para pesquisar</span>
						<input onfocus="clearInput(this)" required style="border: 1px solid #fff" <?php if(isset($load_value)){ echo 'value="'.$idbanco.'"';}?> placeholder="Digite o ID ou Nome do banco para pesquisar" 
						class="form-control" name="idbanco" list="bancos">
						<datalist id="bancos">
						<?php 
            $localsql=new localsql();
						$busca = $localsql->busca_bancos($pdom);
            foreach($busca as $line){
						$idbanco=$line['idbanco'];	
						$banco=$line['banco'];		
						?>
	          <option value="<?php echo $idbanco.' - '.$banco;?>"></option>
						<?php 
            }
            ?>	
            </datalist>
            <script>function clearInput(target){
            if (target.name== 'idbanco'){ target.value= "";}}
            </script>
           </div>
           </div>

          <div class="form-group">
             <label for="input-2">Agência</label>
             <input required type="number" <?php if(isset($load_value)){ echo 'value="'.$agencia.'"';}?> max="999999999999" name="agencia" class="form-control" id="input-2" placeholder="Numero Da Agência">
           </div>
           <div class="form-group">
             <label for="input-2">Nro. Conta</label>
             <input required type="text" <?php if(isset($load_value)){ echo 'value="'.$nroconta.'"';}?>  name="nroconta" class="form-control" id="input-2" placeholder="Numero Da Conta">
           </div>
           <div class="form-group">
             <label for="input-2">Nro. Cheque</label>
             <input type="number" <?php if(isset($load_value)){ echo 'value="'.$nrocheque.'"';}?>  max="9999999999" name="nrocheque" class="form-control" id="input-2" placeholder="Numero Do Cheque">
           </div>
          </div>           
          </div>           
          </div>

<div class="col-lg-3">
  <div class="card">
    <div class="card-body">   
    <div class="form-group">
             <label for="input-2">Valor</label>
             <input type="number" <?php if(isset($load_value)){ echo 'value="'.$valor.'"';}?>  max="9999999" step="any" name="valor" class="form-control" id="input-2" placeholder="0.00">
    </div>  
    <div class="form-group">
             <label for="input-2">Fator</label>
             <input type="number" max="100" step="any" name="fator" <?php if(isset($load_value)){ echo 'value="'.$fator.'"';}else{ echo 'value="'.$perc_default_juros.'"';}?>  class="form-control" id="input-2" placeholder="0.00">
    </div> 
<?php 
if($exibe_iof==1){
?>
    <div class="form-group">
             <label for="input-2">IOF</label>
             <input type="number" max="100" step="any" name="iof" <?php if(isset($load_value)){ echo 'value="'.$iof.'"';}else{ echo 'value="'.$iof_default.'"';}?> class="form-control" id="input-2" placeholder="0.00">
    </div> 	
<?php 
}
if($exibe_advalorem==1){
?>
    <div class="form-group">
             <label for="input-2">AD VALOREM</label>
             <input type="number" max="100" step="any" name="advalorem" <?php if(isset($load_value)){ echo 'value="'.$advalorem.'"';}else{ echo 'value="'.$advalorem_default.'"';}?> class="form-control" id="input-2" placeholder="0.00">
    </div> 	
<?php 
}
?>
       
     <div class="form-group">
             <label for="input-2">+Dias</label>
             <input type="number" max="9999"  <?php if(isset($load_value)){ echo 'value="'.$maisdias.'"';}?> name="maisdias" class="form-control" id="input-2" placeholder="0">
    </div>
    <div class="form-group">
             <label for="input-2">Data Vencimento</label>
             <input type="date" required <?php if(isset($load_value)){ echo 'value="'.$dt_vencimento.'"';}?>  name="dt_vencimento" class="form-control" id="input-2" placeholder="Data Emissão">
    </div> 
 
     <div hidden class="form-group">
             <label  for="input-2">Numero De Parcelas</label>
             <input type="number" max="<?php echo $nummaxparc;?>" value="0"  required name="numero_parcelas" class="form-control" id="input-2" placeholder="Numero De Parcelas">
    </div> 

         </div>
         </div>
      </div>
<div class="col-lg-5">
  <div class="card">
    <div class="card-body">   

    <div class="form-group">
             <label for="input-2">Data Emissão</label>
             <input type="date" required <?php if(isset($load_value)){ echo 'value="'.$dt_emissao.'"';}else{ echo 'value="'.date('Y-m-d').'"';}?> name="dt_emissao" class="form-control" id="input-2" placeholder="Data Emissão">
          </div>
                        
           <div class="form-group">
            <label for="input-4">Sacado</label>
            <div class="custom-select-form">
              <span style="font-size:11px">Digite o ID , Nome ou CPF/CNPJ do sacado para pesquisar</span>
						<input required onfocus="clearInput(this)" style="border: 1px solid #fff" <?php if(isset($load_value)){ echo 'value="'.$idsacado.'"';}?> placeholder="Digite o ID , Nome ou CPF/CNPJ do sacado para pesquisar" 
						class="form-control" name="idsacado" list="sacado" autocomplete="off">
						<datalist id="sacado">
						<?php 
            $localsql=new localsql();
						$busca = $localsql->busca_sacado_only($pdom);
            foreach($busca as $line){
						$idcendente=$line['id'];	
						$razao=$line['razao'];		
						?>
	          <option value="<?php echo $idcendente.' - '.$razao;?>"></option>
						<?php 
            }
            ?>	
            </datalist>
            </datalist>
            <script>function clearInput(target){
            if (target.name== 'idsacado'){ target.value= "";}}
            </script>
           </div>
           </div>
		      <div class="form-group">
          <?php 
        if($_GET['action']=="cad_cheque"){
         echo '<button type="submit" class="btn btn-light px-5"><i class="icon-cloud-upload"></i> Incluir Cheque</button>';
        }
        else{
          echo '<button type="submit" class="btn btn-light px-5"><i class="icon-cloud-upload"></i> Salvar Alterações </button>';
        }
        ?>  
          </div>
          </form>
         </div>
         </div>
      </div>      
<!-- / FIM DO NOVO CHEQUE  --> 

<!-- / NOVA DUPLICATA  -->   
<?php
}
if(isset($_GET['action']) && $_GET['action']=="cad_duplicata" || $_GET['action']=="edt_duplicata"){

  $idope=$_GET['id'];

  $localsql=new localsql();
  $busca = $localsql->busca_ope_idope($idope,$pdom);
  foreach($busca as $line){
  $idcedente=$line['idcedente'];	
  $tipo_juros=$line['tipo_juros'];	
  $status=$line['status'];	
  }  
 if(isset($_GET['action']) &&  $_GET['action']=="edt_duplicata"){
  $counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']).$_GET['edt']);
  
  $load_value=true;

  if($_GET['key']==$counterkey){

  $seq=$_GET['edt'];
   
  $localsql=new localsql();
  $busca = $localsql->busca_duplicata_seq($seq,$pdom);
  foreach($busca as $line){
  $nroduplicata=$line['nroduplicata'];	
  $valor=$line['valor'];	
  $fator=$line['fator'];	
  $iof=$line['iof'];	
  $advalorem=$line['advalorem'];	
  $maisdias=$line['maisdias'];	

  $idsacado=$line['idsacado'];	

$dt_vencimento=$line['dt_vencimento'];	
$simes=substr($dt_vencimento, 2, 2); $sidia=substr($dt_vencimento, 4, 2); $siano=substr($dt_vencimento, 0, 2);
$dt_vencimento="20".$siano.'-'.$simes.'-'.$sidia;

$dt_emissao=$line['dt_emissao'];	
$simes=substr($dt_emissao, 2, 2); $sidia=substr($dt_emissao, 4, 2); $siano=substr($dt_emissao, 0, 2);
$dt_emissao="20".$siano.'-'.$simes.'-'.$sidia;


}
}

}

?>
<!-- NOVA DUPLICATA  --> 
<div class="col-lg-4">
  <div class="card">
      <div class="card-body">
        <?php 
        if($_GET['action']=="cad_duplicata"){
          echo '<div class="card-title">Incluir Duplicata</div>';
          $actionform="CAD";
        }
        else{
          echo '<div class="card-title">Editar Duplicata</div>';
          $actionform="EDT";
          $_SESSION['edtseq']=$_GET['edt'];
          $_SESSION['edtidope']=$_GET['id'];
        }
        ?>
           <hr>
            <form id="operacao"  method="POST" action="mvm_duplicata.php?action=<?php echo $actionform;?>&<?php if(isset($_GET['origin'])){echo "origin=".$_GET['origin']."&";}?>key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"  autocomplete="off">
          <div class="form-group">
             <label for="input-2">Numero Duplicata</label>
             <input type="number" required autofocus name="nroduplicata" class="form-control" <?php if(isset($load_value)){ echo 'value="'.$nroduplicata.'"';}?> placeholder="Numero Duplicata">
           </div>
           <div class="form-group">
             <label for="input-2">Valor</label>
             <input type="number" required min="0" max="9999999" name="valor" class="form-control"  <?php if(isset($load_value)){ echo 'value="'.$valor.'"';}?> step="any" placeholder="0.00">
          </div> 
          <div class="form-group">
             <label for="input-2">Fator</label>
             <input type="number" max="100" step="any" name="fator" <?php if(isset($load_value)){ echo 'value="'.$fator.'"';}else{ echo 'value="'.$perc_default_juros.'"';}?>  class="form-control" id="input-2" placeholder="0.00">
    </div> 
<?php 
if($exibe_iof==1){
?>
    <div class="form-group">
             <label for="input-2">IOF</label>
             <input type="number" max="100" step="any" name="iof" <?php if(isset($load_value)){ echo 'value="'.$iof.'"';}else{ echo 'value="'.$iof_default.'"';}?> class="form-control" id="input-2" placeholder="0.00">
    </div> 	
<?php 
}
if($exibe_advalorem==1){
?>
    <div class="form-group">
             <label for="input-2">AD VALOREM</label>
             <input type="number" max="100" step="any" name="advalorem" <?php if(isset($load_value)){ echo 'value="'.$advalorem.'"';}else{ echo 'value="'.$advalorem_default.'"';}?> class="form-control" id="input-2" placeholder="0.00">
    </div> 	
<?php 
}
?>
 
    
     <div class="form-group">
             <label for="input-2">+Dias</label>
             <input type="number" max="9999"  name="maisdias" <?php if(isset($load_value)){ echo 'value="'.$maisdias.'"';}?> class="form-control" id="input-2" placeholder="0">
    </div>
    <div class="form-group">
             <label for="input-2">Data Vencimento</label>
             <input type="date" required name="dt_vencimento" <?php if(isset($load_value)){ echo 'value="'.$dt_vencimento.'"';}?> class="form-control" id="input-2" placeholder="">
    </div> 

     <div hidden class="form-group">
             <label for="input-2">Numero De Parcelas</label>
             <input type="number" max="<?php echo $nummaxparc;?>" value="0" required name="numero_parcelas" class="form-control" id="input-2" placeholder="Numero De Parcelas">
    </div> 

      </div>           
   </div>           
</div>

<div class="col-lg-5">
  <div class="card">
    <div class="card-body">   

    <div class="form-group">
             <label for="input-2">Data Emissão</label>
             <input type="date" required <?php if(isset($load_value)){ echo 'value="'.$dt_emissao.'"';}else{ echo 'value="'.date('Y-m-d').'"';}?> name="dt_emissao" class="form-control" id="input-2" placeholder="Data Emissão">
          </div>
                        
           <div class="form-group">
            <label for="input-4">Sacado</label>
            <div class="custom-select-form">
              <span style="font-size:11px">Digite o ID , Nome ou CPF/CNPJ do sacado para pesquisar</span>
						<input  onfocus="clearInput(this)" required style="border: 1px solid #fff" <?php if(isset($load_value)){ echo 'value="'.$idsacado.'"';}?> placeholder="Digite o ID , Nome ou CPF/CNPJ do sacado para pesquisar" 
						class="form-control" name="idsacado" list="cedentes"  autocomplete="off">
						<datalist id="cedentes">
						<?php 
            $localsql=new localsql();
						$busca = $localsql->busca_sacado_only($pdom);
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
            if (target.name== 'idsacado'){ target.value= "";}}
            </script>
           </div>
           </div>
		      <div class="form-group">
          <?php 
        if($_GET['action']=="cad_duplicata"){
         echo '<button type="submit" class="btn btn-light px-5"><i class="icon-cloud-upload"></i> Incluir Duplicata</button>';
        }
        else{
          echo '<button type="submit" class="btn btn-light px-5"><i class="icon-cloud-upload"></i> Salvar Alterações </button>';
        }
        ?>  
           
          </div>
         </div>
         </div>
      </div>      
<!-- FIM DA NOVA DUPLICATA  -->   
<?php 
}
?>

    </div><!--End Row-->

	<!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->

    </div>
    <!-- End container-fluid-->
    
   </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
          <?php echo $copyright;?>
        </div>
      </div>
    </footer>
	<!--End footer-->
	   
  </div><!--End wrapper-->


  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
	
 <!-- simplebar js -->
  <script src="assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- sidebar-menu js -->
  <script src="assets/js/sidebar-menu.js"></script>
  
  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>
	
</body>
</html>
<?php
}
else{
	header('Location:login.php');
}
?>

<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/mysql.php";
require "global_date.php";
require "header.php";
$mvmpg="true";

require "core/screen_controller.php";

//COLUMN SIZE
if($screen_mode=="low"){
  $colsize="6";
}
else{
  $colsize="4";
}

$localsql=new localsql();

//CARREGA DETALHES DA OPERACAO
$idope=$_GET['id'];
$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){
  $tipo_juros=$line['tipo_juros'];

  if($tipo_juros=="S"){
    $str_tipojuros="Simples";
  }
  else{
    $str_tipojuros="Composto";
  }
}
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
 <!-- Start wrapper-->
<div id="wrapper">
<?php 
require "sidebar.php";
require "topbar.php";
?>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

  <!--Start Dashboard Content-->
<?php 
if(isset($_GET['return']) && $_GET['return']=="success" ){
  $alerttag="Sucesso!"; 
  $alertcolor="info";
  $alert="Cadastro Concluído.";
}
elseif(isset($_GET['origin']) && $_GET['origin']=="NEWDUP" && isset($_GET['action']) && $_GET['action']=="D" ){
  $alerttag="Sucesso!"; 
  $alertcolor="info";
  $alert="Duplicata Incluída.";
}
if(isset($alert) && $alert!=""){
?>
<script>
setTimeout(function() {
$('#alert').fadeOut('fast');
}, 3000); 
</script>
  <div id="alert" class="alert alert-<?php echo $alertcolor;?> alert-dismissible" role="alert">
				   <button type="button" class="close" data-dismiss="alert">×</button>
				    <div class="alert-icon">
					 <i class="icon-info"></i>
				    </div>
				    <div class="alert-message">
				      <span><strong><?php echo $alerttag;?></strong><?php echo $alert;?></span>
				    </div>
</div>
<?php 
}
?>
<?php 
if(isset($_GET['action']) && $_GET['action']=="simulacao"){

$idsacado=$_POST['idsacado'];
$idsacado = explode("-", $idsacado);
$idsacado=$idsacado[0]; 

$busca = $localsql->busca_sacado_id($idsacado,$pdom); //CARREGA O NOME DO SACADO
foreach($busca as $line){$nomesacado=$line['razao'];	}

//print_r($_POST);

$valor=$_POST['valor'];
$valorpuro=$valor;
$fator=$_POST['fator'];
if($exibe_advalorem==1){
  $advalorem=$_POST['advalorem'];
}
if($exibe_iof==1){
  $iof=$_POST['iof'];
}
$vencimento=$_POST['vencimento'];
$numero_parcelas=$_POST['numero_parcelas'];
$intervalo_parcelas=$_POST['intervalo_parcelas'];
$vencimento=str_replace('-', '', $vencimento);
$vencimento=substr($vencimento, 2,6);
$dtprimeiraparc="20".$vencimento;
$primeira_parcela=substr($vencimento, 4,2).'/'.substr($vencimento, 2,2).'/20'.substr($vencimento, 0,2);

$hoje=date('Ymd');

//QUANTIDADE DE DIAS ATÉ A PRIMEIRA PARCELA
$diferenca = strtotime($dtprimeiraparc) - strtotime($hoje);
$diasantecede = floor($diferenca / (60 * 60 * 24)); 

//PERIODO DE DIAS TOTAIS DAS PARCELAS 
$periodoparc=$numero_parcelas * $intervalo_parcelas;


if($diasantecede > 30){
//CALCULA JUROS QUANDO A PRIMEIRA PARCELA É APÓS 30 DIAS 
$dias=$diasantecede - 30  + $periodoparc;
}
else{
  $dias=$periodoparc;
}

if($tipo_juros=="S"){
 require "calc_vf_juros_simples.php";
 $valor_parcela=$valor_previsao / $numero_parcelas;
}
else{
 require "calc_vf_juros_composto.php";
}

?>
<form id="proposta_pr" method="POST" action="proposta_pr.php?action=insert">
  <input name="idope" value="<?= $_GET['id']; ?>" hidden readonly>
  <input name="idsacado" value="<?= $_POST['idsacado']; ?>" hidden readonly>
  <input name="valor" value="<?= $_POST['valor']; ?>" hidden readonly>
  <input name="tipo_juros" value="<?= $tipo_juros; ?>" hidden readonly>
  <input name="fator" value="<?= $_POST['fator']; ?>" hidden readonly>
<?php if($exibe_iof==1){ ?><input name="iof" value="<?= $_POST['iof']; ?>" hidden readonly><?php } 
else{ ?><input name="iof" value="0" hidden readonly><?php }?>
<?php  if($exibe_advalorem==1){ ?> <input name="advalorem" value="<?= $_POST['advalorem']; ?>" hidden readonly><?php } 
else{ ?> <input name="advalorem" value="0" hidden readonly><?php }?>
<input name="numero_parcelas" value="<?= $_POST['numero_parcelas']; ?>" hidden readonly>
<input name="primeira_parcela" value="<?= $vencimento; ?>" hidden readonly>
<input name="intervalo_parcelas" value="<?= $intervalo_parcelas; ?>" hidden readonly>
<input name="valor_parcela" value="<?= $valor_parcela; ?>" hidden readonly>
<input name="valor_previsao_final" value="<?= $valor_previsao_final; ?>" hidden readonly>
</form>  
<div class="row mt-2">
     <div class="col-lg-8" style="max-width:580px">
        <div class="card">
           <div class="card-header"><button class="btn btn-light">Detalhes Da Proposta </button>  
             <div class="card-action">
             <div class="dropdown">
             <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
              <i class="icon-options"></i>
             </a>
              <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:void();"></a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:void();"></a>
               </div>
              </div>
             </div>
           </div>
         
           <div class="table-responsive">
             <table class="table align-items-center">
               <tbody>
               <tr>
                   <td style="width:150px"> <b>Sacado</b></td>
                   <td> <?= $_POST['idsacado']; ?></td>
                 </tr>
                 <tr>
                   <td style="width:150px"> <b>Valor</b></td>
                   <td> <?= number_format($valor, 2, ',', '.'); ?> R$</td>
                 </tr>
                 <tr>
                   <td style="width:150px"> <b>Tipo De Juros</b></td>
                   <td> <?= $str_tipojuros ?></td>
                 </tr>
                 <tr>
                   <td style="width:150px"> <b>Fator</b></td>
                   <td> <?= $fator ?> %</td>
                 </tr>
                 <?php 
                if($exibe_iof==1){
                  $iof=$_POST['iof'];
                  ?>
                   <tr>
                   <td style="width:150px"> <b>Fator</b></td>
                   <td> <?= $fator ?> %</td>
                 </tr>
                 <?php 
                 }
                 ?>
                     <?php 
                if($exibe_advalorem==1){
                  $advalorem=$_POST['advalorem'];
                  ?>
                   <tr>
                   <td style="width:150px"> <b>Advalorem</b></td>
                   <td> <?= $advalorem ?> %</td>
                 </tr>
                 <?php 
                 }
                 ?>
                  <tr>
                   <td style="width:150px"> <b>Nº De Parcelas</b></td>
                   <td> <?= $numero_parcelas ?></td>
                  </tr>
                  <tr>
                   <td style="width:150px"> <b> <?php   if($numero_parcelas > 1){echo "Primeira Parcela";}else{echo "Vencimento";}  ?></b></td>
                   <td> <?= $primeira_parcela ?></td>
                  </tr>
                  <?php
                  if($numero_parcelas > 1){
                  ?>
                  <tr>
                   <td style="width:150px"> <b>Intervalo Entre Parcelas</b></td>
                   <td> <?= $intervalo_parcelas ?> Dias</td>
                  </tr>
                  <tr>
                   <td style="width:150px"> <b>Valor Por Parcela</b></td>
                   <td> <?= number_format($valor_parcela, 2, ',', '.'); ?> R$</td>
                  </tr>
                  <?php 
                  }
                  ?>
                  <tr>
                   <td style="width:150px"> <b>Valor Total Da Proposta</b></td>
                   <td>  <?= number_format($valor_previsao_final, 2, ',', '.'); ?> R$</td>
                  </tr>
                  <tr>
                   <td style="width:150px"></td>
                   <td><button type="submit" form="proposta_pr" class="btn btn-success px-5 float-right"><i class="icon-cloud-upload"></i> Confirmar Proposta </button></td>
                  </tr>
               </tbody>
             </table>
           </div>
         </div>
     </div>
<?php 
}
?>
<!--Start Content-->	
<div class="col-lg-4" <?php if(isset($_GET['action']) && $_GET['action']!="simulacao"){ echo 'style="margin:auto"';} ?> >
  <div class="card">
      <div class="card-body">
        <div class="card-title">Nova Proposta</div>
           <hr>
            <form id="operacao"  method="POST" action="?action=simulacao&id=<?= $_GET['id']; ?>&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"  autocomplete="off">

            <div class="form-group">
            <label for="input-4">Sacado</label>
            <div class="custom-select-form">
              <span style="font-size:11px">Digite o ID , Nome ou CPF/CNPJ do sacado para pesquisar</span>
						<input  onfocus="clearInput(this)" required style="border: 1px solid #fff" <?php if(isset($_POST['idsacado'])){ echo 'value="'.$_POST['idsacado'].'"';}?> placeholder="Digite o ID , Nome ou CPF/CNPJ do sacado para pesquisar" 
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
             <label for="input-2">Valor</label>
             <input type="number" required min="0" max="9999999" name="valor" class="form-control"  <?php if(isset($_POST['valor'])){ echo 'value="'.$_POST['valor'].'"';}?> step="any" placeholder="0.00">
          </div> 

          <div class="form-group">
             <label for="input-2">Fator</label>
             <input type="number" <?php if(isset($_POST['fator'])){ echo 'value="'.$_POST['fator'].'"';}?> max="100" step="any" name="fator" class="form-control" id="input-2" placeholder="0.00">
          </div> 
<?php 
if($exibe_iof==1){
?>
    <div class="form-group">
             <label for="input-2">IOF</label>
             <input type="number" max="100" step="any" name="iof" <?php if(isset($_POST['iof'])){ echo 'value="'.$_POST['iof'].'"';}?> class="form-control" id="input-2" placeholder="0.00">
    </div> 	
<?php 
}
if($exibe_advalorem==1){
?>
    <div class="form-group">
             <label for="input-2">AD VALOREM</label>
             <input type="number" max="100" step="any" name="advalorem" <?php if(isset($_POST['advalorem'])){ echo 'value="'.$_POST['advalorem'].'"';}?> class="form-control" id="input-2" placeholder="0.00">
    </div> 	
<?php 
}
?>
 
    <div class="form-group">
             <label for="input-2">Data Primeira Parcela</label>
             <input type="date" required name="vencimento" <?php if(isset($_POST['vencimento'])){ echo 'value="'.$_POST['vencimento'].'"';}?> class="form-control" id="input-2" placeholder="">
    </div> 

     <div class="form-group">
             <label for="input-2">Numero De Parcelas</label>
             <input type="number" max="99"  required <?php if(isset($_POST['numero_parcelas'])){ echo 'value="'.$_POST['numero_parcelas'].'"';}?> name="numero_parcelas" class="form-control" id="input-2" placeholder="Numero De Parcelas">
    </div> 

    <div class="form-group">
             <label for="input-2">Intervalo De Dias Entre As Parcelas</label>
             <input type="number" max="30" <?php if(isset($_POST['intervalo_parcelas'])){ echo 'value="'.$_POST['intervalo_parcelas'].'"';}?> value="" required name="intervalo_parcelas" class="form-control" id="input-2" placeholder="Intervalo De Dias Entre As Parcelas">
    </div> 
    <hr>
     <button class="btn btn-primary float-right"> <i class="icon-wallet"></i> Simular </button>
      </div>           
   </div>           
</div>
<!--End Content-->

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
	<br><br><br><br>
  <br><br><br><br>
	<footer class="footer" >
      <div class="container" >
        <div class="text-center">
          <?php echo $copyright;?>
        </div>
      </div>
    </footer>
	<!--End footer-->
	
  <!--start color switcher
  
   <div class="right-sidebar">
    <div class="switcher-icon">
      <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
    </div>
    <div class="right-sidebar-content">

      <p class="mb-0">Gaussion Texture</p>
      <hr>
      
      <ul class="switcher">
        <li id="theme1"></li>
        <li id="theme2"></li>
        <li id="theme3"></li>
        <li id="theme4"></li>
        <li id="theme5"></li>
        <li id="theme6"></li>
      </ul>

      <p class="mb-0">Gradient Background</p>
      <hr>
      
      <ul class="switcher">
        <li id="theme7"></li>
        <li id="theme8"></li>
        <li id="theme9"></li>
        <li id="theme10"></li>
        <li id="theme11"></li>
        <li id="theme12"></li>
		<li id="theme13"></li>
        <li id="theme14"></li>
        <li id="theme15"></li>
      </ul>
      
     </div>
   </div>
  <!--end color switcher-->
   
  </div><!--End wrapper-->

  <?php 
  require "modal.php";
  ?>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
	
 <!-- simplebar js -->
  <script src="assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- sidebar-menu js -->
  <script src="assets/js/sidebar-menu.js"></script>
  <!-- loader scripts -->
  <script src="assets/js/jquery.loading-indicator.js"></script>
  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>
  <!-- Chart js -->
  
  <script src="assets/plugins/Chart.js/Chart.min.js"></script>
 
  <!-- Index js -->
  <script src="assets/js/index.js"></script>

  
</body>
</html>
<?php
}
else{
	header('Location:login.php');
}
?>
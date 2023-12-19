<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/conn_MYSQL.php";
require "core/mysql.php";
require "header.php";
$pg_action="despesa";
$localsql=new localsql();

$action=$_GET['action'];
if($action=='new'){
$cardtitle="Nova Despesa";
$buttonsubmit="Incluir";
}
elseif($action=='edt'){
$cardtitle="Editar Despesa";
$buttonsubmit="Salvar Alterações";

$load_value=true;

$seq=$_GET['id'];
$_SESSION['edt_despesa']=$seq;
$localsql=new localsql();
$busca = $localsql->busca_despesa_seq($seq,$pdom);
foreach($busca as $line){	
  $idhistorico=$line['historico'];	
  $descricao=$line['descricao'];	
  $valor=$line['valor'];
  $idlogin=$line['idlogin'];
  $emissao=$line['emissao'];	

$simes=substr($emissao, 2, 2); $sidia=substr($emissao, 4, 2); $siano=substr($emissao, 0, 2);
$emissao="20".$siano.'-'.$simes.'-'.$sidia;

}
}
?>
<body class="bg-theme bg-theme1">

<!-- start loader -->
<div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
<!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">
<?php 
require "sidebar.php";
require "topbar.php";
?>
  <div class="content-wrapper">
    <div class="container-fluid">

    <div class="row mt-3">
      <div class="col-lg-5"  style="margin:auto;">
         <div class="card">
           <div class="card-body">
           <div class="card-title"><?php echo $cardtitle;?></div>
           <hr>
           <form autocomplete="off" id="" method="POST" action="mvm_despesa_pr.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']))."&action=".$action;?>">
           <div class="form-group">
            <label for="input-1">Histórico De Lançamento</label>
            <input required onfocus="clearInput(this)" style="border: 1px solid #fff" <?php if(isset($load_value)){ echo 'value="'.$idhistorico.'"';}?> placeholder="Histórico De Lançamento" 
						class="form-control" name="idhistorico" list="historico">
						<datalist id="historico">
						<?php 
            $localsql=new localsql();
						$busca = $localsql->busca_historicos_despesa_all($pdom);
            foreach($busca as $line){
						$idhistorico=$line['idhistorico'];	
						$historico=$line['historico'];		
						?>
	          <option value="<?php echo $idhistorico.' - '.$historico;?>"></option>
						<?php 
            }
            ?>	
            </datalist>
            <script>function clearInput(target){
            if (target.name== 'idhistorico'){ target.value= "";}}
            </script>
           </div>
           <div class="form-group" style="display:flex;flex-direction:column">
            <label for="input-3">Descrição</label>
            <textarea required maxlength="500" style="flex:1"  name="descricao" rows="4" cols="55"><?php if(isset($load_value)){ echo $descricao;}?></textarea>
           </div>

           <div class="form-group">
            <label for="input-2">Valor R$</label>
            <input required type="number" <?php if(isset($load_value)){ echo 'value="'.$valor.'"';}?> max="9999999" step="any" name="valor" class="form-control" id="input-2" placeholder="0.00">
           </div>

           <div class="form-group">
             <label for="input-2">Data Emissão</label>
             <input type="date" required <?php if(isset($load_value)){ echo 'value="'.$emissao.'"';}else{ echo 'value="'.date('Y-m-d').'"';}?> name="emissao" class="form-control" id="input-2" placeholder="Data Emissão">
           </div>
 
           <div class="form-group float-right">
            <button type="submit" class="btn btn-light px-5"><i class="icon-cloud-upload"></i> <?php echo $buttonsubmit;?></button>
          </div>
          </form>
         </div>
         </div>
      </div>

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

<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/conn_MYSQL.php";
require "core/mysql.php";
require "header.php";
$pg_action="cfg";
$localsql=new localsql();

if(isset($_GET['update']) && $_GET['update']="true"){ //SALVA CONFIGURAÇÕES
$value=$_POST['dashnumreg'];$idcfg="1";
$localsql->update_cfg_id($idcfg,$value,$pdom);

$value=$_POST['iof_default'];$idcfg="2";
$localsql->update_cfg_id($idcfg,$value,$pdom);

$value=$_POST['perc_default_juros'];$idcfg="3";
$localsql->update_cfg_id($idcfg,$value,$pdom);

$value=$_POST['advalorem_default'];$idcfg="5";
$localsql->update_cfg_id($idcfg,$value,$pdom);

//IOF
if(isset($_POST['exibe_iof'])){
  $exibe_iof="1";
  $value="1";$idcfg="4";
$localsql->update_cfg_id($idcfg,$value,$pdom);
}
else{
$exibe_iof="0";

$value="0";$idcfg="4";
$localsql->update_cfg_id($idcfg,$value,$pdom);

$value="0";$idcfg="2";
$localsql->update_cfg_id($idcfg,$value,$pdom);
}

//AD VALOREM
if(isset($_POST['exibe_advalorem'])){
  $exibe_advalorem="1";
  $value="1";$idcfg="6";
  $localsql->update_cfg_id($idcfg,$value,$pdom);
}
else{
$exibe_advalorem="0";

$value="0";$idcfg="6";
$localsql->update_cfg_id($idcfg,$value,$pdom);

$value="0";$idcfg="5";
$localsql->update_cfg_id($idcfg,$value,$pdom);
}

$value=$_POST['nummaxparc'];$idcfg="7";
$localsql->update_cfg_id($idcfg,$value,$pdom);

}

//CARREGA CONFIGURAÇÕES 
$idcfg="1";$busca = $localsql->busca_cfgint_id($idcfg,$pdom);foreach($busca as $line){$dashnumreg=$line['value'];}

$idcfg="2";$busca = $localsql->busca_cfgint_id($idcfg,$pdom);foreach($busca as $line){$iof_default=$line['value'];}

$idcfg="3";$busca = $localsql->busca_cfgint_id($idcfg,$pdom);foreach($busca as $line){$perc_default_juros=$line['value'];}

$idcfg="4";$busca = $localsql->busca_cfgint_id($idcfg,$pdom);foreach($busca as $line){$exibe_iof=$line['value'];}

$idcfg="5";$busca = $localsql->busca_cfgint_id($idcfg,$pdom);foreach($busca as $line){$advalorem_default=$line['value'];}

$idcfg="6";$busca = $localsql->busca_cfgint_id($idcfg,$pdom);foreach($busca as $line){$exibe_advalorem=$line['value'];}

$idcfg="7";$busca = $localsql->busca_cfgint_id($idcfg,$pdom);foreach($busca as $line){$nummaxparc=$line['value'];}
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
      <div class="col-lg-4">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Configurações Gerais</div>
           <hr>
           <form id="cedente" method="POST" action="?update=true&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR'])); ?>">
           <div class="form-group">
            <label for="input-1">Numero De Registros No Dashboard</label>
            <input type="number" step="1" min="10" name="dashnumreg" value="<?php echo $dashnumreg; ?>" class="form-control" id="input-1" placeholder="">
           </div>
       
         </div>
         </div>
      </div>

      <div class="col-lg-4">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Valores Padrão</div>
           <hr>
           <div class="form-group">
            <label for="input-1">IOF</label>
            <input type="number" step="any" value="<?php echo $iof_default; ?>" name="iof_default" class="form-control" id="input-1" placeholder="0.00">
            <div class="icheck-material-white">
            <input type="checkbox" value="1" name="exibe_iof" id="user-checkbox1" <?php if($exibe_iof=="1"){echo 'checked';}?> />
            <label for="user-checkbox1">Exibir IOF Nos Lançamentos</label>
            </div> 
           </div>
           <div class="form-group">
            <label for="input-1">Ad Valorem</label>
            <input type="number" step="any" value="<?php echo $advalorem_default; ?>" name="advalorem_default" class="form-control" id="input-1" placeholder="0.00">
            <div class="icheck-material-white">
            <input type="checkbox" value="1" name="exibe_advalorem" id="user-checkbox2" <?php if($exibe_advalorem=="1"){echo 'checked';}?> />
            <label for="user-checkbox2">Exibir Ad Valorem Nos Lançamentos</label>
            </div> 
           </div>
      
           <div class="form-group">
            <label for="input-2">Percentual De Juros</label>
            <input type="number" value="<?php echo $perc_default_juros; ?>" step="any" name="perc_default_juros" class="form-control" id="input-2" placeholder="0">
           </div>

           <div hidden class="form-group">
            <label for="input-2">Numero Max. De Parcelas</label>
            <input type="number" value="<?php echo $nummaxparc; ?>" step="any" name="nummaxparc" class="form-control" id="input-2" placeholder="0">
           </div>
            

         </div>
         </div>
      </div>

      <div class="col-lg-3">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Salvar</div>
           <hr>
           <div class="form-group py-2">
           
		   <div class="icheck-material-white">
           <!--  <input type="checkbox" value="1" name="status" id="user-checkbox1" checked=""/>
            <label for="user-checkbox1">Alertar Sobre Pendencias Ao Abrir o Sistema</label>
            </div> -->
           </div>
           <div class="form-group">
            <center><button type="submit" class="btn btn-light px-5"><i class="icon-cloud-upload"></i> Salvar</button></center>
          </div>
          </form>
         </div>
         </div>
      </div>

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

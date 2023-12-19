<?php session_start();
date_default_timezone_set('America/Campo_Grande'); 
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/mysql.php";
require "core/screen_controller.php";
require "global_date.php";
require "header.php";
$pg_action="REL";
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
	<div class="card mt-3">
    <div class="card-content">
        <div <?php if(isset($_GET['relatorio'])){ echo " hidden ";}?> class="row row-group m-2">
       
          <div class="col-12 col-lg-12 col-xl-12 border-light">
                <div class="card-body">
                  <h5 class="text-white shadow_dark mb-0">Relatórios</h5>
                  <?php if($screen_mode=="low"){echo"<br>";}?>
                  <div class="progress my-3 b_shadow_dark" style="height:3px;color:#ffffff">
                       <div class="progress-bar" style="width:100%;background-color:#ffffff"></div>
                      </div>
  <a href="?relatorio=1&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"><button class="btn  my-1  btn-sm btn-light b_shadow_dark">01 - Relatório Mensal De Movimento </button></a><br>
  <a href="?relatorio=2&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"><button class="btn  my-1 btn-sm btn-light b_shadow_dark">02 - Relatório De Títulos a Vencer </button></a><br>
  <a href="?relatorio=3&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"><button class="btn  my-1 btn-sm btn-light b_shadow_dark">03 - Relatório de títulos vencidos  </button></a><br>
  <a href="?relatorio=4&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"><button class="btn  my-1 btn-sm btn-light b_shadow_dark">04 - Resumo De Pendências Por Cedente</button></a><br>
                </div>
            </div>   
        </div>
    </div>
 </div>  

 <?php 
 if(isset($_GET['relatorio'])){
  if (file_exists("relatorios/".$_GET['relatorio'].".php")) {
  require "relatorios/".$_GET['relatorio'].".php";
  }
  else{
   require "relatorios/index.php";
  }
 }
 ?>


	  <!--End Row-->

      <!--End Dashboard Content-->
	  
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
	<br><br><br><br><br><br><br><br>
	<footer class="footer" >
      <div class="container" >
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
  <!-- loader scripts -->
  <script src="assets/js/jquery.loading-indicator.js"></script>
  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>
  <!-- Chart js -->
  
  <script src="assets/plugins/Chart.js/Chart.min.js"></script>
 
  <!-- Index js -->
  <script src="assets/js/index.js"></script>

  
</body>
<script>
function printDiv(Relatorio) {
     var printContents = document.getElementById(Relatorio).innerHTML;
     var originalContents = document.body.innerHTML;
     
     document.body.innerHTML = printContents;

     window.print();
   
     document.body.innerHTML = originalContents;
}
</script> 
</html>
<?php
}
else{
	header('Location:login.php');
}
?>
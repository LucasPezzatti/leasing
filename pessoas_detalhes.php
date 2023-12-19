<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/mysql.php";
require "header.php";
require "core/screen_controller.php";
require "global_date.php";
$pg_action="REL_CLI";

$id=$_REQUEST['pessoa'];

$localsql = new localsql;
$busca = $localsql->busca_generica_pessoas_id($id,$pdom);	
foreach($busca as $line){
$razao=$line['razao'];
}

if($_GET['tipo']=="C"){
  $showtipo="Cedente";
  //BUSCA OPERACAO
  $busca_operacoes = $localsql->busca_generica_operacoes_x_cedente($id,$pdom);	
  }
  elseif($_GET['tipo']=="S"){
  $showtipo="Sacado";
  //BUSCA OPERACAO
  $busca_operacoes = $localsql->busca_generica_operacoes_pessoas_id($id,$pdom);	
  }
  elseif($_GET['tipo']=="A"){
    $showtipo="Cedente/Sacado";
    //BUSCA OPERACAO
    $busca_operacoes = $localsql->busca_generica_operacoes_pessoas_id($id,$pdom);	
    }

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
	<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
          <div style="margin-left:30px" class="dropdown">
             <form  class="form form-inline" method="POST" action="global_date_pr.php?origin=rel_cli&tipo=<?= $_GET['tipo']?>&pessoa=<?= $_REQUEST['pessoa']?>">  
              <input id="dateinput" type="date" style="height:37px;margin-right:5px" required value="<?php echo $datainishow;?>" name="dtini" class="form-control" id="input-2" placeholder="Data Inicial">
              <input type="date" style="height:37px;margin-right:5px" required value="<?php echo $datafinshow; ?>" name="dtfin" class="form-control" id="input-2" placeholder="Data Final">
              <button style="margin-right:30px" type="submit" class="btn btn-light px-5"><i class="icon-calendar"></i> Alterar Período</button> <h3 style="margin-top:8px"> Relatório De Movimento Por <?= $showtipo;?></h3>
          </div>
        </div>
    </div></form> 
 </div>  

	<div class="row">
	 <div id="relatorio"  class="col-12 col-lg-12"> <center><h3 class="onlyOnprint" style="margin-top:8px;display:none;"> Relatório De Movimento Por <?= $showtipo;?></h3></center>
	   <div class="card"> 
	     <div class="card-header printcolor">
       <b style="font-size:16px"><?= $id; ?>- <?= $razao; ?> | Período <?= $showperiodo; ?> </b>
       <span style="display:none;font-size:14px;float:right;padding-top:1px" class="onlyOnprint"> <?= date('d/m/Y H:i')?></span>
       <div class="card-action"> <button type="button" onclick="printDiv('relatorio')" style="float:right;margin-left:20px" class="btn btn-light noPrint"><i class="fa fa-print"></i> Imprimir</button> 
       </div>
		 </div>
     <div class="card-action">
      </div>
	       <div class="table-responsive">
                 <table class="table align-items-center table-flush table-bordered table-sm printcolor">
                  <thead>
                   <tr>
                     <th>ID</th>
                     <th>Emissão</th>
                     <th>Valor Total</th>
                     <th>Valor Pago</th>
                     <th>Lucro Previso</th>
                     <th class="noPrint">Status</th>
                     <th class="noPrint"></th>
                   </tr>
                  </thead>
                <tbody>
<?php
//PESQUISA
 foreach($busca_operacoes as $line){
 $id=$line['idmvmope1'];	
 
//CARREGA DETALHES DA OPERACAO
$idope=$id;
$idope_exist=0;
$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){	
$idope_exist=$line['idope'];	
$data=$line['data'];	
$idcedente=$line['idcedente'];	
$vlr_operacao=$line['vlr_operacao'];	
$vlr_pago=$line['vlr_pago'];	
$tipo_juros=$line['tipo_juros'];	
$status=$line['status'];	

$siano=substr($data, 0, 2); $simes=substr($data, 2, 2); $sidia=substr($data, 4, 2);
$data=$sidia.'/'.$simes.'/'.$siano;

$lucrobruto= $vlr_operacao - $vlr_pago;
}

if($idope_exist > 0){
require "global_status.php";
?>                    
                    <tr>
                    <td>#<?php echo $id;?></td>
                    <td><?php echo $data;?></button></td>
                    <td><?php echo number_format($vlr_operacao, 2, ',', '.');?></td>
                    <td><?php echo number_format($vlr_pago, 2, ',', '.');?></td>
                    <td><?php echo number_format($lucrobruto, 2, ',', '.');?></td>
                    <td class="noPrint"><div data-toggle="modal" data-target="#statusModal" class="cursor_help" id="status_<?php echo $statusclass;?>"></div></td>
                 <td class="cursor_pointer noPrint"><a href="operacao_detalhes.php?id=<?php echo $idope;?>">
                 <button class="btn btn-info">
                 <i class="zmdi zmdi-plus"></i> Detalhes </button></a></td>
                    <!-- 
					          <td>
                      <div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 10%"></div>
                        </div>
                    </td> -->
                   </tr>
                   <?php 
                   }
                   }
                   ?>
            </tbody>
          </table>
          
        </div>
        
	   </div> <div class="onlyOnprint" style="float:middle;text-align:center;display:none;border-top: 1px solid #D5D5D5"><p style="padding-top:10px;"><?php echo $copyright;?></div>
	 </div>
   
</div>
<!-- / End pagination-->			

	</div><!--End Row-->

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

</div>
</div>

	
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
	<!--Start footer-->
  <div style="position:relative; margin:auto;">
	<footer class="footer">
      <div class="container" >
        <div class="text-center">
          <?php echo $copyright;?>
        </div>
      </div>
    </footer>
  </div>
	<!--End footer-->
  <?php 
  require "modal.php";
  ?>

<script>
function printDiv(Relatorio) {
     var printContents = document.getElementById(Relatorio).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();
   
     document.body.innerHTML = originalContents;
}
</script> 

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
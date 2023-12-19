<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/mysql.php";
require "core/screen_controller.php";
require "global_date.php";
require "header.php";
$dash=true;
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
        <div class="row row-group m-2">
        <?php 
            $localsql=new localsql();
						$busca = $localsql->dash_despesas($dtini,$dtfin,$pdom);
            foreach($busca as $line){
             $totaldesp=$line['totaldesp'];
            }
            $totaldesp=number_format($totaldesp, 2, ',', '.');	
            ?>
          <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white  mb-0">R$ <?= $totaldesp; if($screen_mode=="low"){echo"<br><br>";}?><span class="float-right"> <i class="zmdi zmdi-long-arrow-down text-danger"></i></span></h5>
                  <?php if($screen_mode=="low"){echo"<br>";}?>
                  <div class="progress my-3 b_shadow_danger" style="height:3px;color:red">
                       <div class="progress-bar" style="width:100%;background-color:#f43643 "></div>
                      </div>
                      <p class="mb-0 text-white small-font"> <span class="float-left"><a href="receitas.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"> 
                        <button class="btn btn-sm btn-danger b_shadow_danger">Total Saídas </button></a></span></p><br>
                </div>
            </div>
            <?php 
            $busca = $localsql->dash_soma_receitas($dtini,$dtfin,$pdom);
             foreach($busca as $line){
                $totalrece=$line['totalrece'];
              }
              $totalrece=number_format($totalrece, 2, ',', '.');	
            ?>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white shadow_dark mb-0">R$ <?= $totalrece; if($screen_mode=="low"){echo"<br><br>";}?> <span class="float-right">  <i class="zmdi zmdi-long-arrow-up text-success"></i></span></h5>
                  <?php if($screen_mode=="low"){echo"<br>";}?>
                  <div class="progress my-3 b_shadow_dark" style="height:4px;">
                       <div class="progress-bar " style="width:100%;background-color:#04b962"></div>
                    </div>
                  <p class="mb-0 text-white small-font">
                  <span class="float-left">
				     </span></p><span class="float-left"><a href="receitas.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"> 
             <button class="btn btn-sm btn-success b_shadow_dark">Total Entradas </button> </a> </span><br>
                </div>
            </div>
            <?php 
            $totalope="0";
            $totalpg="0";
            $totalrece="0";
            $localsql=new localsql();
						$busca = $localsql->dash_lucro_previsto($dtini,$dtfin,$pdom);
            foreach($busca as $line){
             $totalope=$line['totalope'];
             $totalpg=$line['totalpg'];
            }
          
					$busca = $localsql->dash_soma_receitas_only($dtini,$dtfin,$pdom);
            foreach($busca as $line){
              $totalreceita=$line['totalrece'];
            }
         
            $lucroprevisto= $totalope + $totalreceita - $totalpg;
            $lucroprevisto=number_format($lucroprevisto, 2, ',', '.');	
            ?>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white shadow_dark mb-0">R$ <?php echo $lucroprevisto;  if($screen_mode=="low"){echo"<br><br>";}?> <span class="float-right">  <i class="zmdi zmdi-money"  style="color:#14b6ff"></i></span></h5>
                  <?php if($screen_mode=="low"){echo"<br>";}?>
                  <div class="progress my-3 b_shadow_dark" style="height:4px;">
                       <div class="progress-bar" style="width:100%;background-color:#14b6ff"></div>
                    </div>
                  <p class="mb-0 text-white small-font"> <span class="float-left">
                  </span> <button class="btn btn-sm btn-info b_shadow_dark"> Lucro Bruto Previsto  </button> 
                </div>
            </div>

            
        </div>
    </div>
 </div>  

<!--	  
	<div class="row">
     <div class="col-12 col-lg-8 col-xl-8">
	    <div class="card">
		 <div class="card-header">Ranking Anual De Vendas
		   <div class="card-action">
			 <div class="dropdown">
			 <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
			  <i class="icon-options"></i>
			 </a>
				<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item" href="javascript:void();">Action</a>
				<a class="dropdown-item" href="javascript:void();">Another action</a>
				<a class="dropdown-item" href="javascript:void();">Something else here</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="javascript:void();">Separated link</a>
			   </div>
			  </div>
		   </div>
		 </div>
		 <div class="card-body">
		    <ul class="list-inline">
			  <li class="list-inline-item"><i class="fa fa-circle mr-2 text-white"></i>2023</li>
			  <li class="list-inline-item"><i class="fa fa-circle mr-2 text-light"></i>2022</li>
			</ul>
			<div class="chart-container-1">
			  <canvas id="chart1"></canvas>
			</div>
		 </div>
		 
		 <div class="row m-0 row-group text-center border-top border-light-3">
		   <div class="col-12 col-lg-3">
		     <div class="p-3">
		       <h5 class="mb-0">11541 R$</h5>
			   <small class="mb-0">Média Mensal <span> <i class="fa fa-arrow-up"></i></span></small>
		     </div>
		   </div>
		   <div class="col-12 col-lg-3">
		     <div class="p-3">
		       <h5 class="mb-0">354</h5>
			   <small class="mb-0">Ticket Médio <span> <i class="fa fa-arrow-up"></i></span></small>
		     </div>
		   </div>
		   <div class="col-12 col-lg-3">
		     <div class="p-3">
		       <h5 class="mb-0">245.65</h5>
			   <small class="mb-0">Pages/Visit <span> <i class="fa fa-arrow-up"></i> 5.62%</span></small>
		     </div>
		   </div>
		    <div class="col-12 col-lg-3">
		     <div class="p-3">
		       <h5 class="mb-0">245.65</h5>
			   <small class="mb-0">Pages/Visit <span> <i class="fa fa-arrow-up"></i> 5.62%</span></small>
		     </div>
		   </div>
		 </div>

		</div>
	 </div>
         
     <div class="col-12 col-lg-4 col-xl-4">
        <div class="card">
           <div class="card-header">Formas De Pagamento
             <div class="card-action">
             <div class="dropdown">
             <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
              <i class="icon-options"></i>
             </a>
              <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:void();">Action</a>
              <a class="dropdown-item" href="javascript:void();">Another action</a>
              <a class="dropdown-item" href="javascript:void();">Something else here</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:void();">Separated link</a>
               </div>
              </div>
             </div>
           </div>
           <div class="card-body">
		     <div class="chart-container-2">
               <canvas id="chart1"></canvas>
			  </div>
           </div>
           <div class="table-responsive">
             <table class="table align-items-center">
               <tbody>
                 <tr>
                   <td><i class="fa fa-circle text-white mr-2"></i> Dinheiro</td>
                   <td>R$ 5856</td>
                   <td>55%</td>
                 </tr>
                 <tr>
                   <td><i class="fa fa-circle text-light-1 mr-2"></i>Cartão</td>
                   <td>R$ 2602</td>
                   <td>25%</td>
                 </tr>
                 <tr>
                   <td><i class="fa fa-circle text-light-2 mr-2"></i>PIX</td>
                   <td>R$ 1802</td>
                   <td>15%</td>
                 </tr>
                 <tr>
                   <td><i class="fa fa-circle text-light-3 mr-2"></i>Boleto</td>
                   <td>R$ 1105</td>
                   <td>5%</td>
                 </tr>
               </tbody>
             </table>
           </div>
         </div>
     </div>
	</div>

	 -->
	<div class="row">
	 <div class="col-12 col-lg-12">
	   <div class="card">
	     <div class="card-header"> Operações No Período
		  <div class="card-action">
             <div class="dropdown">
             <form class="form form-inline" method="POST" action="global_date_pr.php?origin=dash">  
              <input id="dateinput" type="date" style="height:37px;margin-right:5px" required value="<?php echo $datainishow;?>" name="dtini" class="form-control" id="input-2" placeholder="Data Inicial">
              <input type="date" style="height:37px;margin-right:5px" required value="<?php echo $datafinshow; ?>" name="dtfin" class="form-control" id="input-2" placeholder="Data Final">
        <button style="margin-right:30px" type="submit" class="btn btn-light px-5"><i class="icon-calendar"></i> Alterar Período</button> 

             <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
              <i class="icon-options"></i>
             </a>
              <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:void();">Todas Operações</a>
             
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="">
                <div data-toggle="modal" data-target="#statusModal" style="cursor: help;" id="status_pendente"></div> Pendentes</a>
              <a class="dropdown-item" href="">
                <div data-toggle="modal" data-target="#statusModal" style="cursor: help;" id="status_cancelada"></div> Canceladas</a>
               </div>
              </div>
             </div>
          </form>
		 </div>
	       <div class="table-responsive">
                 <table class="table align-items-center table-striped table-flush table-borderless table-sm">
                  <thead>
                   <tr>
                     <th>ID</th>
                     <th >Cedente</th>
                     <th>Tipo Calc.</th>
                     <th>Nº Docs</th>
                     <th>Vlr. Operação</th>
                     <th>Vlr. Pago</th>
                     <th>Lucro Bruto</th>
                     <th>Emissão</th>
                     <th>Status</th>
                     <th></th>
                   </tr>
                   </thead>
                   <tbody>
<?php 
$localsql=new localsql();

$idcfg="1";
$busca = $localsql->busca_cfgint_id($idcfg,$pdom);
foreach($busca as $line){
  $dashnumreg=$line['value'];
}

if(isset($_SESSION['filter_date'])){
$busca = $localsql->busca_ope_dashboard_filter_date($pdom); //BUSCA OS ULTIMOS POR DATA
}
else{
  $busca = $localsql->busca_ope_dashboard_filter_date($pdom); //BUSCA OS ULTIMOS POR DATA
}
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
                    <td <?= $columnsize; ?>><a class="btn btn-info" style="font-size:14px" href="operacao_detalhes.php?id=<?php echo $idope;?>">#<?php echo $idope;?></a></td>
                    <td <?= $columnsize; ?>><?php echo $idcedente.'-'.$nomecedente;?></td>
                    <td <?= $columnsize; ?>>
                    <button class="btn b_shadow_dark <?php if($tipo_calculo=="VP"){echo "btn-danger";}else{echo "btn-primary";}?>">
                    <?php echo $tipo_calculo;?></button>
                    </td>
                    <td <?= $columnsize; ?>><?php echo $counttotal;?></td>
                    <td <?= $columnsize; ?>><?php echo $sumtotal;?></td>
                    <td <?= $columnsize; ?>><?php echo $vlr_pago;?></td>
                    <td <?= $columnsize; ?>><?php echo $lucrobruto;?></td>
                    <td <?= $columnsize; ?>><?php echo $data;?></td>
                    <td <?= $columnsize; ?>><div data-toggle="modal" data-target="#statusModal" class="cursor_help" id="status_<?php echo $statusclass;?>"></div></td>
                 <td <?= $columnsize; ?> class="cursor_pointer"><a class="btn btn-info" href="operacao_detalhes.php?id=<?php echo $idope;?>">
                 <i style="font-size:16px;margin:auto;" class="zmdi zmdi-view-carousel"></i> Detalhes</a></td>
                    <!-- 
					          <td><div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 10%"></div>
                        </div></td> -->
                   </tr>
                   <?php 
                   }
                   ?>
                   
                 

          
  

                 </tbody></table>
               </div>
	   </div>
	 </div>
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
	
	<!--Start footer-->
	<br><br><br><br><br><br><br><br>
	<br><br><br><br><br><br><br><br>
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
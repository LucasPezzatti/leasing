<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/mysql.php";
require "header.php";
$pg_action="CAD";
?>

<?php 
$screen_mode="low";
$columnsize='style="width:80px"';
?>   
<script type="text/javascript">
    document.cookie = "Screen = "+screen.width ;
</script>

<?php 
if(isset($_COOKIE['Screen'])){
  $screensize =  $_COOKIE['Screen'];

  if($screensize > 1400){
    $screen_mode="high";
    $columnsize="";
  }
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
<?php 
if(isset($_GET['return']) && $_GET['return']=="success" ){
  $alerttag="Sucesso!"; 
  $alertcolor="info";
  $alert="Cadastro Concluído.";
}
elseif(isset($_GET['return']) && $_GET['return']=="edit_success" ){
  $alerttag="Sucesso!"; 
  $alertcolor="info";
  $alert="Edição Concluída.";
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
        <div class="row row-group m-0">
        </div>
    </div>
 </div>  

 <div class="card mt-3"  style="max-width:880px" >
    <div class="card-content">
        <div class="row row-group m-0">
        <?php 
            $localsql=new localsql();
						$busca = $localsql->count_cedentes_ativos($pdom);
            foreach($busca as $line){
             $totalnumcedente=$line['totalnumcedente'];
            }
            ?>
          <div class="col-8 col-lg-4 col-xl-4 border-light">
                <div class="card-body">
                  <h5 class="text-success shadow_dark mb-0"><?= $totalnumcedente; ?> Cedentes Ativos <span class="float-center"></span></h5>
                  <div class="progress my-3 b_shadow_dark" style="height:4px;color:000">
                       <div class="progress-bar " style="width:100%;background-color:#04b962"></div>
                      </div>
                      <p class="mb-0 text-white small-font"> <span class="float-left"><a href="#"> </a></span>   
                </div>
            </div>
            <?php 
            $busca = $localsql->count_sacados_ativos($pdom);
             foreach($busca as $line){
              $totalnumsacado=$line['totalnumsacado'];
             }
            ?>
            <div class="col-8 col-lg-4 col-xl-4 border-light">
                <div class="card-body">
                  <h5 class="text-warning shadow_dark mb-0"><?= $totalnumsacado; ?> Sacados Ativos <span class="float-center text-success"></span></h5>
                  <div class="progress my-3 b_shadow_dark" style="height:4px;">
                       
                       <div class="progress-bar" style="width:100%;background-color:#ff8800 "></div>
                    </div>
                  <p class="mb-0 text-white small-font">
                  <span class="float-left">
				     </span></p><span class="float-left"><a href="#"> 
            </a> </span><br>
                </div>
            </div>
            <?php 
            $busca = $localsql->count_ambos_ativos($pdom);
             foreach($busca as $line){
              $totalnumambos=$line['totalnumambos'];
             }
            ?>
            <div class="col-8 col-lg-4 col-xl-4 border-light">
                <div class="card-body">
                  <h5 class="text-white shadow_dark mb-0"><?= $totalnumambos; ?> Ambos Ativos <span class="float-center text-success"></span></h5>
                  <div class="progress my-3 b_shadow_dark" style="height:4px;">
                       
                       <div class="progress-bar" style="width:100%;background-color:#fff "></div>
                    </div>
                  <p class="mb-0 text-white small-font">
                  <span class="float-left">
				     </span></p><span class="float-left"><a href="#"> 
            </a> </span><br>
                </div>
            </div>

        </div>
    </div>
 </div>  

	<div class="row">
	 <div class="col-12 col-lg-12">
	   <div class="card">
	     <div class="card-header">Cadastro De Pessoas 
	
       <div class="card-action">
             <div class="dropdown">
             <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
              <i class="icon-options"></i>
             </a>
              <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="?filtro=">Todas Pessoas</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?filtro=C"> Cedente</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?filtro=S"> Sacado</a>
               </div>
              </div>
             </div>
		 </div>
     <div class="card-action">
       <span class="float-right">
        <br>
        <form class="form form-inline">
       <a href="cadastro_cedentes.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"> <button class="btn btn-success" type="button" style="margin-right:8px" >Novo Cadastro </button> </a>
       <input style="width:280px" type="text" name="S" class="form-control" id="input-1" placeholder="Pesquisar">
       <button class="btn btn-light" type="submit" style="margin-right:8px" ><i class="fa fa-search"></i> </button> </form>
      </span> </div>

	       <div class="table-responsive">
                 <table class="table align-items-center table-flush table-borderless table-sm">
                  <thead>
                   <tr>
                     <th <?= $columnsize; ?>>ID</th>
                     <th <?= $columnsize; ?>>Nome</th>
                     <th <?= $columnsize; ?>>CFP/CNPJ</th>
                     <th <?= $columnsize; ?>>Limite De Crédito</th>
                     <th <?= $columnsize; ?>>Tipo</th>
                     <th <?= $columnsize; ?>>Status</th>
                     <th <?= $columnsize; ?>></th>
                     <th <?= $columnsize; ?>></th>
                   </tr>
                   </thead>
                   <tbody>
<?php
$iteperpage=12;// NUMERO DE ITENS POR PAGINA

//PESQUISA
if(isset($_GET['S'])){
  $generica=strtoupper($_REQUEST['S']);	
  $localsql = new localsql;
  $busca = $localsql->busca_generica_pessoas($generica,$pdom);	
}
else{
  //LISTA COMPLETA	
  $localsql = new localsql;
  $busca = $localsql->count_pessoas_full($pdom);
  foreach($busca as $line){
  $itecount=$line['numpessoas'];
  $pages=ceil($itecount / $iteperpage);
  $lastpage=$pages;
  }

if (isset($_GET["page"])) {    
  $page= $_GET["page"];    
  }    
else{    
  $page=1;    
}  
$start_from = ($page-1) * $iteperpage;  

 $localsql=new localsql();
 $busca = $localsql->busca_pessoas_all_pagination($start_from,$iteperpage,$pdom); //BUSCA PESSOAS
}
 foreach($busca as $line){
 $id=$line['id'];	
 $razao=$line['razao'];	
 $cpf=$line['cpf'];	
 $cnpj=$line['cnpj'];
 $limite_credito=$line['limite_credito'];
 $tipo=$line['tipo'];

 if($tipo=='C'){
  $btncolor="success";
 }
 elseif($tipo=='S'){
  $btncolor="warning";
 }
 else{
  $btncolor="light";
 }
 
 if(isset($cnpj) && $cnpj!=""){
  $cpfcnpj=preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj);
 }
 else{
  $cpfcnpj=preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);;
 }
 
 $status_pessoa=$line['status'];	

require "global_status.php";
?>                    
                    <tr>
                    <td>#<?php echo $id;?></td>
                    <td><form id="form_details<?php echo $id;?>" action="pessoas_detalhes.php?tipo=<?php echo $tipo;?>&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>" method="POST">
                    <input hidden type="number" name="pessoa" value="<?= $id; ?>">
                    <button type="submit" form="form_details<?php echo $id;?>" class="btn btn-light"><?php echo $razao;?></button></form></td>
                    <td><?php echo $cpfcnpj;?></td>
                    <td><?php echo number_format($limite_credito, 2, ',', '.');?></td>
                    <td><button class="btn btn-<?= $btncolor; ?>"><?php echo $tipo;?></button></td>
                    <td><div data-toggle="modal" data-target="#statusModalPessoa" class="cursor_help" id="status_<?php echo $statuspclass;?>"></div></td>
                 <td class="cursor_pointer"><a href="cadastro_cedentes.php?id=<?php echo $id;?>&action=edit&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>">
                 <button class="btn btn-info">
                 <i class="zmdi zmdi-edit"></i> Editar </button></a></td>
                 <td>
                    <button type="submit" form="form_details<?php echo $id;?>" class="btn btn-light">Resumo</button></form></td>  
                   </tr>
                   <?php 
                   }
                   ?>
            </tbody></table>

            

        </div>
       
	   </div>

	 </div>

   <?php 
//PAGINATION 
if(isset($pages) and $pages>1){
?>
			<div class="pagination__wrapper" style="margin:auto;">
				<ul class="pagination">
					<li <?php if(!isset($page) || isset($page) && $page!="1"){ echo 'class="btn btn-light"';}?> style="margin:5px;">
					<?php 
					if (isset($_GET["page"])) {    
                    $pageid=$_GET["page"];    
                    }    
                    else{    
                    $pageid=1;    
                    }  
					if($pageid > 1){
					$prev=$pageid - 1;	
					?>
					<a href="?page=<?php echo $prev;?>" class="prev" title="previous page">&#10094;</a>
					<?php 
					}
					?>
					</li>
<?php 
if(isset($_GET['page']) and $_GET['page']>3){
$pageid=$_GET['page'] -2;
$pages=$pageid+4; 
if($pages > $lastpage){
$pages=$lastpage;
$pageid=$_GET['page'] -3;	
if($_GET['page']==$lastpage){
$pageid=$_GET['page'] -4;	
}
}
}
else{
$pageid=0; 	
if($pages>4){
$pages=4;
}
}
while($pageid < $pages){
$pageid++;					
?>
					<li style="margin:5px;" class="btn btn-light" ><a href="?page=<?php echo $pageid;?>" 
					<?php if(isset($_GET['page'])){
					if($_GET['page']==$pageid){
					echo 'class="active"';	
					}	
					}
					elseif($page==1 and $pageid==1){
					echo 'class="active"';	
					}
					?>>
					<?php echo $pageid;?></a></li>
                    <?php 
                    }
					if(isset($_GET['page'])){
                    if($_GET['page'] < $lastpage){
					$next=$_GET['page'] + 1;					
					?>			
					<li style="margin:5px;" class="btn btn-light" style=""><a href="?page=<?php echo $next;?>" class="next" title="next page">&#10095;</a></li>
					<?php
					}
					else{}
					}
                    else{
					?>
					<li style="margin:5px;" class="btn btn-light"><a href="?page=2" class="next" title="next page">&#10095;</a></li>
					<?php
					}
					?>
				</ul>
			</div>
<?php 
}
?>		
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
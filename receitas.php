<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/mysql.php";
require "global_date.php";
require "header.php";
$pg_action="RECEITAS";

if(isset($_GET['action']) && $_GET['action']=="excluir"){
 
  $seq=$_POST['seq'];
  $idlogin=$_SESSION['idlogin'];
 
 $localsql=new localsql();
 $localsql->upd_mvmfin1_seq_excluir($seq,$idlogin,$pdom);
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

<?php 
 $localsql=new localsql();
 $buscarec = $localsql->busca_receitas_date_tela_entrada($dtini,$dtfin,$pdom); //BUSCA RECEITAS

 foreach($buscarec as $line){
  $seq=$line['seq'];	
  $idhistorico=$line['historico'];	
  $descricao=$line['descricao'];	
  $valor=$line['valor'];
  $idlogin=$line['idlogin'];
  $emissao=$line['emissao'];	
  $status_fin=$line['status'];	

$siano=substr($emissao, 0, 2); $simes=substr($emissao, 2, 2); $sidia=substr($emissao, 4, 2);
$emissao=$sidia.'/'.$simes.'/'.$siano;

$busca = $localsql->busca_nome_login_log($idlogin,$pdom); //CARREGA O NOME DO CEDENTE
$nomeusulog=$busca['nome'];		

 $busca = $localsql->busca_historico_id($idhistorico,$pdom); //BUSCA DESPESAS
 foreach($busca as $line){
 $historico=$line['historico'];	
 }
?>
<!-- MODAL DELETAR LANÇAMENTO SEQ -->
<div class="modal fade" id="delete<?php echo $seq;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Realmente Deseja Excluir Este Lançamento ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="margin:auto"> 
      _________________________________________________________________
      <h5 class="text-dark"><b>SEQ</b> <?php echo $seq;?></h5>
      <h6 class="text-dark"><b></b> <?php echo $historico;?></h6>
      <button type="button" class="btn btn-dark"><i class="icon icon-speech"></i>  <?php echo $descricao; ?> </button>
      <br>
      <br>
      <button class="btn btn-success btn-lg"><?php echo number_format($valor, 2, ',', '.');?> R$ </button>
      <br>
      <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-close"></i> Voltar</button>
        <form id="excluir<?php echo $seq;?>" action="?action=excluir&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>" method="POST">
        <input hidden type="number" value="<?php echo $seq;?>" name="seq">
        <button type="submit" form="excluir<?php echo $seq;?>" class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</button></form>
      </div>
    </div>
  </div>
</div>
</div>
<?php 
 }
?>

        </div>
    </div>
 </div>  

	<div class="row">
	 <div class="col-12 col-lg-12">
	   <div class="card">
	     <div class="card-header">Financeiro - Receitas/Entradas
		 </div>
     <div class="card-action">
       <span class="float-right">
        <br>
        <form class="form form-inline" method="POST" action="global_date_pr.php?origin=receitas">
       <a href="mvm_receita.php?action=new&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"> <button class="btn btn-danger" type="button" style="margin-right:8px" >Novo Lançamento </button> </a>
       <input type="date" style="height:36px" required value="<?php echo $datainishow;?>" name="dtini" class="form-control" id="input-2" placeholder="Data Inicial">
       <input type="date" style="height:36px" required value="<?php echo $datafinshow; ?>" name="dtfin" class="form-control" id="input-2" placeholder="Data Final">
       <input hidden style="width:280px" type="text" name="S" class="form-control" id="input-1" placeholder="Pesquisar" style="margin-right:8px" >
       <button class="btn btn-light" type="submit" style="margin-right:8px" ><i class="fa fa-search"></i> </button> 
       </form>
      </span> </div>

	       <div class="table-responsive">
                 <table class="table align-items-center table-flush table-borderless table-sm">
                  <thead>
                   <tr>
                     <th>SEQ</th>
                     <th>Historico</th>
                     <th>Descrição</th>
                     <th>Valor</th>
                     <th>Data Lançamento</th>
                     <th>Login</th>
                     <th>Status</th>
                     <th></th>
                     <th></th>
                   </tr>
                   </thead>
                   <tbody>
<?php 
 foreach($buscarec as $line){
 $seq=$line['seq'];	
 $idhistorico=$line['historico'];	
 $descricao=$line['descricao'];	
 $valor=$line['valor'];
 $idlogin=$line['idlogin'];
 $emissao=$line['emissao'];	
 $status_fin=$line['status'];	

$siano=substr($emissao, 0, 2); $simes=substr($emissao, 2, 2); $sidia=substr($emissao, 4, 2);
$emissao=$sidia.'/'.$simes.'/'.$siano;

$busca = $localsql->busca_nome_login_log($idlogin,$pdom); //CARREGA O NOME DO CEDENTE
$nomeusulog=$busca['nome'];		

 $busca = $localsql->busca_historico_id($idhistorico,$pdom); //BUSCA HISTORICO
 foreach($busca as $line){
 $historico=$line['historico'];	
 }


require "global_status.php";
?>                    
                    <tr>
                    <td style="font-size:12px;">#<?php echo $seq;?></td>
                    <td style="font-size:11px;"><span class="cursor_help pulse" title="ID HISTORICO: <?php echo $idhistorico;?>"><?php echo $historico;?></span></td>
                    <td style="font-size:11px"><?php echo $descricao;?></td>
                    <td style="font-size:13px;"><?php echo number_format($valor, 2, ',', '.');?> R$</td>
                    <td><?php echo $emissao;?></td>
                    <td style="font-size:11px"><?php echo $idlogin.'.'.$nomeusulog;?></td>
                    <td><div data-toggle="modal" data-target="#statusModalFinanceiro" class="cursor_help" id="status_<?php echo $statusfclass;?>"></div></td>
                 <td class="cursor_pointer"><a class="btn btn-info" href="mvm_receita.php?id=<?php echo $seq;?>&action=edt&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>">
                 <i class="zmdi zmdi-edit"></i> Editar</a></td>
                 <td class="cursor_pointer"><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $seq;?>">
                 <i class="fa fa-trash"></i> Excluir</a></td>
                    <!-- 
					          <td>
                      <div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 10%"></div>
                        </div>
                    </td> -->
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
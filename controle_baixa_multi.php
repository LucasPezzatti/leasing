<?php session_start();
error_reporting(0);
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/conn_MYSQL.php";
require "core/mysql.php";
require "header.php";
$pg_action="CTRBAX";
$localsql=new localsql(); 

if(isset($_GET['action']) && $_GET['action']=="baixa"){

  foreach($_POST as $titulo => $value){
    //LIST POST INPUTS 
    $titulo=explode("-",$titulo);
    $seq=$titulo[0];
    $tipodoc=$titulo[1];

$dt_status=date('ymd');
$emissao=$dt_status;

  //UPDATE CHEQUE ------------------------------------------------------------------------------------------------------
  if($tipodoc=='cheque'){

    $busca = $localsql->busca_cheque_seq($seq,$pdom);
    foreach($busca as $line){
     $nrocheque=$line['nrocheque'];	
     $idmvmop1=$line['idmvmop1'];	
     $valor=$line['valor'];	
    }

    //ATUALIZA CHEQUE PARA STATUS PAGO
    $localsql->upd_cheque_baixa($seq,$dt_status,$pdom);
    
  //INCLUI LOG DE MOVIMENTO
  $acao="Baixa De Cheque. Nº: ".$nrocheque. " - VALOR: ".$valor." R$";
  $date=date('ymdHi');
  $idlogin=$_SESSION['idlogin'];
  $localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom); 
  
  //ADD MVM FINANCEIRO REF A BAIXA 
  $descricao="Baixa De Cheque. Nº: ".$nrocheque;
  $historico="2"; // HISTORICO PADRÃO PARA BAIXA DE CHEQUE (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
  $tipo_mvm="E";
  $status="2";
  $localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
  }
  elseif($tipodoc=='duplicata'){  //UPDATE DUPLICATA ------------------------------------------------------------------------

    $busca = $localsql->busca_duplicata_seq($seq,$pdom);
    foreach($busca as $line){
     $nroduplicata=$line['nroduplicata'];	
     $idmvmop1=$line['idmvmop1'];	
     $valor=$line['valor'];		
     }

    //ATUALIZA DUPLICATA PARA STATUS PAGO
    $localsql->upd_duplicata_baixa($seq,$dt_status,$pdom);

//INCLUI LOG DE MOVIMENTO
$acao="Baixa De Duplicata. Nº: ".$nroduplicata. " - VALOR: ".$valor." R$";
$date=date('ymdHi');
$idlogin=$_SESSION['idlogin'];
$localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom); 

//ADD MVM FINANCEIRO REF A BAIXA 
$descricao="Baixa De Duplicata. Nº: ".$nroduplicata;
$historico="3"; // HISTORICO PADRÃO PARA BAIXA DE DUPLICATA (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
$tipo_mvm="E";
$status="2";
$localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
}  
elseif($tipodoc=='carne'){
  //ATUALIZA CARNE PARA STATUS PAGO
  $localsql->upd_carne_baixa($seq,$dt_status,$pdom);
 
  $busca = $localsql->busca_tblmvmfinprop2_seq_only($seq,$pdom);
  foreach($busca as $line){
   $idmvmfinprop=$line['idmvmfinprop'];	
   $numparcela=$line['parcela'];			
   $dtemissao=$line['emissao'];	
   $valor=$line['valor'];	
   }  
   $busca = $localsql->busca_tblmvmfinprop1_idmvmfinprop($idmvmfinprop,$pdom);
   foreach($busca as $line){
    $idmvmop1=$line['idope'];	
   }

  
//INCLUI LOG DE MOVIMENTO
$acao="Baixa Da Parcela ".$numparcela." Do Carnê. Nº: ".$idmvmfinprop. " - VALOR: ".$valor." R$";
$date=date('ymdHi');
$idlogin=$_SESSION['idlogin'];
$localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom); // ####################################################################

//ADD MVM FINANCEIRO REF A BAIXA 
$descricao="Baixa Da Parcela ".$numparcela." Do Carnê. Nº: ".$idmvmfinprop;
$historico="6"; // HISTORICO PADRÃO PARA BAIXA DE PARCELA DO CARNE(TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
$tipo_mvm="E";
$status="2";
$localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
}

}
echo '<script>window.location.href = "controle_baixa.php?origin=multi_baixa" </script>';
die;
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
      <div class="col-lg-12"  style="margin:auto;max-width:1200px">
         <div class="card">
<form id="multibaixa" action="?action=baixa" method="POST">
<?php 
foreach($_REQUEST as $var => $value){
    //LIST POST INPUTS 
    echo '<input hidden type="text" value="'.$var.'" name="'.$var.'"/>';

    }
?>
</form>

           <div class="card-body">
           <div class="card-title"><h4 class="text-center">Baixa De Títulos Em Lote</h4></div>
           <hr>
           <div class="table-responsive"> <b> Títulos Selecionados </b>
                 <table class="table align-items-center table-flush table-striped table-bordered table-sm">
                  <thead>
                   <tr>
                     <th style="width:80px">Tipo  </th>
                     <th <?= $columnsize; ?>>Nº </th>
                     <th <?= $columnsize; ?>>Emissão</th>
                     <th <?= $columnsize; ?>>Sacado </th>
                     <th <?= $columnsize; ?>>Valor R$</th>
                     <th <?= $columnsize; ?>>Vencimento </th>
                     </tr>
                   </thead>
                   <tbody>

                   <?php 
                   foreach($_REQUEST as $titulo => $value){
                    //LIST POST INPUTS 
                    $titulo=explode("-",$titulo);
                    $seq=$titulo[0];
                    $tipodoc=$titulo[1];

                    if($tipodoc=="cheque"){
                        $localsql=new localsql();
                        $busca = $localsql->busca_cheque_seq($seq,$pdom);
                        foreach($busca as $line){
                         $nrocheque=$line['nrocheque'];	
                         $dtemissao=$line['dt_emissao'];	
                         $idsacado=$line['idsacado'];	
                         $valor=$line['valor'];	
                         $dtvencimento=$line['dt_vencimento'];	
                        }
                    }
                    elseif($tipodoc=="duplicata"){
                        $localsql=new localsql();
                        $busca = $localsql->busca_duplicata_seq($seq,$pdom);
                        foreach($busca as $line){
                         $nroduplicata=$line['nroduplicata'];	
                         $dtemissao=$line['dt_emissao'];
                         $idsacado=$line['idsacado'];	
                         $valor=$line['valor'];		
                         $dtvencimento=$line['dt_vencimento'];	
                         }
                    }
                    elseif($tipodoc=="carne"){
                        $localsql=new localsql();
                        $busca = $localsql->busca_tblmvmfinprop2_seq_only($seq,$pdom);
                        foreach($busca as $line){
                         $idmvmfinprop=$line['idmvmfinprop'];	
                         $parcela=$line['parcela'];	
                         $dtemissao=$line['emissao'];	
                         $idsacado=$line['idsacado'];	
                         $valor=$line['valor'];	
                         $dtvencimento=$line['dt_vencimento'];	
                         }  
                    }
  
                    $siano=substr($dtvencimento, 0, 2); $simes=substr($dtvencimento, 2, 2); $sidia=substr($dtvencimento, 4, 2);
                    $dtvencimento=$sidia.'/'.$simes.'/'.$siano;

                    $nomecedente="";	
                    $id=$idsacado;	
                    $busca = $localsql->busca_pessoa_id($id,$pdom);
                    foreach($busca as $line){
                     $nomesacado=$line['razao'];	
                    }

                    $valor = number_format($valor, 2, ',', '.');
                    
                  $siano=substr($dtemissao, 0, 2); $simes=substr($dtemissao, 2, 2); $sidia=substr($dtemissao, 4, 2);
                  $dtemissao=$sidia.'/'.$simes.'/'.$siano;
                   ?>
                    <tr>
                    <td>
                    <?php if($tipodoc=="cheque"){ echo '<button style="width:100px" class="btn btn-warning btn_action_detalhes"><i style="font-size:12px" class="icon icon-file"></i> Cheque </button>';} 
                    elseif($tipodoc=="duplicata"){echo '<button  style="width:100px" class="btn btn-primary btn_action_detalhes"><i style="font-size:12px" class="icon icon-file"></i> Duplicata </button>';} 
                    elseif($tipodoc=="carne"){echo '<button  style="width:100px" class="btn btn-danger btn_action_detalhes"><i style="font-size:12px" class="icon icon-file"></i> Carnê </button>';} ?>
                    </td>
                    <td><?php if($tipodoc=="cheque"){ echo $nrocheque;}elseif($tipodoc=="duplicata"){echo $nroduplicata;}elseif($tipodoc=="carne"){echo  $idmvmfinprop."(".$parcela.")";}?></td>
                    <td><?= $dtemissao;?></td>
                    <td><?= $idsacado;?>-<?= $nomesacado;?></td>
                    <td><?= $valor;?></td>
                    <td><?= $dtvencimento;?></td>
                   </tr>
<?php
}
?>
</tbody>
</table>
</div>
<div style="float:right;padding-top:15px">
        <button style="width:300px;" form="multibaixa" type="submit" class="btn btn-success btn_action_detalhes"> 
        <i style="font-size:12px" class="icon icon-wallet"></i> Baixar Títulos</button></form></div>     
</div>

<?php 
  require "modal.php";
  require "modal_filters.php";
  ?>
 </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
     <!--Start Back To Top Button-->
     <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	<!--Start footer-->
	<footer class="footer" >
      <div class="container" >
        <div class="text-center">
          <?php echo $copyright;?>
        </div>
      </div>
    </footer>
	<!--End footer-->

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
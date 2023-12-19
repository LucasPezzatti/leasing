<?php session_start();
error_reporting(0);
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/conn_MYSQL.php";
require "core/mysql.php";
require "header.php";
$pg_action="CTRBAX";
$localsql=new localsql(); 

if(isset($_GET['action']) &&  $_GET['action']=="update"){
//echo "<center>DEBUG ON<br>";  
//print_r($_POST);
$seq=$_POST['seq'];
$parcela=$_POST['parcela'];
$nroduplicata=$_POST['nroduplicata'];
$nrocheque=$_POST['nrocheque'];
$idmvmfinprop=$_POST['idmvmfinprop'];
$historico=$_POST['idhistorico'];
$valor=$_POST['valor'];
$vencimento=$_POST['novo_vencimento'];
$vencimento=str_replace('-', '', $vencimento);
$dt_vencimento=substr($vencimento, 2,6); 
$idlogin=$_SESSION['idlogin'];   
$tipo_mvm="E";
$status="2";
$emissao=date('ymd');

if($nrocheque!=""){
  echo "<br>UPDATE CHEQUE";
  //UPDATE DT VENCIMENTO
  $localsql->upd_cheque_pro_vencimento($seq,$dt_vencimento,$pdom); 
 
  //ADD MVM ENTRADA
  echo "<br><br> DESCRICAO: ".$descricao="Ref. prorrogação do vencimento do Cheque #".$nrocheque;
  $localsql->add_despesa($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);

}
elseif($nroduplicata!=""){
  echo "<br>UPDATE DUPLICATA";
  //UPDATE DT VENCIMENTO
  $localsql->upd_duplicata_pro_vencimento($seq,$dt_vencimento,$pdom); 

   //ADD MVM ENTRADA
   echo "<br><br> DESCRICAO: ".$descricao="Ref. prorrogação do vencimento da Duplicata #".$nroduplicata;
   $localsql->add_despesa($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
}
elseif($idmvmfinprop!=""){
  echo "<br>UPDATE CARNE";
  //UPDATE DT VENCIMENTO
  $localsql->upd_carne_pro_vencimento($seq,$dt_vencimento,$pdom); 

   //ADD MVM ENTRADA
   echo "<br><br> DESCRICAO: ".$descricao="Ref. prorrogação do vencimento da Parcela #".$parcela." do Carnê #".$idmvmfinprop;
   $localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
}



echo '<script>window.location.href = "controle_baixa.php?origin=pro_vencimento" </script>';
die;
}

if(isset($_GET['nc']) && $_GET['nc']!=""){
$cardtitle="Alterar Vencimento Do Cheque Incluindo Lançamento De Juros";
$buttonsubmit="Baixar Cheque";
$nrocheque=$_GET['nc'];
$nroduplicata=null;
$idmvmfinprop=null;
$tpdoc="cheque";
}
elseif(isset($_GET['nd']) && $_GET['nd']!=""){
$cardtitle="Alterar Vencimento Da Duplicata Incluindo Lançamento De Juros";
$buttonsubmit="Baixar Duplicata";
$nrocheque=null;
$idmvmfinprop=null;
$nroduplicata=$_GET['nd'];
$tpdoc="duplicata";
}
elseif(isset($_GET['np']) && $_GET['np']!=""){
  $cardtitle="Alterar Vencimento Do Carnê Incluindo Lançamento De Juros";
  $buttonsubmit="Baixar Carnê";
  $nrocheque=null;
  $nroduplicata=null;
  $idmvmfinprop=$_GET['np'];
  $tpdoc="carne";
}
$seq=$_GET['seq'];
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
      <div class="col-lg-4"  style="margin:auto;">
         <div class="card">
           <div class="card-body">
           <div class="card-title"><?php echo $cardtitle;?></div>
           <hr>
           <form autocomplete="off" id="" method="POST" action="?action=update">
           <div class="form-group">
            <?php 
             $buscatitulos = $localsql->lista_titulos_tela_baixa_seq_full($seq,$nrocheque,$nroduplicata,$idmvmfinprop,$pdom); 
             foreach($buscatitulos as $line){
              $seq=$line['seq'];	
              $idmvmop1=$line['idmvmop1'];	
              $nrocheque=$line['nrocheque'];	
              $nroduplicata=$line['nroduplicata'];	
              $parcela=$line['parcela'];	
              $id=$line['idsacado'];	
              $fator=$line['fator'];
              if($fator==""){$fator=0;}	
              $iof=$line['iof'];	
              if($iof==""){$iof=0;}	
              $advalorem=$line['advalorem'];	
              if($advalorem==""){$advalorem=0;}	
              $percjuros=$fator + $iof + $advalorem;
              $status_fin=$line['status'];	
              $dtemissao=$line['dt_emissao'];	
              $dtvencimento=$line['dt_vencimento'];	
              $valor=$line['valor'];	
              }
              $nomesacado="N/A";		
              $busca = $localsql->busca_cendente_id($id,$pdom); //CARREGA O NOME DO CEDENTE
              foreach($busca as $line){ 
              $nomesacado=$line['razao'];		
              }
               $simes=substr($dtemissao, 2, 2); $sidia=substr($dtemissao, 4, 2); $siano=substr($dtemissao, 0, 2);
               $dtemissao=$sidia."/".$simes."/20".$siano; 

               $simes=substr($dtvencimento, 2, 2); $sidia=substr($dtvencimento, 4, 2); $siano=substr($dtvencimento, 0, 2);
               $dtvencimento=$sidia."/".$simes."/20".$siano; 

             

              if($tpdoc=='cheque'){
                echo '<label for="input-1">Cheque Numero: '.$nrocheque.'</label><br>';
                }
                elseif($tpdoc=='duplicata'){
                  echo '<label for="input-1">Duplicata Numero: <b class="text-white">'.$nroduplicata.'</b></label><br>';
                } 
                elseif($tpdoc=='carne'){
                  echo '<label for="input-1">Parcela Numero: <b class="text-white">'.$parcela.'</b> <br> Carnê Numero: <b class="text-white">'.$idmvmfinprop.'</b></label><br>';
                  $busca = $localsql->busca_tblmvmfinprop1_seq($idmvmfinprop,$seq,$pdom); //CARREGA O NOME DO CEDENTE
                  foreach($busca as $line){ 
                    $fator=$line['fator'];
                    if($fator==""){$fator=0;}	
                    $iof=$line['iof'];	
                    if($iof==""){$iof=0;}	
                    $advalorem=$line['advalorem'];	
                    if($advalorem==""){$advalorem=0;}	
                  }

                  $percjuros=$fator + $iof + $advalorem;

                } 
            ?>
            <label for="input-1">Sacado: <b class="text-white"><?php echo  $nomesacado;?></b></label> <br>
            <label for="input-1">Juros: <b class="text-white"><?php echo  $percjuros;?>%</b></label> <br>
            <label for="input-1">Valor: <b class="text-white"><?php echo  $valor;?> R$</b></label> <br>
            <label for="input-1">Emissão: <b class="text-white"><?php echo  $dtemissao;?></b></label> <br><br>
            <label for="input-1">Vencimento: <b class="text-white"><?php echo  $dtvencimento;?></b></label> 
            <hr>
            <div class="form-group">
            <label for="input-2">Novo Vencimento</label>
            <input type="date" required name="novo_vencimento" class="form-control" id="input-2" placeholder="">
           </div>
            <hr>
            <input hidden class="form-control" name="nroduplicata" value="<?php echo $nroduplicata;?>" placeholder="nroduplicata">
            <input hidden class="form-control" name="nrocheque" value="<?php echo $nrocheque;?>" placeholder="nrocheque">
            <input hidden class="form-control" name="idmvmfinprop" value="<?php echo $idmvmfinprop;?>" placeholder="nrocarne">
            <input hidden class="form-control" name="parcela" value="<?php echo $parcela;?>" placeholder="nrocarne">
            <input hidden class="form-control" name="seq" value="<?php echo $seq;?>" placeholder="seq">
            <label for="input-1">Histórico De Lançamento</label>
            <input required onfocus="clearInput(this)" style="border: 1px solid #fff" value="1 RECEBIMENTO - RECEITA GERAL" placeholder="Histórico De Lançamento" 
						class="form-control" name="idhistorico" list="historico_receita">
						<datalist id="historico_receita">
						<?php 
            $localsql=new localsql();
						$busca = $localsql->busca_historicos_receita_all($pdom);
            foreach($busca as $line){
						$idhistorico=$line['idhistorico'];	
						$historico=$line['historico'];		
						?>
	          <option required value="<?php echo $idhistorico.' - '.$historico;?>"></option>
						<?php 
            }
            ?>	
            </datalist>
            <script>function clearInput(target){
            if (target.name== 'idhistorico'){ target.value= "";}}
            </script>
           </div>

           <div class="form-group">
            <label for="input-2">Valor Juros Recebido R$</label>
            <input required  type="number" value="" max="9999999" step="any" name="valor" class="form-control" id="input-2" placeholder="0.00">
            </div>
 
           <div class="form-group float-right">
           <button type="submit" class="btn btn-success btn_action_detalhes"> 
                  <i style="font-size:12px" class="icon-cloud-upload"></i> Concluir </button>
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

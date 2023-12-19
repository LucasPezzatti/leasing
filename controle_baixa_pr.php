<?php session_start();
error_reporting(0);
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/conn_MYSQL.php";
require "core/mysql.php";
require "header.php";
$pg_action="CTRBAX";
$localsql=new localsql(); 

if(isset($_GET['action']) &&  $_GET['action']=="pr"){
//echo "<center>DEBUG ON<br>";  
$tpdoc=$_GET['doc'];

//GLOBAL VARIABLES 
$seq=$_POST['seq'];
$idmvmop1=$_POST['idmvmop1'];
$valor=$_POST['valor'];
$acrescimo=$_POST['acrescimo'];
$desconto=$_POST['desconto'];
$dt_status=date('ymd');
$emissao=date('ymd');

//UPDATE CHEQUE ------------------------------------------------------------------------------------------------------
  if($tpdoc=='cheque'){
  //ATUALIZA CHEQUE PARA STATUS PAGO
  $nrocheque=$_POST['nrocheque'];
  $localsql->upd_cheque_baixa($seq,$dt_status,$pdom);
  
//INCLUI LOG DE MOVIMENTO
//echo "<br><br>".
$acao="Baixa De Cheque. Nº: ".$nrocheque. " - VALOR: ".$valor." R$";
//echo "<br>".
$date=date('ymdHi');
$idlogin=$_SESSION['idlogin'];
$localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom); // ####################################################################

//ADD MVM FINANCEIRO REF A BAIXA 
$descricao="Baixa De Cheque. Nº: ".$nrocheque;
$historico="2"; // HISTORICO PADRÃO PARA BAIXA DE CHEQUE (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
$tipo_mvm="E";
$status="2";
$localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
//ADD MVM FINANCEIRO REF A ACRESCIMO - IF ACRESCIMO > 0
if($acrescimo > 0){ 
$descricao="Acréscimo Na Baixa De Cheque. Nº: ".$nrocheque;
$historico="4"; // HISTORICO PADRÃO PARA ACRESCIMO BAIXA DE CHEQUE (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
$tipo_mvm="E";
$status="2";
$valor=$acrescimo;
$localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
}
//ADD MVM FINANCEIRO REF A DESCONTO - IF DESCONTO > 0
if($desconto > 0){ 
$descricao="Desconto Na Baixa De Cheque. Nº: ".$nrocheque;
$historico="600"; // HISTORICO PADRÃO PARA DESCONTO NA BAIXA DE CHEQUE (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
$tipo_mvm="S";
$status="2";
$valor=$desconto;
$localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom); 
}
}
elseif($tpdoc=='duplicata'){  //UPDATE DUPLICATA --------------------------------------------------------------------------------------------------------------------
    //ATUALIZA DUPLICATA PARA STATUS PAGO
    $nroduplicata=$_POST['nroduplicata'];
    $localsql->upd_duplicata_baixa($seq,$dt_status,$pdom);

//INCLUI LOG DE MOVIMENTO
$acao="Baixa De Duplicata. Nº: ".$nroduplicata. " - VALOR: ".$valor." R$";
$date=date('ymdHi');
$idlogin=$_SESSION['idlogin'];
$localsql->insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdom); // ####################################################################

//ADD MVM FINANCEIRO REF A BAIXA 
$descricao="Baixa De Duplicata. Nº: ".$nroduplicata;
$historico="3"; // HISTORICO PADRÃO PARA BAIXA DE DUPLICATA (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
$tipo_mvm="E";
$status="2";
$localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
//ADD MVM FINANCEIRO REF A ACRESCIMO - IF ACRESCIMO > 0
if($acrescimo > 0){ 
  $descricao="Acréscimo Na Baixa De Duplicata. Nº: ".$nroduplicata;
  $historico="5"; // HISTORICO PADRÃO PARA ACRESCIMO BAIXA DE DUPLICATA (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
  $tipo_mvm="E";
  $status="2";
  $valor=$acrescimo;
  $localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
  }
//ADD MVM FINANCEIRO REF A DESCONTO - IF DESCONTO > 0
if($desconto > 0){ 
  $descricao="Desconto Na Baixa De Duplicata. Nº: ".$nroduplicata;
  $historico="601"; // HISTORICO PADRÃO PARA DESCONTO NA BAIXA DE DUPLICATA (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
  $tipo_mvm="S";
  $status="2";
  $valor=$desconto;
  $localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom); 
  }  
}
elseif($tpdoc=='carne'){
  //ATUALIZA CARNE PARA STATUS PAGO
  $idmvmfinprop=$_POST['idmvmfinprop'];
  $localsql->upd_carne_baixa($seq,$dt_status,$pdom);
 
  $busca = $localsql->busca_tblmvmfinprop2_seq($idmvmfinprop,$seq,$pdom); //CARREGA PARCELA
              foreach($busca as $line){ 
              $numparcela=$line['parcela'];			
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
//ADD MVM FINANCEIRO REF A ACRESCIMO - IF ACRESCIMO > 0
if($acrescimo > 0){ 
  $descricao="Acréscimo Na Baixa Da Parcela ".$numparcela." Do Carnê. Nº: ".$idmvmfinprop;
  $historico="7"; // HISTORICO PADRÃO PARA ACRESCIMO NA BAIXA DE PARCELA DO CARNE  (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
  $tipo_mvm="E";
  $status="2";
  $valor=$acrescimo;
  $localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom);
  }
//ADD MVM FINANCEIRO REF A DESCONTO - IF DESCONTO > 0
if($desconto > 0){ 
  $descricao="Desconto Na Baixa Da Parcela ".$numparcela." Do Carnê. Nº: ".$idmvmfinprop;
  $historico="602"; // HISTORICO PADRÃO PARA DESCONTO NA  BAIXA DE PARCELA DO CARNE  (TODO ? CRIAR CONF INT PARA SER SELECIONAVEL)
  $tipo_mvm="S";
  $status="2";
  $valor=$desconto;
  $localsql->add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdom); 
  }  

}

$total_pendente=0;
$busca = $localsql->count_pendencias($idmvmop1,$pdom);
        foreach($busca as $line){
        $pendentes=$line['pendentes'];	
        $total_pendente=$pendentes + $total_pendente;
      }

if($total_pendente==0){
//ALTERA STATUS DA OPERAÇÃO PARA RECEBIDA
$idope=$idmvmop1;
$status=7;
  $localsql-> update_status_idope($status,$idope,$pdom);
}

//die;

echo '<script>window.location.href = "controle_baixa.php?origin=baixa" </script>';
}

$tpdoc=$_GET['doc'];
if($tpdoc=='cheque'){
$cardtitle="Baixar Cheque";
$buttonsubmit="Baixar Cheque";
$nrocheque=$_POST['nrodoc'];
$nroduplicata=null;
$idmvmfinprop==null;
}
elseif($tpdoc=='duplicata'){
$cardtitle="Baixar Duplicata";
$buttonsubmit="Baixar Duplicata";
$nrocheque=null;
$idmvmfinprop==null;
$nroduplicata=$_POST['nrodoc'];
}
elseif($tpdoc=='carne'){
  $cardtitle="Baixar Parcela";
  $buttonsubmit="Baixar Parcela";
  $nrocheque=null;
  $nroduplicata=null;
  $idmvmfinprop=$_POST['nrodoc'];
  }
$seq=$_POST['seq'];
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
           <form autocomplete="off" id="" method="POST" action="?action=pr&doc=<?php echo $_GET['doc'];?>">
           <div class="form-group">
            <?php 
             $buscatitulos = $localsql->lista_titulos_tela_baixa_seq_full($seq,$nrocheque,$nroduplicata,$idmvmfinprop,$pdom); 
             foreach($buscatitulos as $line){
              $seq=$line['seq'];	
              $idmvmop1=$line['idmvmop1'];	
              $nrocheque=$line['nrocheque'];	
              $nroduplicata=$line['nroduplicata'];	
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
              
              $busca = $localsql->busca_tblmvmfinprop2_seq($idmvmfinprop,$seq,$pdom); //CARREGA PARCELA
              foreach($busca as $line){ 
              $numparcela=$line['parcela'];			
              }
              
              $busca = $localsql->busca_tblmvmfinprop1_seq($idmvmfinprop,$seq,$pdom); //CARREGA O NOME DO CEDENTE
              foreach($busca as $line){ 
                $fator=$line['fator'];
                if($fator==""){$fator=0;}	
                $iof=$line['iof'];	
                if($iof==""){$iof=0;}	
                $advalorem=$line['advalorem'];	
                if($advalorem==""){$advalorem=0;}	
                $percjuros=$fator + $iof + $advalorem;
              }
             
              
               $simes=substr($dtemissao, 2, 2); $sidia=substr($dtemissao, 4, 2); $siano=substr($dtemissao, 0, 2);
               $dtemissao=$sidia."/".$simes."/20".$siano; 

               $simes=substr($dtvencimento, 2, 2); $sidia=substr($dtvencimento, 4, 2); $siano=substr($dtvencimento, 0, 2);
               $dtvencimento=$sidia."/".$simes."/20".$siano; 

              if($tpdoc=='cheque'){
                echo '<label for="input-1">Cheque Numero: '.$nrocheque.'</label>';
                }
                elseif($tpdoc=='duplicata'){
                  echo '<label for="input-1">Duplicata Numero: <b class="text-white">'.$nroduplicata.'</b></label>';
                } 
                elseif($tpdoc=='carne'){
                  echo '<label for="input-1">Carnê Numero: <b class="text-white">'.$idmvmfinprop.'</b></label>';
                  echo '<br><label for="input-1">Parcela: <b class="text-white">'.$numparcela.'</b></label>';
                  
                } 
            ?>
            <br>
            <label for="input-1">Sacado: <b class="text-white"><?php echo  $nomesacado;?></b></label> <br>
            <label for="input-1">Juros: <b class="text-white"><?php echo  $percjuros;?>%</b></label> <br>
            <label for="input-1">Emissão: <b class="text-white"><?php echo  $dtemissao;?></b></label> <br>
            <label for="input-1">Vencimento: <b class="text-white"><?php echo  $dtvencimento;?></b></label> 
            <hr>
            <input hidden class="form-control" name="nroduplicata" value="<?php echo $nroduplicata;?>" placeholder="nroduplicata">
            <input hidden class="form-control" name="nrocheque" value="<?php echo $nrocheque;?>" placeholder="nrocheque">
            <input hidden class="form-control" name="idmvmfinprop" value="<?php echo $idmvmfinprop;?>" placeholder="idmvmfinprop">
            <input hidden class="form-control" name="idmvmop1" value="<?php echo $idmvmop1;?>" placeholder="idmvmop1">
            <input hidden class="form-control" name="seq" value="<?php echo $seq;?>" placeholder="seq">
            <label for="input-1">Histórico De Lançamento</label>
            <input required onfocus="clearInput_apagar(this)" readonly style="border: 1px solid #fff" placeholder="Histórico De Lançamento"  
            <?php if($tpdoc=='cheque'){ echo 'value="2- RECEBIMENTO DE CHEQUE"';}elseif($tpdoc=='duplicata'){ echo 'value="3- RECEBIMENTO DE DUPLICATA"';}elseif($tpdoc=='carne'){ echo 'value="6- RECEBIMENTO DE PARCELA"';}?> 
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
            <label for="input-2">Valor R$</label>
            <input required readonly  type="text" <?php echo 'value="'.$valor.'"';?> max="9999999" step="any" name="valor" class="form-control" id="input-2" placeholder="0.00">
            </div>

           <div class="form-group">
            <label for="input-2">Acréscimo R$</label>
            <input  type="number" max="9999999" step="any" name="acrescimo" class="form-control" id="input-2" placeholder="0.00">
           </div>

           <div class="form-group">
            <label for="input-2">Desconto R$</label>
            <input  type="number" max="9999999" step="any" name="desconto" class="form-control" id="input-2" placeholder="0.00">
           </div>
 
           <div class="form-group float-right">
           <button type="submit" class="btn btn-success btn_action_detalhes"> 
                  <i style="font-size:12px" class="icon icon-wallet"></i> Baixar </button>
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

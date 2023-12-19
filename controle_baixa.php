<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/mysql.php";
require "global_date.php";
require "header.php";
$pg_action="CTRBAX";
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

<script>
  document.addEventListener("DOMContentLoaded", function (event) {
    var scrollpos = localStorage.getItem("scrollpos");
    if (scrollpos) window.scrollTo(0, scrollpos);
  });

  window.onscroll = function (e) {
    localStorage.setItem("scrollpos", window.scrollY);
  };
</script>

<body class="bg-theme bg-theme1 ">
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
        <div class="row row-group m-0">
          <?php 
           $localsql=new localsql();
           $busca = $localsql->sum_titulos_recebidos_periodo($pdom);
           foreach($busca as $line){
            $totalbaixa=$line['totalbaixa'];
           }
           $totalbaixa=number_format($totalbaixa, 2, ',', '.');	
          ?>
          <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                  <h5 class="text-white mb-0"><?php echo $totalbaixa;?> <span class="float-right">R<i class="fa fa-usd"></i></span></h5>
                    <div class="progress my-3" style="height:3px;color:red">
                       <div class="progress-bar" style="width:100%;"></div>
                      </div>
          
                      <p class="mb-0 text-white small-font">  <span class="float-left"><?php echo $showperiodo;?>
				  <i class="zmdi zmdi-calendar"></i> </span></p> <br>Soma Dos Títulos Recebidos No Período 
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body"> <!--
                  <h5 class="text-white mb-0">0.00 <span class="float-right">R<i class="fa fa-usd"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:100%;"></div>
                    </div>
                  <p class="mb-0 text-white small-font"><span class="float-left"><?php echo $showperiodo;?>
				  <i class="zmdi zmdi-calendar"></i> </span></p><br> Contas á Receber - Pendentes   -->
                </div>
            </div>
            <?php 
            $localsql=new localsql();
						$busca = $localsql->dash_despesas($dtini,$dtfin,$pdom);
            foreach($busca as $line){
             $totaldesp=$line['totaldesp'];
            }
            $totaldesp=number_format($totaldesp, 2, ',', '.');	
            $totaldesp="0.00";
            ?>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body"> <!--
                  <h5 class="text-white mb-0"><?php echo $totaldesp;?> <span class="float-right">R<i class="fa fa-usd"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:100%;"></div>
                    </div>
                  <p class="mb-0 text-white small-font"><span class="float-left"><?php echo $showperiodo;?>
                    <i class="zmdi zmdi-calendar"></i></span></p><br> Contas á Pagar - Vencidas   -->
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
            $localsql=new localsql();
						$busca = $localsql->dash_soma_receitas($dtini,$dtfin,$pdom);
            foreach($busca as $line){
             $totalrece=$line['totalrece'];
            }
            $lucroprevisto= $totalope + $totalrece - $totalpg;
            $lucroprevisto=number_format($lucroprevisto, 2, ',', '.');	
            $lucroprevisto="0.00";
            ?>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body"> <!--
                  <h5 class="text-white mb-0"><?php echo $lucroprevisto;?> <span class="float-right">R<i class="fa fa-usd"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:100%;"></div>
                    </div>
                  <p class="mb-0 text-white small-font"> <span class="float-left"><?php echo $showperiodo;?>
                     <i class="zmdi zmdi-calendar"></i></span><br> Contas á Pagar - Pendentes  -->
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
               <canvas id="chart2"></canvas>
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
<?php 
//FILTER PR
$title="Títulos";
$title_filter1="";
$title_filter2="";
$title_filter3="";

//DEFAULT FILTER TIPO DE DOCUMENTO
if(!isset($_SESSION['filter1'])){ $filter1=" where 1=1 ";$_SESSION['filter1']=" where 1=1 ";$_SESSION['title_filter1']="";}
else{ $filter1=$_SESSION['filter1'];$title_filter1=$_SESSION['title_filter1'];} 

//DEFAULT FILTER SACADO
if(!isset($_SESSION['filter2'])){ $filter2="";$_SESSION['filter2']="";$_SESSION['title_filter2']="";}
else{ $filter2=$_SESSION['filter2'];$title_filter2=$_SESSION['title_filter2']; } 

//DEFAULT FILTER VENCIMENTO
if(!isset($_SESSION['filter3'])){ $filter3="";$_SESSION['filter3']="";$_SESSION['title_filter3']="";}
else{ $filter3=$_SESSION['filter3'];$title_filter3=$_SESSION['title_filter3']; } 

//echo $filter1."<br>";
//echo $filter2."<br>";
//echo $filter3."<br>";
//echo "<br>";

$localsql=new localsql();
if(!isset($_GET['filter']) && !isset($_SESSION['filter_start'])){
  $title="Exibindo Últimos 20 Títulos - Utilize os filtros para encontrar o título desejado";
  $buscatitulos = $localsql->lista_titulos_tela_baixa($pdom); //BUSCA OS ULTIMOS 10 LANÇAMENTOS SEM FILTRO DE DATA -- DEFAULT
}
else{
  $_SESSION['filter_start']="";
//FILTRO
  if(isset($_GET['filter']) && $_GET['filter']=="tp_doc" && isset($_GET['value'])){
    if($_GET['value']=='c'){
      $title_filter1=" | Filtrando apenas por Cheques";
      $_SESSION['title_filter1']=$title_filter1;

      $filter1=" where 1 HAVING nrocheque > 0 "; 
      $_SESSION['filter1']=$filter1; 
    }
    if($_GET['value']=='d'){
      $title_filter1=" | Filtrando apenas por Duplicatas";
      $_SESSION['title_filter1']=$title_filter1;

      $filter1=" where 1 HAVING nroduplicata > 0 "; 
      $_SESSION['filter1']=$filter1;
    }
    if($_GET['value']=='f'){
      $title_filter1=" | Filtrando apenas por Carnês";
      $_SESSION['title_filter1']=$title_filter1;

      $filter1=" where 1 HAVING idmvmfinprop > 0 "; 
      $_SESSION['filter1']=$filter1;
    }
    if($_GET['value']=='a'){
      $filter1=" where 1=1"; 
      $_SESSION['filter1']=$filter1;
      $_SESSION['title_filter1']=" | Exibindo Duplicatas e Cheques";
      $title_filter1=" | Exibindo Duplicatas e Cheques";
    }
    }
    elseif(isset($_GET['filter']) && $_GET['filter']=="sacado" && isset($_GET['value'])){
      if($_GET['value']=='a'){
        $filter2=" ";
        $_SESSION['filter2']=$filter2;
        $_SESSION['title_filter2']=" | Exibindo Títulos De Todos Sacados"; 
        $title_filter2=" | Exibindo Títulos De Todos Sacados";
      } 
      else{
      $idsacadopr=$_POST['filter2'];
      $title_filter2=" | Filtrando Pelo Sacado ".$idsacadopr;
      $_SESSION['title_filter2']=$title_filter2;
 
      $idsacadopr = explode("-", $idsacadopr);
      $idsacadopr=$idsacadopr[0]; 
 
      $filter2= " and idsacado='".$idsacadopr."' ";
      $_SESSION['filter2']=$filter2;
      }   
    
    }
    elseif(isset($_GET['filter']) && $_GET['filter']=="vencimento" && isset($_GET['value'])){

      if($_GET['value']=="a"){
        //RESET FILTER VENCIMENTO
        $_SESSION['filter3']="";
        $filter3=$_SESSION['filter3'];
        $_SESSION['title_filter3']="";
        $_SESSION['filter_dtini']="";
        $_SESSION['filter_dtfin']="";
      }
      else{
        //SESSION FOR REMEMBER MODAL INPUT 
        $_SESSION['filter_dtini']=$_POST['filter_dtini'];
        $_SESSION['filter_dtfin']=$_POST['filter_dtfin'];
        
        //DATE FILTER POST
        $filter_dtini=$_POST['filter_dtini'];
        $filter_dtfin=$_POST['filter_dtfin'];
     
      //DT INI CREATION FOR SQL AND TITLE FILTER
      $anoini=substr($filter_dtini, 2, 2);
      $mesini=substr($filter_dtini, 5, 2);
      $diaini=substr($filter_dtini, 8, 2);
      $filter_dtini=$anoini.$mesini.$diaini;
      $filter_dtinishow=$diaini.'/'.$mesini.'/'.$anoini;
      
      //DT FIN CREATION FOR SQL AND TITLE FILTER
      $anofim=substr($filter_dtfin, 2, 2);
      $mesfim=substr($filter_dtfin, 5, 2);
      $diafim=substr($filter_dtfin, 8, 2);
      $filter_dtfin=$anofim.$mesfim.$diafim;
      $filter_dtfinshow=$diafim.'/'.$mesfim.'/'.$anofim;
      
      //CREATE FILTER 3
      $_SESSION['filter3']=" and dt_vencimento >= '".$filter_dtini."' and dt_vencimento <= '".$filter_dtfin."' "; 
      $filter3=$_SESSION['filter3'];
     
      //CREATE TITLE FILTER 3
      $_SESSION['title_filter3']=" | Vencimento: De ".$filter_dtinishow." Até ".$filter_dtfinshow." ";
      $title_filter3=$_SESSION['title_filter3'];
      }
    }
    else{
      $filter1=$_SESSION['filter1'];
      $filter2=$_SESSION['filter2'];
      $filter3=$_SESSION['filter3'];
    }
    
     
    //SQL COM FILTROS ATIVOS
      $filter3=$_SESSION['filter3'];
    $buscatitulos = $localsql->lista_titulos_tela_baixa_filter($filter1,$filter2,$filter3,$pdom); //BUSCA LANÇAMENTOS POR FILTRO
}

//echo $filter1."<br>";
//echo $filter2."<br>";

$title=$title.$title_filter1.$title_filter2.$title_filter3;
?>
<form id="multibaixa" action="controle_baixa_multi.php" method="POST">
	<div class="row">
	 <div class="col-12 col-lg-12">
	   <div class="card">
	     <div class="card-header"><?php echo $title;?>
		  <div class="card-action">
             <div class="dropdown">
           

             <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
              <i class="icon-options"></i>
             </a>
              <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:void();">  Todas Operações</a>
             
                <!--   <div class="dropdown-divider"></div>
          
              <a class="dropdown-item" href="">
              <i class="fa fa-dollar text-receitas"></i> Contas á Receber</a>
               <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="">
              <i class="fa fa-dollar text-despesas"></i> Contas á Pagar</a>
              -->
               </div>
              </div>
             </div>
          </form>
		 </div> 
	       <div class="table-responsive">
                 <table class="table align-items-center table-flush table-striped table-bordered table-sm">
                  <thead>
                   <tr>
                     <th style="width:80px">Tipo   <a href="#" data-toggle="modal" data-target="#filterTipoDoc" class="cursor_pointer"><i class="zmdi zmdi-menu text-info"></i></a></th>
                     <th <?= $columnsize; ?>>Nº </th>
                     <th <?= $columnsize; ?>>Emissão</th>
                     <th <?= $columnsize; ?>>Sacado <a href="#" data-toggle="modal" data-target="#filterSacado" class="cursor_pointer"><i class="zmdi zmdi-menu text-info"></i></a></th>
                     <th <?= $columnsize; ?>>Valor R$</th>
                     <th hidden <?= $columnsize; ?>>% Juros</th>
                     <th <?= $columnsize; ?>>Vencimento <a href="#" data-toggle="modal" data-target="#filterVencimento" class="cursor_pointer"><i class="zmdi zmdi-menu text-info"></i></a></th>
                     <!--  <th style="width:80px">Status</th> -->
                     <th style="width:80px"></th>
                     <th style="width:80px"></th>
                   </tr>
                   </thead>
                   <tbody>
<?php 
 foreach($buscatitulos as $line){
 $seq=$line['seq'];	
 $idmvmop1=$line['idmvmop1'];	
 $nrocheque=$line['nrocheque'];	
 $nroduplicata=$line['nroduplicata'];	
 $idmvmfinprop=$line['idmvmfinprop'];	
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
 if(isset($valor) && $valor > 0){
  $valor = number_format($valor, 2, ',', '.');

  $busca = $localsql->busca_tblmvmfinprop2_seq($idmvmfinprop,$seq,$pdom); //CARREGA O NOME DO CEDENTE
  foreach($busca as $line){ 
  $numparcela=$line['parcela'];		
  }
}	

 require "global_status.php";

 $siano=substr($dtvencimento, 0, 2); $simes=substr($dtvencimento, 2, 2); $sidia=substr($dtvencimento, 4, 2);
 $dtvencimento=$sidia.'/'.$simes.'/'.$siano;

 $siano=substr($dtemissao, 0, 2); $simes=substr($dtemissao, 2, 2); $sidia=substr($dtemissao, 4, 2);
 $dtemissao=$sidia.'/'.$simes.'/'.$siano;

 $nomesacado="Não Informado";		
 $busca = $localsql->busca_pessoa_id($id,$pdom);
 foreach($busca as $line){
  $nomesacado=$line['razao'];	
  $idsacado=$line['id'];	
 }
 if($nomesacado=="Não Informado"){
  $idsacado=0;
 }
?>        
                    <tr>                    
                    <td>                   
<!-- MODAL OPERACAO -->                    
<div class="modal fade" id="modal_operation<?= $idmvmop1; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Operação #<?= $idmvmop1; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php 
        $idope=$idmvmop1;
        $localsql=new localsql();
        $busca = $localsql->busca_ope_idope($idope,$pdom);
        foreach($busca as $line){
        $idope=$line['idope'];	
        $idced=$line['idcedente'];	
       $id=$idced;
      $busca = $localsql->busca_pessoa_id($id,$pdom);
      foreach($busca as $line){
         $nomecedente=$line['razao'];	
        } 
        $id=0;
      }
      ?>
      <div class="modal-body"> 
                   <h4 class="text-dark">Cedente</h4>
                   <h4 class="btn btn-dark" style="font-size:16px"><?php echo  $idced.'-'.$nomecedente; ?></h4>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Fechar </button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- / MODAL OPERACAO -->      

                    <a href="#" data-toggle="modal" data-target="#modal_operation<?= $idmvmop1; ?>" class="cursor_pointer">
                    <?php if($nroduplicata==null && $idmvmfinprop==null){ echo '<button style="width:100px" class="btn btn-warning btn_action_detalhes"><i style="font-size:12px" class="icon icon-file"></i> Cheque </button>';} 
                    elseif($nrocheque==null && $idmvmfinprop==null){echo '<button  style="width:100px" class="btn btn-primary btn_action_detalhes"><i style="font-size:12px" class="icon icon-file"></i> Duplicata </button>';} 
                    elseif($nrocheque==null && $nroduplicata==null){echo '<button  style="width:100px" class="btn btn-danger btn_action_detalhes"><i style="font-size:12px" class="icon icon-file"></i> Carnê </button>';} ?>
                    </a>  
                    </td>
                    <td><button class="btn btn-light">
                    <?php if($nroduplicata==null && $idmvmfinprop==null){echo $nrocheque;}elseif($nrocheque==null && $idmvmfinprop==null){echo $nroduplicata;}elseif($nrocheque==null && $nroduplicata==null){ echo $idmvmfinprop."(".$numparcela.")"; };?></td>
                    <td><?php echo $dtemissao;?></td>
                    <td><?php echo $idsacado.'-'.$nomesacado;?></td>
                    <td><?php echo $valor;?></td>
                    <td hidden><?php echo $percjuros;?>%</td>
                    <td><?php echo $dtvencimento;?> 
                    <?php if($status_fin==1){?> <a href="pro_vencimento.php?nc=<?= $nrocheque; ?>&nd=<?= $nroduplicata; ?>&np=<?= $idmvmfinprop; ?>&seq=<?= $seq; ?>&key=<?= md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"> 
                    <button type="button" class="btn btn-success"> <i style="font-size:12px" class="zmdi zmdi-calendar"></i></button> 
                    <?php } ?></td>
                
                  <?php if($status_fin==1){
                   if($nroduplicata==null && $idmvmfinprop==null){
                   $tipodoc="cheque"; 
                   }
                   elseif($nrocheque==null && $idmvmfinprop==null){
                    $tipodoc="duplicata"; 
                   }
                   else{
                    $tipodoc="carne"; 
                   }
                   ?>
                   <td>
                    <input type="checkbox" name="<?php echo $seq.'-'.$tipodoc;?>" style="accent-color: #ffd700;" class="form-control"></input></td>
                   <td class="cursor_pointer">
                  <form id="<?php echo $nrocheque.$nroduplicata.$idmvmfinprop.$seq;?>" action="controle_baixa_pr.php?action=baixar&doc=<?= $tipodoc ?>" method="POST">
                  <input hidden form="<?php echo $nrocheque.$nroduplicata.$idmvmfinprop.$seq;?>" type="number" name="seq" value="<?php echo $seq;?>">
                  <input hidden form="<?php echo $nrocheque.$nroduplicata.$idmvmfinprop.$seq;?>" type="number" name="nrodoc" value="<?php if($tipodoc=="cheque"){echo $nrocheque;}elseif($tipodoc=="duplicata"){echo $nroduplicata;}elseif($tipodoc=="carne"){echo $idmvmfinprop;} ?>">
                   <button style="width:120px" form="<?php echo $nrocheque.$nroduplicata.$idmvmfinprop.$seq;?>" type="submit" class="btn btn-success btn_action_detalhes"> 
                  <i style="font-size:12px" class="icon icon-wallet"></i> Baixar </button></form>
                  <?php 
                   }
                   else{
                   ?>
                   <td class="text-center"><button style="width:40px" type="button" class="btn btn-info b_shadown_dark "><i style="font-size:15px;padding-right:5px!important" class="zmdi zmdi-check"></i></button></td>
                   <td class="cursor_pointer">
                   <button  style="width:120px" type="button" class="btn btn-info btn_action_detalhes"><i style="font-size:12px" class="ti-check"></i> Pago</button>
                   <?php 
                   }
                   ?>
                  </td>
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
     <div style="float:right">
               <button style="width:300px;background-color: #ffd700!important;color:black" form="multibaixa" type="submit" class="btn btn-dark btn_action_detalhes"> 
                  <i style="font-size:12px" class="zmdi zmdi-check-all"></i> Baixar Títulos Selecionados </button></div>           
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
  require "modal_filters.php";
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
<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/mysql.php";
require "header.php";
$localsql=new localsql();
$idcfg="4";
$busca = $localsql->busca_cfgint_id($idcfg,$pdom);
foreach($busca as $line){$exibe_iof=$line['value'];}

$idcfg="6";
$busca = $localsql->busca_cfgint_id($idcfg,$pdom);
foreach($busca as $line){$exibe_advalorem=$line['value'];}

//CARREGA DETALHES DA OPERACAO
$idope=$_GET['id'];
$_SESSION['idope_or']=$_GET['id'];

$localsql=new localsql();
$busca = $localsql->busca_ope_idope($idope,$pdom);
foreach($busca as $line){
$idope=$line['idope'];	
$idcedente=$line['idcedente'];	
$vlr_operacao=$line['vlr_operacao'];	
$vlr_pago=$line['vlr_pago'];	
$tipo_juros=$line['tipo_juros'];	
$tipo_calculo=$line['tipo_calculo'];	
$status=$line['status'];	
}
if(!isset($line['idope']) && $line['idope']==""){
  echo "<script>window.location.href='index.php';</script>";
}

$busca = $localsql->busca_cendente_id($idcedente,$pdom); //CARREGA O NOME DO CEDENTE
foreach($busca as $line){ 
$nomecedente=$line['razao'];		
}

?>
<body class="bg-theme bg-theme1">
<div id="wrapper">
<?php 
require "sidebar.php";
require "topbar.php";
?>

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row mt-2">
  
        <div class="col-lg-12">
           <div class="card">
            <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                <li class="nav-item">
                    <a href="#" data-target="#profile" data-toggle="pill" class="nav-link <?php if(isset($_GET['origin']) && $_GET['origin']!='NEWCHEQUE' && $_GET['origin']!='EDTCHE'  && $_GET['origin']!='EDTDUP' && $_GET['origin']!='NEWDUP' && $_GET['origin']!='NEWFINPRO' || !isset($_GET['origin'])){echo "active";}?>">
                      <i class="icon-wallet"></i> <span class="hidden-xs">Operação #<?php echo $idope;?></span></a>
                </li>
                <?php
                if($tipo_calculo=="VP"){
                ?>
                <li class="nav-item">
                    <a href="" data-target="#edit" data-toggle="pill" class="nav-link <?php if(isset($_GET['origin']) && $_GET['origin']=='NEWCHEQUE' || isset($_GET['origin']) && $_GET['origin']=='EDTCHE'){echo "active";}?>"><i class="icon-layers"></i>
                     <span class="hidden-xs">Cheques</span></a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#messages" data-toggle="pill" class="nav-link <?php if(isset($_GET['origin']) && $_GET['origin']=='NEWDUP' || isset($_GET['origin']) && $_GET['origin']=='EDTDUP'){echo "active";}?>"><i class="icon-layers"></i> 
                    <span class="hidden-xs">Duplicatas</span></a>
                </li>
                <?php 
                }
                elseif($tipo_calculo=="VF"){
                ?>
                <li class="nav-item">
                    <a href="" data-target="#financ" data-toggle="pill" class="nav-link <?php if(isset($_GET['origin']) && $_GET['origin']=='NEWFINPRO' || isset($_GET['origin']) && $_GET['origin']=='NEWFINPRO'){echo "active";}?>"><i class="icon-layers"></i> 
                    <span class="hidden-xs">Empréstimos</span></a>
                </li>
                <?php 
                }
                ?>
            </ul>
            <div class="tab-content p-3">
                <div class="tab-pane  <?php if(isset($_GET['origin']) && $_GET['origin']!='NEWCHEQUE' && $_GET['origin']!='EDTCHE' && $_GET['origin']!='EDTDUP' && $_GET['origin']!='NEWDUP' && $_GET['origin']!='NEWFINPRO' || !isset($_GET['origin'])){echo "active";}?>" id="profile">
                    <h5 class="mb-3">Detalhes Da Operação</h5>
                    <?php require "global_status.php";?>
                    Status <div data-toggle="modal" data-target="#statusModal" class="cursor_help" id="status_<?php echo $statusclass;?>"></div>
                    <div class="row">
                        <div class="col-md-6">

               <div class="table-responsive">
               <table class="table table-borderless">
                  <thead>
                    <tr  >
                      <th scope="col" style="width:100px">Cedente</th>
                      <th scope="col"><?php echo $idcedente.'-'.$nomecedente;?></th>
                    </tr>
                    <tr>
                      <th scope="col" style="width:100px">Valor Da Operação</th>
                      <th scope="col"><?php echo number_format($vlr_operacao, 2, ',', '.').' R$';?></th>
                    </tr>
                    <tr>
                      <th scope="col" style="width:100px">Valor Á Pagar</th>
                      <th scope="col"><?php echo number_format($vlr_pago, 2, ',', '.').' R$';?></th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table>
            </div>
<br>            
<p>
<?php
if($status==1){
?>  

<a href="#" data-toggle="modal" data-target="#ModalRemoveOpe" >
<button class="btn btn-danger btn_action_detalhes"> 
         <i style="font-size:12px" class="icon icon-wallet"></i> 
          Excluir Operação </button>  
</a>
<a href="upd_status_ope.php?action=<?php echo base64_encode('confirma_pagamento').'&target='.base64_encode($idope);?>&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>">  
<button class="btn btn-success btn_action_detalhes"> 
         <i style="font-size:12px" class="icon icon-wallet"></i> 
          Confirmar Pagamento </button>
        </a>      
        <br>
        <br>
<?php
}
?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Operações Recentes</h6>
                            <?php 
                            $localsql=new localsql();
                            $busca = $localsql->last_ope_idcedente($idcedente,$pdom); 
                            foreach($busca as $line){
                            $idope=$line['idope'];
                            ?>
                            <a href="operacao_detalhes.php?id=<?php echo $idope;?>" class="badge badge-dark badge-pill">#<?php echo $idope;?></a>
                            <?php 
                            }
                            ?>
                            <hr>
                           <!-- <span class="badge badge-danger"><i class="fa fa-exclamation"></i>Alert</span> -->
                        </div>
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-3"><span class="fa fa-clock-o ion-clock float-right"></span> Movimentações</h5>
                             <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm">
                                <tbody>  
                                 <?php 
                                 $idope=$_GET['id'];
                                 $localsql=new localsql();
                                 $busca = $localsql->lista_log_idope($idope,$pdom); 
                                 foreach($busca as $line){
                                 $datamvm=$line['date'];
                                 $acao=$line['acao'];

                                 $idlogin=$line['idlogin'];
                                 
                                 $busca = $localsql->busca_nome_login_log($idlogin,$pdom); //CARREGA O NOME DO CEDENTE
                                 $nomeusulog=$busca['nome'];		
                               
                                 $siano=substr($datamvm, 0, 2); $simes=substr($datamvm, 2, 2); $sidia=substr($datamvm, 4, 2);
                                 $datamvm=$sidia.'/'.$simes.'/'.$siano;

                                 ?>                                   
                                    <tr>
                                        <td>
                                            <strong><?php echo $datamvm;?></strong> <?php echo $acao;?> <strong class="float-right"><?php echo $idlogin.'-'.$nomeusulog;?></strong>
                                        </td>
                                    </tr>
                                <?php 
                                 }
                                ?>
                                </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
                    <!--/row-->
                </div>
<?php if($tipo_calculo=="VF"){ ?>
         <!-- FINANC--> 
         <div class="tab-pane <?php if(isset($_GET['origin']) && $_GET['origin']=='NEWFINPRO' || isset($_GET['origin']) && $_GET['origin']=='NEWFINPRO'){echo "active";}?>" id="financ">
                    <div class="alert alert-info alert-dismissible" role="alert">
			         </div>
               <a href="proposta.php?action=start&origin=details&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>&id=<?php echo $_GET['id'];?>">
               <span class="float-right"><button class="btn btn-info"><i class="fa fa-plus"></i> Nova Proposta</button></span></a><br><br>
               
               <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>                                    
                            <tr>
                              <?php 
                               $localsql=new localsql();
                               $busca = $localsql->busca_tblmvmfinprop1_idope($idope,$pdom); //CONTA O NUMERO DE DUPLICATAS VINCULADAS AO ID DA OPERACAO
                               foreach($busca as $line){
                               $idmvmfinprop =$line['idmvmfinprop'];			
                               $idsacado=$line['idsacado'];
                               $fator=$line['fator'];
                               $iof=$line['iof'];
							   if($iof==""){
								   $iof=0;
							   }
                               $advalorem=$line['advalorem'];
							   if($advalorem==""){
								   $advalorem=0;
							   }
                               $numero_parcelas=$line['numero_parcelas'];
                               $valor_parcela=$line['valor_parcela'];
                               
							   
                               $tot_juros=$fator + $iof + $advalorem;

                               $total=$line['total'];
                        
                               $status_fin=$line['status'];

                               $emissao=$line['emissao'];	
                               $siano=substr($emissao, 0, 2); $simes=substr($emissao, 2, 2); $sidia=substr($emissao, 4, 2);
                               $emissao=$sidia.'/'.$simes.'/'.$siano;
                               
                               $primeira_parcela=$line['primeira_parcela'];
                               $siano=substr($primeira_parcela, 0, 2); $simes=substr($primeira_parcela, 2, 2); $sidia=substr($primeira_parcela, 4, 2);
                               $primeira_parcela=$sidia.'/'.$simes.'/'.$siano; 

                               $valor=$line['valor'];	
                               $valorpuro=$line['valor'];	
                               $valor = number_format($valor, 2, ',', '.')." R$";	
                               
                               $total = number_format($total, 2, ',', '.')." R$";	

                               $busca = $localsql->busca_sacado_id($idsacado,$pdom); //CARREGA O NOME DO CEDENTE
                               foreach($busca as $line){ 
                               $nomesacado=$line['razao'];		
                               }
                          
                               require "global_status.php";
                               

                               ?>
                             
                        
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-2">
                  <div class="col-4 col-lg-4 col-xl-4 border-light">
                <div class="card-body"> <button class="btn btn-primary btn_action_detalhes"><i style="font-size:12px" class="icon icon-wallet"></i> Financiamento #<?= $idmvmfinprop;?> </button> 
                <button class="btn btn-primary btn_action_detalhes"><i style="font-size:12px" class="zmdi zmdi-calendar"></i> Emissão <?= $emissao;?> </button> 
                  <br><br><h6 class="text-white shadow_dark mb-0"><b>Sacado: </b> <span class="float-center" style="padding-left:5px;color:#b491ed"><?= $nomesacado;?></span></h6>
                  <h6 class="text-white shadow_dark mb-0"><b>Valor:  </b><span class="float-center" style="padding-left:5px;color:#b491ed"><?= $valor;?></span></h6>
                  <h6 class="text-white shadow_dark mb-0"><b>Juros:  </b><span class="float-center" style="padding-left:5px;color:#b491ed"><?= $tot_juros;?>%</span></h6>
                  <h6 class="text-white shadow_dark mb-0"><b>Parcelas:  </b><span class="float-center" style="padding-left:5px;color:#b491ed"><?= $numero_parcelas;?></span></h6>
                  <h6 class="text-white shadow_dark mb-0"><b>Valor Por Parcela: </b> <span class="float-center" style="padding-left:5px;color:#b491ed"><?= $valor_parcela;?> R$</span></h6>
                  <h6 class="text-white shadow_dark mb-0"><b>Primeira Parcela:  </b><span class="float-center" style="padding-left:5px;color:#b491ed"><?= $primeira_parcela;?></span></h6>
                  <br><h6 class="text-white shadow_dark mb-0"><b>Valor Total Da Proposta: </b> <span class="float-center" style="padding-left:5px;color:#b491ed"><?= $total;?></span></h6>
                </div>
            </div>
        </div>
    </div>
 </div>
                            </tr>
                                 <?php 
                                   $busca = $localsql->busca_tblmvmfinprop2($idmvmfinprop,$pdom); //BUSCA PARCELAS DO FINPRO
                                   foreach($busca as $line){
                                  
                                  $seq=$line['seq'];
                                  $idmvmfinprop=$line['idmvmfinprop'];
                                  $parcela=$line['parcela'];
                                  $valor=$line['valor'];
                                  $status_fin=$line['status'];

                                  $vencimento=$line['dt_vencimento'];	
                                  $siano=substr($vencimento, 0, 2); $simes=substr($vencimento, 2, 2); $sidia=substr($vencimento, 4, 2);
                                  $vencimento=$sidia.'/'.$simes.'/'.$siano;	
                                  $calcvencimento="20".$siano.'/'.$simes.'/'.$sidia;	

                                  require "global_status.php";
                                  ?>
                           <tr>
                           <td>
                           <span class="float-right font-weight-bold"><br>
                           <?php 
                           if($status_fin==1){
                           ?>
                            <form method="POST" id="<?php echo $seq.$idmvmfinprop;?>"  action="controle_baixa_pr.php?action=baixar&doc=carne">
                            <input hidden type="text" name="nrodoc" value="<?= $idmvmfinprop;?>">
                            <input hidden type="text" name="seq" value="<?= $seq ;?>">
                           <button form="<?php echo $seq.$idmvmfinprop;?>" class="btn btn-success btn_action_detalhes"> 
                           <i style="font-size:12px" class="icon icon-wallet"></i> Baixar </button></form>
                           <?php 
                            }
                            else{
                              echo '<button  style="width:120px" type="button" class="btn btn-primary btn_action_detalhes"><i style="font-size:12px" class="ti-check"></i> Pago</button>';
                            }
                            ?> 
                          
                          </span>
                                  <b><div data-toggle="modal" data-target="#statusModalFinanceiro" class="cursor_help" id="status_<?php echo $statusfclass;?>"></div></b>
                             
                                  <br><b>VENCIMENTO:</b> <?php echo $vencimento;?>
                                  <br><b>PARCELA:</b> <?php echo $parcela;?>
                                 
						                		  <br><br><b>VALOR:</b> <?php echo $valor;?>
                                
                                </td>
                    
                            </tr>
                            <tr><td style="border:none"></td></tr>
                    <?php 
                    }
                    }
                    ?>
                        </tbody> 
                    </table>
                   
                  </div>
                </div>      
         <!-- FINANC -->   
         <?php 
          }
         ?>    
               <div class="tab-pane <?php if(isset($_GET['origin']) && $_GET['origin']=='NEWDUP' || isset($_GET['origin']) && $_GET['origin']=='EDTDUP'){echo "active";}?>" id="messages">
                    <div class="alert alert-info alert-dismissible" role="alert">
			         </div>
               <a href="movimento_operacao.php?action=cad_duplicata&origin=details&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>&id=<?php echo $_GET['id'];?>">
               <span class="float-right"><button class="btn btn-info"><i class="fa fa-plus"></i> Incluir Duplicata</button></span></a><br><br>
               
               <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>                                    
                            <tr>
                              <?php 
                              $localsql=new localsql();
                               $busca = $localsql->busca_duplicata_idope($idope,$pdom); //CONTA O NUMERO DE DUPLICATAS VINCULADAS AO ID DA OPERACAO
                               foreach($busca as $line){
                               $seqdupkey=$line['seq'];		
                               $nroduplicata=$line['nroduplicata'];		
                               $idsacado=$line['idsacado'];
                               $fator=$line['fator'];
                               $iof=$line['iof'];
                               $advalorem=$line['advalorem'];
                               $numero_parcelas=$line['numero_parcelas'];
                               $maisdias=$line['maisdias'];
                               $status=$line['status'];
                               $status_conf=$line['status'];

                               $emissao=$line['dt_emissao'];	
                               $siano=substr($emissao, 0, 2); $simes=substr($emissao, 2, 2); $sidia=substr($emissao, 4, 2);
                               $emissao=$sidia.'/'.$simes.'/'.$siano;
                               $calcemissao="20".$siano.'/'.$simes.'/'.$sidia;
                               
                               $vencimento=$line['dt_vencimento'];	
                               $siano=substr($vencimento, 0, 2); $simes=substr($vencimento, 2, 2); $sidia=substr($vencimento, 4, 2);
                               $vencimento=$sidia.'/'.$simes.'/'.$siano;	
                               $calcvencimento="20".$siano.'/'.$simes.'/'.$sidia;	

                               $valor=$line['valor'];	
                               $valorpuro=$line['valor'];	
                               $valor = number_format($valor, 2, ',', '.')." R$";	

                               $busca = $localsql->busca_sacado_id($idsacado,$pdom); //CARREGA O NOME DO CEDENTE
                               foreach($busca as $line){ 
                               $nomesacado=$line['razao'];		
                               }
                               
                               if(isset($nroduplicata) && $nroduplicata!=""){
                               
                               $diferenca = strtotime($calcvencimento) - strtotime($calcemissao);
                               $dias = floor($diferenca / (60 * 60 * 24)); 
                               
                               if($tipo_juros=='S'){
                                require "calculo_juros_simples.php";
                               }
                              else{
                                require "calculo_juros_composto.php";
                              }

                               require "global_status.php";
                              ?>
                                <td>
                           <span class="float-right font-weight-bold"><br>
                         
                            <?php if($status_conf==1){?>
                              <form method="POST"  action="controle_baixa_pr.php?action=baixar&doc=duplicata">
                            <input hidden type="text" name="nrodoc" value="<?= $nroduplicata;?>">
                            <input hidden type="text" name="seq" value="<?= $seqdupkey;?>">
                           <button class="btn btn-success b_shadow_dark btn_action_detalhes"> 
                           <i style="font-size:12px" class="icon icon-wallet"></i> Baixar </button></form>
                           <a href="movimento_operacao.php?action=edt_duplicata&origin=details&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']).$seqdupkey);?>&edt=<?php echo $seqdupkey;?>&id=<?php echo $idope;?>">
                           <button class="btn btn-primary b_shadow_dark btn_action_detalhes" style="max-width:108px"> 
                           <i style="font-size:12px;" class="icon icon-pencil"></i> Editar </button></a>

                           <a href="#"  data-toggle="modal" data-target="#deletedup<?php echo $seqdupkey;?>">
                           <button class="btn btn-danger b_shadow_dark btn_action_detalhes" style="max-width:108px"> 
                           <i style="font-size:12px" class="icon icon-trash"></i> Excluir </button></a><br>

<!-- MODAL DELETAR LANÇAMENTO DUPLICATA SEQ -->
<div class="modal fade" id="deletedup<?php echo $seqdupkey;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Realmente Deseja Excluir Esta Duplicata ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body"> 
      <h5 class="text-dark">
      <br><b>VENCIMENTO:</b> <?php echo $vencimento;?>
                                  <hr>    
                                  <br><b>NUMERO DUPLICATA:</b> <?php echo $nroduplicata;?>
                                  <br><b>EMISSÃO:</b> <?php echo $emissao;?>
                                  <br><b>SACADO:</b> <?php echo $nomesacado;?>
                                  <br><b>+DIAS:</b> <?php echo $maisdias;?>
                                  <br><b>DIAS TOTAIS:</b> <?php echo $dias;?>
                                  <hr>
                                  <b>FATOR:</b> <?php echo $fator;?>%
                                  <?php 
                                 if($exibe_iof==1){ echo '<br><b>IOF</b> '.$iof.'%';}
                                 if($exibe_advalorem==1){ echo '<br><b>ADVALOREM</b> '.$advalorem.'%';}
                                  ?>
                                  <br><b>VALOR Á PAGAR:</b> <?php echo $valor_previsao_final;?>
      <br>
      <br>
      <button class="btn btn-success btn-lg">Valor Da Duplicata <?php echo $valor;?> R$ </button>
      <br>
      <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-close"></i> Voltar</button>
        <form id="excluir<?php echo $seqdupkey;?>" action="mvm_ope_remove_titulo.php?doc=duplicata&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>" method="POST">
        <input hidden type="number" value="<?php echo $seqdupkey;?>" name="seq">
        <input hidden type="number" value="<?php echo $_GET['id'];?>" name="idope">
        <input hidden type="text" value="<?php echo $nroduplicata;?>" name="nrodoc">
        <input hidden type="text" value="<?php echo number_format($valor_previsao, 2, '.', '');?>" name="valorpagar">
        <input hidden type="text" value="<?php echo number_format($valorpuro, 2, '.', '');?>" name="valor">
        <button type="submit" form="excluir<?php echo $seqdupkey;?>" class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</button></form>
      </div>
    </div>
  </div>
</div>
</div>
<?php 
}
?>
</span><br>   
                                  <b><div data-toggle="modal" data-target="#statusModal" class="cursor_help" id="status_<?php echo $statusclass;?>"></div>
                                  </b><?php echo $statusdesc;?>
								                  <br><b>VENCIMENTO:</b> <?php echo $vencimento;?>
                                  <hr>
                                  <br><b>NUMERO DUPLICATA:</b> <?php echo $nroduplicata;?>
                                  <br><b>EMISSÃO:</b> <?php echo $emissao;?>
                                  <br><b>SACADO:</b> <?php echo $nomesacado;?>
                                  <br><b>+DIAS:</b> <?php echo $maisdias;?>
                                  <br><b>DIAS TOTAIS:</b> <?php echo $dias;?>
								                  <br><br><b>VALOR:</b> <?php echo $valor;?>
                                  <hr>
                                  <b>FATOR:</b> <?php echo $fator;?>%
                                  <?php 
                                 if($exibe_iof==1){ echo '<br><b>IOF</b> '.$iof.'%';}
                                 if($exibe_advalorem==1){ echo '<br><b>ADVALOREM</b> '.$advalorem.'%';}
                                  ?>
                                  <br><b>VALOR Á PAGAR:</b> <?php echo $valor_previsao_final;?>
                                  <br>
                                </td>
                            </tr>
                            <tr><td style="border:none"></td></tr>
                    <?php 
                    }
                    }
                    ?>
                        </tbody> 
                    </table>
                   
                  </div>
                </div>

                <div class="tab-pane <?php if(isset($_GET['origin']) && $_GET['origin']=='NEWCHEQUE' || isset($_GET['origin']) && $_GET['origin']=='EDTCHE'){echo "active";}?>" id="edit"> <!-- CHEQUES -->
                <a href="movimento_operacao.php?action=cad_cheque&origin=details&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>&id=<?php echo $_GET['id'];?>">
                <span class="float-right"><button class="btn btn-info"><i class="fa fa-plus"></i> Incluir Cheque</button></span></a><br><br>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>                                    
                            <tr>
                              <?php 
                              $localsql=new localsql();
                               $busca = $localsql->busca_cheque_idope($idope,$pdom); //CONTA O NUMERO DE DUPLICATAS VINCULADAS AO ID DA OPERACAO
                               foreach($busca as $line){
                               $seqchekey=$line['seq'];		
                               $idbanco=$line['idbanco'];		
                               $agencia=$line['agencia'];		
                               $nroconta=$line['nroconta'];		
                               $nrocheque=$line['nrocheque'];		
                               $idsacado=$line['idsacado'];
                               $fator=$line['fator'];
                               $numero_parcelas=$line['numero_parcelas'];
                               $iof=$line['iof'];
                               $advalorem=$line['advalorem'];
                               $maisdias=$line['maisdias'];
                               $status_fin=$line['status'];

                               $emissao=$line['dt_emissao'];	
                               $siano=substr($emissao, 0, 2); $simes=substr($emissao, 2, 2); $sidia=substr($emissao, 4, 2);
                               $emissao=$sidia.'/'.$simes.'/'.$siano;
                               $calcemissao="20".$siano.'/'.$simes.'/'.$sidia;
                               
                               $vencimento=$line['dt_vencimento'];	
                               $siano=substr($vencimento, 0, 2); $simes=substr($vencimento, 2, 2); $sidia=substr($vencimento, 4, 2);
                               $vencimento=$sidia.'/'.$simes.'/'.$siano;	
                               $calcvencimento="20".$siano.'/'.$simes.'/'.$sidia;	

                               $valor=$line['valor'];	
                               $valorpuro=$line['valor'];	
                               $valor = number_format($valor, 2, ',', '.')." R$";	
                               
                               if($idsacado==0 || $idsacado==""){
                                $nomesacado="Não Informormado !";
                               }
                               else{
                               $busca = $localsql->busca_sacado_id($idsacado,$pdom); //CARREGA O NOME DO CEDENTE
                               foreach($busca as $line){ 
                               $nomesacado=$line['razao'];		
                               }
                               }
                               if(isset($nrocheque) && $nrocheque!=""){

                               $diferenca = strtotime($calcvencimento) - strtotime($calcemissao);
                               $dias = floor($diferenca / (60 * 60 * 24)); 
                              
							                 $busca = $localsql->busca_bancos_id($idbanco,$pdom); //CONTA O NUMERO DE DUPLICATAS VINCULADAS AO ID DA OPERACAO
                               foreach($busca as $line){
                               $banco=$line['banco'];	
                               }							   

                               if($tipo_juros=='S'){
                                require "calculo_juros_simples.php";
                               }
                              else{
                                require "calculo_juros_composto.php";
                              }

                               require "global_status.php";
                              ?>
                            <td>
                            <?php 
                            if($status_fin==1){
                            ?>
                            <form method="POST" id="<?php echo $seqchekey.$nrocheque;?>"  action="controle_baixa_pr.php?action=baixar&doc=cheque">
                            <span class="float-right font-weight-bold"><br>
                            <input hidden type="text" name="nrodoc" value="<?= $nrocheque;?>">
                            <input hidden type="text" name="seq" value="<?= $seqchekey ;?>">
                           <button class="btn btn-success btn_action_detalhes"> 
                           <i style="font-size:12px" class="icon icon-wallet"></i> Baixar </button></form><br>
                           <a href="movimento_operacao.php?action=edt_cheque&origin=details&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']).$seqchekey);?>&edt=<?php echo $seqchekey;?>&id=<?php echo $idope;?>">
                           <button form="<?php echo $seqchekey.$nrocheque;?>" class="btn btn-primary btn_action_detalhes" style="max-width:108px"> 
                           <i style="font-size:12px" class="icon icon-pencil"></i> Editar </button></a>

                           <a href="#"  data-toggle="modal" data-target="#deleteche<?php echo $seqchekey;?>">
                           <button class="btn btn-danger b_shadow_dark btn_action_detalhes" style="max-width:108px"> 
                           <i style="font-size:12px" class="icon icon-trash"></i> Excluir </button></a><br>
<!-- MODAL DELETAR LANÇAMENTO CHEQUE SEQ -->
<div class="modal fade" id="deleteche<?php echo $seqchekey;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Realmente Deseja Excluir Este Cheque ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body"> 
      <h5 class="text-dark">
      <br><b>VENCIMENTO:</b> <?php echo $vencimento;?>
                                  <hr>    
                                  <br><b>NUMERO CHEQUE:</b> <?php echo $nrocheque;?>
                                  <br><b>EMISSÃO:</b> <?php echo $emissao;?>
                                  <br><b>SACADO:</b> <?php echo $nomesacado;?>
                                  <br><b>+DIAS:</b> <?php echo $maisdias;?>
                                  <br><b>DIAS TOTAIS:</b> <?php echo $dias;?>
                                  <hr>
                                  <b>FATOR:</b> <?php echo $fator;?>%
                                  <?php 
                                 if($exibe_iof==1){ echo '<br><b>IOF</b> '.$iof.'%';}
                                 if($exibe_advalorem==1){ echo '<br><b>ADVALOREM</b> '.$advalorem.'%';}
                                  ?>
                                  <br><b>VALOR Á PAGAR:</b> <?php echo $valor_previsao_final;?>
      <br>
      <br>
      <button class="btn btn-success btn-lg">Valor Da Duplicata <?php echo $valor;?> R$ </button>
      <br>
      <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-close"></i> Voltar</button>
        <form id="excluir<?php echo $seqchekey;?>" action="mvm_ope_remove_titulo.php?doc=cheque&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>" method="POST">
        <input hidden type="number" value="<?php echo $seqchekey;?>" name="seq">
        <input hidden type="number" value="<?php echo $_GET['id'];?>" name="idope">
        <input hidden type="text" value="<?php echo $nrocheque;?>" name="nrodoc">
        <input hidden type="text" value="<?php echo number_format($valor_previsao, 2, '.', '');?>" name="valorpagar">
        <input hidden type="text" value="<?php echo number_format($valorpuro, 2, '.', '');?>" name="valor">
        <button type="submit" form="excluir<?php echo $seqchekey;?>" class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</button></form>
      </div>
    </div>
  </div>
</div>
</div>

                        
                    <?php 
                    }
                    ?> 
                    </span><br>
                                  <b><div data-toggle="modal" data-target="#statusModal" class="cursor_help" id="status_<?php echo $statusfclass;?>"></div>
                                  </b><?php echo $statusfdesc;?>
								  <br><b>VENCIMENTO:</b> <?php echo $vencimento;?>
                                  <hr>
                                  <b>BANCO:</b> <?php echo $banco;?>
                                  <br><b>AGENCIA:</b> <?php echo $agencia;?>
                                  <br><b>CONTA:</b> <?php echo $nroconta;?>
                                  <br><b>Nº CHEQUE:</b> <?php echo $nrocheque;?>
                                  <br><b>EMISSÃO:</b> <?php echo $emissao;?>
                                  <br><b>SACADO:</b> <?php echo $nomesacado;?>
                                  <br><b>+DIAS:</b> <?php echo $maisdias;?>
								  <br><br><b>VALOR:</b> <?php echo $valor;?>
                                  <hr>
                                  <b>FATOR:</b> <?php echo $fator;?>%
                                  <?php 
                                  if($exibe_iof==1){ echo '<br><b>IOF</b> '.$iof.'%';}
                                  if($exibe_advalorem==1){ echo '<br><b>ADVALOREM</b> '.$advalorem.'%';}
                                  ?>
                                  <br><b>VALOR Á PAGAR:</b> <?php echo $valor_previsao_final;?>
                                  <br>
                                </td>
                            </tr>
                            <tr><td style="border:none"></td></tr>
                            <?php
                               }
                              }
                              ?>

                        </tbody> 
                    </table>                  
				         
                </div>
            </div>
        </div>
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
	

  <!-- MODAL EXCLUIR OPERACAO -->
<div class="modal fade" id="ModalRemoveOpe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Deseja Realmente Remover Esta Operação ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
      <div class="table-responsive">
               <table class="table table-borderless text-dark" >
                  <thead>
                    <tr  >
                      <th scope="col" style="width:100px">Cedente</th>
                      <th scope="col"><?php echo $idcedente.'-'.$nomecedente;?></th>
                    </tr>
                    <tr>
                      <th scope="col" style="width:100px">Valor Da Operação</th>
                      <th scope="col"><?php echo number_format($vlr_operacao, 2, ',', '.').' R$';?></th>
                    </tr>
                    <tr>
                      <th scope="col" style="width:100px">Valor Á Pagar</th>
                      <th scope="col"><?php echo number_format($vlr_pago, 2, ',', '.').' R$';?></th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table> 
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Voltar</button>
        <a href="remove.php?action=ope&id=<?php echo $_GET['id'];?>&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']).$_GET['id']);?>">
        <button type="button" class="btn btn-danger">Excluir</button>
        </a>
      </div>
    </div>
  </div>
</div>
</div>
  

</body>
</html>
<?php
}
else{
	header('Location:login.php');
}
?>
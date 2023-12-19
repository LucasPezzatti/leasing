<?php session_start();
if(isset($_SESSION['logado']) ){
require "version.php";
require "core/conn_MYSQL.php";
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if($counterkey==$_GET['key']){
 require "core/mysql.php";

if(isset($_GET['action']) && $_GET['action']=="edit"){
//LOAD PESSOA
$id=$_GET['id'];
$localsql=new localsql();
$busca = $localsql->busca_pessoa_id($id,$pdom); //CARREGA O NOME DO CEDENTE
foreach($busca as $line){ 
$cpf=$line['cpf'];		
$cnpj=$line['cnpj'];		
$razao=$line['razao'];		
$rgie=$line['rgie'];		
$telefone=$line['telefone'];		
$celular=$line['celular'];		
$email=$line['email'];		
$tipo=$line['tipo'];		
$limite_credito=$line['limite_credito'];		
$dias_min_op_cheque=$line['dias_min_op_cheque'];		
$dias_min_op_duplicata=$line['dias_min_op_duplicata'];		
$fator_cheque=$line['fator_cheque'];		
$multa_boleto=$line['multa_boleto'];		
$juros_dia_boleto=$line['juros_dia_boleto'];		
$cep=$line['cep'];		
$endereco=$line['endereco'];		
$complemento=$line['complemento'];		
$bairro=$line['bairro'];		
$cidade=$line['cidade'];		
}
}

}

require "header.php";
$pg_action="CAD";
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
      <div class="col-lg-4">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Pessoa</div>
           <hr>
<?php 
if(isset($_GET['action']) && $_GET['action']=="edit"){
?>           
<form id="cedente" method="POST" action="cadastro_cedentes_pr.php?action=EDT&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR'])); ?>&id=<?php echo $_GET['id'];?>">
<?php 
}
else{
?>
<form id="cedente" method="POST" action="cadastro_cedentes_pr.php?action=CAD&key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR'])); ?>">
<?php 
}
?>
           <div class="form-group">
            <label for="input-1">CPF</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $cpf;}?>" name="cpf" class="form-control" id="input-1" placeholder="Numero Do CPF">
           </div>
           <div class="form-group">
            <label for="input-2">CNPJ</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $cnpj;}?>" name="cnpj" class="form-control" id="input-2" placeholder="Numero Do CNPJ">
           </div>
           <div class="form-group">
            <label for="input-3">Nome/Razão Social</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $razao;}?>" required name="razao" class="form-control" id="input-3" placeholder="Nome/Razão Social">
           </div>
           <div class="form-group">
            <label for="input-4">RG/IE</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $rgie;}?>" name="rgie" class="form-control" id="input-4" placeholder="RG/IE">
           </div>
		     <div class="form-group">
            <label for="input-4">Telefone</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $telefone;}?>" name="telefone" class="form-control" id="input-4" placeholder="Telefone">
           </div>
		    <div class="form-group">
            <label for="input-4">Celular</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $celular;}?>"  name="celular" class="form-control" id="input-4" placeholder="Celular">
           </div>
		     <div class="form-group">
            <label for="input-4">Email</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $email;}?>" name="email" class="form-control" id="input-4" placeholder="Email">
           </div>
		   <div class="form-group">
            <label for="input-2">Tipo De Cadastro</label>
              <select required name="tipo" class="form-control ng-pristine ng-valid ng-not-empty ng-valid-required ng-touched"  ng-required="isPermiteEditar(operacao.situacao)" required="required">
                      <option value="A">Selecione...</option>
                      <option <?php if(isset($_GET['action']) && $_GET['action']=="edit" && $tipo=="S"){ echo "selected";}?> value="S">Sacado</option>
                      <option <?php if(isset($_GET['action']) && $_GET['action']=="edit" && $tipo=="C"){ echo "selected";}?> value="C">Cedente</option>
                      <option <?php if(isset($_GET['action']) && $_GET['action']=="edit" && $tipo=="A"){ echo "selected";}?> value="A">Ambos</option>
              </select>
           </div>
         </div>
         </div>
      </div>

      <div class="col-lg-4">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Crédito</div>
           <hr>
            <form id="cedente">
           <div class="form-group">
            <label for="input-1">Limite De Crédito</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $limite_credito;}?>" name="limite_credito" class="form-control" id="input-1" placeholder="0.00">
           </div>
           <div class="form-group">
            <label for="input-2">Dias Mínimo Operar Cheque</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $dias_min_op_cheque;}?>" name="dias_min_op_cheque" class="form-control" id="input-2" placeholder="0">
           </div>
           <div class="form-group">
            <label for="input-3">Dias mínimo operar Duplicata</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $dias_min_op_duplicata;}?>"  name="dias_min_op_duplicata" class="form-control" id="input-3" placeholder="0">
           </div>
           <div class="form-group">
            <label for="input-4">Fator Cheque</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $fator_cheque;}?>"  name="fator_cheque" class="form-control" id="input-4" placeholder="0.00%">
           </div>
           <div class="form-group">
            <label for="input-4">Multa por boleto</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $multa_boleto;}?>" name="multa_boleto" class="form-control" id="input-4" placeholder="0.00%">
           </div>
           <div class="form-group">
            <label for="input-4">Juros ao dia por boleto</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $juros_dia_boleto;}?>" name="juros_dia_boleto" class="form-control" id="input-4" placeholder="0.00%">
           </div>
         </div>
         </div>
      </div>

      <div class="col-lg-4">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Endereço</div>
           <hr>
            <form id="cedente">
            <?php require "core/cep_api.php"; ?>
            <label for="input-1">CEP</label>
           <div class="input-group">
           
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $cep;}?>" id="cep"  onblur="pesquisacep(this.value);"   name="cep" class="form-control" id="input-1" placeholder="CEP">
            <div class="input-group-append" style="cursor: pointer;!important">
              <span class="input-group-text" id="basic-addon2">Buscar Endereço</span>
            </div>
           </div>
           <div class="form-group">
            <label for="input-2">Endereço</label>
            <input type="text" id="rua" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $endereco;}?>"  name="endereco" class="form-control" id="input-2" placeholder="Endereço">
           </div>
           <div class="form-group">
            <label for="input-3">Complemento</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $complemento;}?>" name="complemento" class="form-control" id="input-3" placeholder="Complemento">
           </div>
           <div class="form-group">
            <label for="input-4">Bairro</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $bairro;}?>" id="bairro"  name="bairro" class="form-control" id="input-4" placeholder="Bairro">
           </div>
           <div class="form-group">
            <label for="input-4">Cidade-UF</label>
            <input type="text" value="<?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo $cidade;}?>" id="cidade" name="cidade" class="form-control" id="input-4" placeholder="Cidade">
           </div>
           <div class="form-group py-2">
             <div class="icheck-material-white">
            <input type="checkbox" name="status" id="user-checkbox1" checked=""/>
            <label for="user-checkbox1">Ativo</label>
            </div>
           </div>
           <div class="form-group">
            <button type="submit" class="btn btn-light px-5"><i class="icon-cloud-upload"></i> <?php if(isset($_GET['action']) && $_GET['action']=="edit"){ echo "Atualizar Cadastro";}else{ echo "Salvar";}?>  </button>
          </div>
          </form>
         </div>
         </div>
      </div>
    </div><!--End Row-->

	<!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->

    </div>
    <!-- End container-fluid-->
    
   </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
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

 <!--Start sidebar-wrapper-->
   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="./">
       <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
       <h5 class="logo-text"><?php echo $appname.' - <span style="font-size:12px">'. $version;?></span></h5>
     </a>
   </div>
   <ul class="sidebar-menu do-nicescrol">
      <li class="sidebar-header"></li>
      <li <?php if(isset($dash)){ echo "class='active' ";}?>>
        <a href="index.php">
          <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="sidebar-header">CADASTROS</li>
	  <li <?php if(isset($pg_action) && $pg_action=="CAD"){ echo "class='active' ";}?> >
        <a href="pessoas.php">
          <i class="zmdi zmdi-account-add"></i> <span>Cadastro De Pessoas</span>
        </a>
      </li>
      <li class="sidebar-header">OPERAÇÕES</li>
	  <li <?php if(isset($mvmpg)){ echo "class='active' ";}?>>
    <?php 
      $op_action="origin=menu&action=start";
    ?>        
        <a href="movimento_operacao.php?<?php echo $op_action;?>">
          <i class="zmdi zmdi-balance-wallet"></i> <span>Nova Operação</span>
        </a>
      </li>
      <li class="sidebar-header">FINANCEIRO</li>
      <li <?php if(isset($pg_action) && $pg_action=="DESPESAS"){ echo "class='active' ";}?> >
        <a href="despesas.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"><i class="zmdi zmdi-money text-despesas"></i> <span> Despesas/Saídas</span></a>
      </li>
      <li <?php if(isset($pg_action) && $pg_action=="RECEITAS"){ echo "class='active' ";}?> >
        <a href="receitas.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"><i class="zmdi zmdi-money text-receitas"></i> <span> Receitas/Entradas</span></a>
      </li>
      <li <?php if(isset($pg_action) && $pg_action=="MVM_FINANCEIRO"){ echo "class='active' ";}?> >
        <a href="mvm_financeiro.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>"><i class="ti ti-exchange-vertical"></i> <span> Movimento Financeiro</span></a>
      </li>
      <li <?php if(isset($pg_action) && $pg_action=="CTRBAX"){ echo "class='active' ";}?>>
        <a href="controle_baixa.php">
          <i class="zmdi zmdi-case-download"></i> <span>Controle De Baixas</span>
        </a>
      </li>
      <li class="sidebar-header">Relatorios</li>
      <li <?php if(isset($pg_action) && $pg_action=="REL"){ echo "class='active' ";}?>>
       <a href="relatorios.php">
          <i class="zmdi zmdi-receipt"></i> <span>Relatorios</span>
        </a>
        </li>  
      <li class="sidebar-header">SOBRE</li>
      <li>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#versionNewModal">
          <i class="zmdi zmdi-info"></i><span>Novidades Da Versão</span>
        </a>
      </li>
      
<?php 
if(1>1){
?>
      <li>
        <a href="icons.html">
          <i class="zmdi zmdi-invert-colors"></i> <span>UI Icons</span>
        </a>
      </li>

      <li>
        <a href="forms.html">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>Forms</span>
        </a>
      </li>

      <li>
        <a href="tables.html">
          <i class="zmdi zmdi-grid"></i> <span>Tables</span>
        </a>
      </li>

      <li>
        <a href="calendar.html">
          <i class="zmdi zmdi-calendar-check"></i> <span>Calendar</span>
          <small class="badge float-right badge-light">New</small>
        </a>
      </li>

      <li>
        <a href="profile.html">
          <i class="zmdi zmdi-face"></i> <span>Profile</span>
        </a>
      </li>

      <li>
        <a href="login.php" target="_blank">
          <i class="zmdi zmdi-lock"></i> <span>Login</span>
        </a>
      </li>

       <li>
        <a href="register.html" target="_blank">
          <i class="zmdi zmdi-account-circle"></i> <span>Registration</span>
        </a>
      </li>

      <li class="sidebar-header">LABELS</li>
      <li><a href="javaScript:void();"><i class="zmdi zmdi-coffee text-danger"></i> <span>Important</span></a></li>
      <li><a href="javaScript:void();"><i class="zmdi zmdi-chart-donut text-success"></i> <span>Warning</span></a></li>
      <li><a href="javaScript:void();"><i class="zmdi zmdi-share text-info"></i> <span>Information</span></a></li>
<?php 
}
?>
    </ul>
   
   </div>
   <!--End sidebar-wrapper-->
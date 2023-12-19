<?php session_start();
require "version.php";
require "core/conn_MYSQL.php";
require "core/mysql.php";
require "header.php";
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

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

 <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
	<div class="card card-authentication1 mx-auto my-5">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="assets/images/logo.png" class="img-circle" width="160px"  alt="logo icon">
		 	</div>
		  <div class="card-title text-uppercase text-center py-3"></div>
		    <form autocomplete="off"  method="POST" action="core/authentication.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));?>" >
			  <div class="form-group">
			  <label for="exampleInputUsername">Usuario</label>
			   <div class="position-relative has-icon-right">
				  <input type="text" <?php if(isset($devmode)){ echo 'value="'.$defuser.'"';}?>
				  autocomplete="off" onClick="this.select();" name="login" class="form-control input-shadow" placeholder="Login">
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			  <label for="exampleInputPassword" >Senha</label>
			   <div class="position-relative has-icon-right">
				  <input type="password" <?php if(isset($devmode)){ echo 'value="'.$defpass.'"';}?>
				   autocomplete="off"  name="senha" class="form-control input-shadow" placeholder="Senha">
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
			   </div>
			  </div>
			<div class="form-row">
			 <div class="form-group col-6">
<!--			 
			 <div class="icheck-material-white">
                <input type="checkbox" id="user-checkbox" checked="" />
                <label for="user-checkbox">Remember me</label>
			  </div>
			  -->
			 </div>
			 <div class="form-group col-6 text-right">
			  <a href="reset-password.php?key=<?php echo md5(gethostbyaddr($_SERVER['REMOTE_ADDR'])); ?>">Esqueceu a senha ?</a>
			 </div>
			</div>
			 <button type="submit" class="btn btn-light btn-block">Logar</button>
			
			 
			 </form>
		   </div>
		  </div>
		  <div class="card-footer text-center py-3">
		    <p class="text-warning mb-0">©2023<a href="https:\\loires.com.br"> Loires Informática</a></p>
		  </div>
	     </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
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
	
	</div><!--wrapper-->
	
  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
	
  <!-- sidebar-menu js -->
  <script src="assets/js/sidebar-menu.js"></script>
  
  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>
  
</body>
</html>

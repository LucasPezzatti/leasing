<?php
require "core/mobile_check.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title><?php echo $appname.' - '.$version;?></title>
  <!-- loader -->
  <link href="assets/css/pace.min.css" rel="stylesheet"/> 
  <script src="assets/js/pace.min.js"></script> 
  <!--favicon-->
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
  <!-- Vector CSS -->
  <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.5.css" rel="stylesheet"/>
  <!-- simplebar CSS-->
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="assets/css/bootstrap.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="assets/css/sidebar-menu.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="assets/css/app-style.css?ver=2" rel="stylesheet"/>
	<!-- iOS config -->
  <link href="manifest.json?ver=<?php echo date('H');?>" rel="manifest">
	<link href="index.php" rel="canonical">
	<!-- iOS config -->
	<link href="assets/images/icons/icon-192x192.png" sizes="192x192" rel="apple-touch-icon">
	<link href="assets/images/icons/icon-152x152.png" sizes="152x152" rel="apple-touch-icon">
<!-- iOS SPLASH config -->	
<meta name="apple-mobile-web-app-capable" content="yes" />
<link href="assets/images/splash/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="assets/images/splash/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<?php 
if($mobile==true or $mobile==False){
?>
<script>
if ('serviceWorker' in navigator){
	navigator.serviceWorker.register('sw.js?ver=<?php echo date('H:i:s');?>')
	.then(function(){
	console.log('service work registered');
	})
	.catch(function () {
	console.warn('Service Worker Failed');
	});	
}
/** This code works only on properly formatted PWAs **/
var beforeInstallPrompt = null;

window.addEventListener("beforeinstallprompt", eventHandler, errorHandler);

function eventHandler(event) {
  beforeInstallPrompt = event;
}
function errorHandler(event) {
  console.log("error: " + event);
}
function instalar() {
if (beforeInstallPrompt) beforeInstallPrompt.prompt();
}
function isPWA() {
    return window.navigator.standalone == true || // iOS PWA Standalone
        document.referrer.includes('android-app://') || // Android Trusted Web App
        ["fullscreen", "standalone", "minimal-ui"].some(
            (displayMode) => window.matchMedia('(display-mode: ' + displayMode + ')').matches
        ) // Chrome PWA (supporting fullscreen, standalone, minimal-ui)
}

function isPWAandroid() {
    return window.navigator.standalone == true || // iOS PWA Standalone
        document.referrer.includes('android-app://') || // Android Trusted Web App
        window.matchMedia('(display-mode: standalone)').matches
}
console.log(isPWAandroid()); 
console.log(isPWA()); 
</script>
<?php 
}
?>
</head>
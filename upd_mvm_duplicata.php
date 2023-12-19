<?php
 session_start();
$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if(isset($_SESSION['logado']) && isset($_GET['key']) && $_GET['key']==$counterkey){	
require "core/conn_MYSQL.php";
require "core/mysql.php";

echo "<center>PASS KEY VALIDATAION<br><br>";
}
?>
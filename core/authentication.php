<?php session_start();
//Conexão com o banco de dados

date_default_timezone_set('America/Campo_Grande');
    $login=$_POST['login'];
	$login=str_replace(' ', '', $login);
	$login=str_replace('?', '', $login);
	$login=str_replace('/', '', $login);
	$login=str_replace('select', '', $login);
	$login=str_replace('*', '', $login);
	$login= strtolower($login);
	$senha=$_POST['senha'];
    $senha=md5($senha);

$counterkey=md5(gethostbyaddr($_SERVER['REMOTE_ADDR']));
if($_GET['key']==$counterkey){
	require "mysql.php";	
$localsql=new localsql();
$busca = $localsql->auth($login,$senha,$pdom);
}

if(isset($busca['login'],$busca['senha'])){		
        $_SESSION['logado']=1;
		$_SESSION['idlogin']=$busca['id'];
		$_SESSION['login']=$busca['login'];
	    $_SESSION['nome']=$busca['nome'];
	    $_SESSION['level']=$busca['level'];		
		$perini=$busca['perini'];
		
		if($perini==2){
			//PERIODO INI - MÊS (2)
			$di='01';
			$mi=date('m');
			$ai=date('Y');
			$dataini=$mi.'-'.$di.'-'.$ai;
			$datafin=date('m-d-Y');
			$_SESSION['fbdatai'] = $dataini;
			$_SESSION['fbdataf'] = $datafin;
			$ai=date('y');
			$_SESSION['dtini']=$ai.$mi.$di;
			$_SESSION['dtfin']=date('ymd');
			}
			//PERIODO INI - DIA (1)
			else{
			$dataini=date('m-d-Y');
			$datafin=date('m-d-Y');	
			$_SESSION['fbdatai'] = $dataini;
			$_SESSION['fbdataf'] = $datafin;	
			$_SESSION['dtini']=date('ymd');
			$_SESSION['dtfin']=date('ymd');
			}		

if(isset($_GET['origin'])){
header("Location: ../".$_GET['origin'].".php");
}
else{ 
header("Location: ../index.php");
}
}
else{
header("Location: ../login.php?login=error");
}
?>	
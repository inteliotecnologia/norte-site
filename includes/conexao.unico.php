<?
session_start();

define("S3_KEY", "");
define("S3_SECRET", "");

//if (($_SERVER['SERVER_NAME']=="localhost") || ($_SERVER['SERVER_NAME']=="192.168.1.2")) {
	$conexao= mysql_connect("enceladus.cle1tvcm29jx.us-east-1.rds.amazonaws.com", "user", "password") or die("O servidor est� um pouco inst�vel, favor tente novamente!");
	$seleciona_bd= mysql_select_db("curador_db");
//}
//else {
	//$conexao= mysql_connect("mysql.move.art.br", "user", "password") or die("O servidor est� um pouco inst�vel, favor tente novamente!");
	//$seleciona_bd= mysql_select_db("move_curador_db");
//}

mysql_query("set names utf8;");


define("NOME", "Norte");
define("URL_SISTEMA", "../../../");
define("URL_SITE", "https://norte.art.br/");

define("BUCKET", "https://s3.amazonaws.com/nortecurador-site/");
define("BUCKET_SITE", "site/uploads/");

if ($_SESSION["l"]=="") {
	$_SESSION["l"]= pega_lingua($_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_ACCEPT_LANGUAGE'], $_SERVER['REMOTE_ADDR']);
	$l= $_SESSION["l"];
}
else {
	$l= $_SESSION["l"];
}


?>
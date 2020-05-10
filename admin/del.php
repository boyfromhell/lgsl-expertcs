<?php
@session_start();
// This is for security 
// Only acces.
require "../lgsl_files/lgsl_class.php";
require "../lgsl_files/lgsl_config.php";

if(isset($_GET['x'])) {

	if(md5($_GET['x']) == $_SESSION['check'])	{

		lgsl_database();

  $sv = htmlspecialchars($_GET['sv']);
$del = @mysql_query("DELETE FROM `{$lgsl_config['db']['table']}` WHERE `ip` = '$sv'") or die(mysql_error());
if($del) {  echo "Server Sters, el nu mai poate fi recuperat";}else{   echo "Nu am putut sterge serverul"; }


}else {	@header("location: index.php");}
}else {	@header("location: index.php");}
?>

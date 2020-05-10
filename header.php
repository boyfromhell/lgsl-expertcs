<?php
@session_start();	
require("./lgsl_files/lgsl_config.php");
require("./lgsl_files/lgsl_class.php");

if(!DBUSER || !DBPASSWORD || !DBNAME) { @header("Location: /install/"); }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<link rel="shortcut icon" href="img/favicon.ico">
		<title>Status Servere - BETA 1</title>




    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/toastr.min.css" rel="stylesheet">

    <link href="./css/animate.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">

    <script src="./js/jquery-2.1.1.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/toastr.min.js"></script>

 		<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->
		 <script type="text/javascript">
     
      
toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "400",
  "hideDuration": "1000",
  "timeOut": "7000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
    </script>

<script type="text/javascript">

function cauta_server(str) {
    if (str == "") {   document.getElementById("livesearch").innerHTML = "Se verifica datele";   return; } else {   if (window.XMLHttpRequest) {    xmlhttp = new XMLHttpRequest();   } else {    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");   }  xmlhttp.onreadystatechange = function() { if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {    document.getElementById("livesearch").innerHTML = xmlhttp.responseText;    }    }   xmlhttp.open("GET","cauta.php?term="+str,true);    xmlhttp.send();  }
}


    </script>

	</head> 

<body class="gray-bg  top-navigation ">

<?php 
$randd = rand(99999999999999999,9999999999999999999999999);
$_SESSION['check'] = md5($randd); 
?>

<div id="random" style="display:none"><?php echo $randd; ?></div>
<script type="text/javascript">
var randdd = document.getElementById('random').innerHTML;
// VOTARE SCRIPT SECURIZAT !!! Stefan@expertcs.info :X
/**
* @author: Stefan
* @version: 1.0.1 
* @author site: www.expertcs.info
*
*/
$(function() {
$(".voturi").click(function()  
{
var id = $(this).attr("id");
var name = $(this).attr("name");
var dataString = 'id='+ id ;
var damn = $(this);

if(name=='vot')
{
$(this).fadeIn(1).html('<i class="fa fa-cog fa-spin"></i>');
$.ajax({  type: "GET",  url: "vot.php?sv="+id+"&x="+randdd,   data: dataString,    cache: false,   success: function(html)   {   damn.html(html);  }  });
}
return false;
	});
});

</script>



    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
        <nav class="navbar navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-reorder"></i>
                </button>
                <a href="index.php" class="navbar-brand"><?=$lgsl_config['name_site'];?></a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
                
                    <li>  <a aria-expanded="false" role="button" href="index.php"> Acasa</a>  </li>
                    <li>  <a aria-expanded="false" role="button" href="index.php?s=add"> Adauga server</a> </li>
                    <li>  <a aria-expanded="false" role="button" href="cauta.php"> Cautare</a> </li>                    
                 </ul>

            </div>
        </nav>
        </div>
       


		
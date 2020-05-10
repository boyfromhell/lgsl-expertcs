<?php
@session_start();
require "../lgsl_files/lgsl_config.php";

  if (empty($lgsl_config['admin']['user']) || empty($lgsl_config['admin']['pass'])) {    $msg= "1";  } elseif ($lgsl_config['admin']['pass'] == "changeme")  {    $msg= "2";  }

  $auth   = md5($_SERVER['REMOTE_ADDR'].md5($lgsl_config['admin']['user'].md5($lgsl_config['admin']['pass'])));
  $cookie = isset($_COOKIE['lgsl_admin_auth']) ? $_COOKIE['lgsl_admin_auth'] : "";

  if (isset($_POST['lgsl_user']) && isset($_POST['lgsl_pass']) && $lgsl_config['admin']['user'] == $_POST['lgsl_user'] && $lgsl_config['admin']['pass'] == $_POST['lgsl_pass'])  {    setcookie("lgsl_admin_auth", $auth, (time() + (60 * 60 * 24)), "/");    define("LGSL_ADMIN", TRUE); }  
  elseif ($cookie == $auth)  {    setcookie("lgsl_admin_auth", $auth, (time() + (60 * 60 * 24)), "/");    define("LGSL_ADMIN", TRUE);  }
header("Content-Type:text/html; charset=utf-8");
?>

	
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel - LGSL</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="../js/jasny-bootstrap.min.js"></script>

</head>

<body class="gray-bg top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
        <nav class="navbar navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-reorder"></i>
                </button>
                <a href="index.php" class="navbar-brand">LGSL 5.8.2</a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li class="active"> <a aria-expanded="false" role="button" href="../index.php"> Inapoi la site</a>  </li>
                    <li>  <a aria-expanded="false" role="button" href="index.php"> Acasa</a>  </li>
                    <li>  <a aria-expanded="false" role="button" href="?link=add"> Adauga server</a> </li>
                    <li>  <a aria-expanded="false" role="button" href="?link=vot"> Lista voturi</a> </li>  
                    <li>  <a aria-expanded="false" role="button" href="?link=delete"> Serge server</a> </li>         
                </ul>
 <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
               
            </div>
        </nav>
        </div>
       

<?php

//------------------------------------------------------------------------------------------------------------+
  if (defined("LGSL_ADMIN"))
  {
    global $output;
    $output = "";
    require "../lgsl_files/lgsl_admin.php";
    echo $output;
  }
  else
  {

if(isset($msg)){

	switch ($msg) {
		case '1':	$msgs = "ADMIN USERNAME OR PASSWORD MISSING FROM CONFIG";	break;
		case '2':	$msgs = "ADMIN PASSWORD MUST BE CHANGED FROM THE DEFAULT";	break;		
    default: break;
	}
}

?>

   <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">Bine ai venit in LGSL 5.8.2</h2>

                <p> Design nou panel admin</p>
                <p> Pagina separata de adaugare servere</p>
                <p> Pagina separata de lista   servere</p>
                <p> Pagina separata de stergere   servere</p>



        

            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                <?php
                if(isset($msg)){ echo $msgs; } ?>
                    <form class="m-t" role="form" action="#" method="post">
                        <div class="form-group">
                            <input type="username" class="form-control" placeholder="Username"  name='lgsl_user' required="">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password"   name='lgsl_pass' required="">
                        </div>
                        <button type="submit"  name='lgsl_admin_login' class="btn btn-primary block full-width m-b">Login</button>

                  
                    </form>
                    
                </div>
            </div>
        </div>

<?php
  }
   $servers =  @mysql_num_rows(@mysql_query("SELECT * FROM `{$lgsl_config['db']['table']}`"));
if(!$servers) {
	$servers = "0";
}else {
	$servers = $servers;
}
//------------------------------------------------------------------------------------------------------------+
?>
			</div>
			</div>			</div>
			</div>
			</div>
		

				
   <div class="footer fixed">
            <div class="pull-right">   Servere totale <strong><?=$servers;?></strong> in baza de date.    </div>
            <div>  <strong>Copyright</strong> <?=$lgsl_config['name_site'];?> &copy; 2014-2015  </div>
        </div>

        </div>
        </div>
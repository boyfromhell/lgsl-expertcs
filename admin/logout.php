	
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
       

                <div class="col-lg-12" align="center">
                    <div class="widget navy-bg p-xl">

                       <h2> <i class="fa fa-sign-out"></i>Deconectare admin </h2>
                       <small>Vei fi redirectionat catre index.</small>

                    </div>
                   
                </div>
                 <br />
                 <br />
                  <div class="col-lg-12" align="center">
                <?php
                setcookie("lgsl_admin_auth",  "", (time() + (60 * 60 * 24)), "/");
                ?> </div>
                <meta http-equiv="refresh" content="1; url=index.php">
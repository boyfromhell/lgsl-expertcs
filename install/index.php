<?php


define('LICENSE', true);

if (!is_file('../lgsl_files/lgsl_config.php'))
{
	exit('<html><body><h1>Configuration file not found !</h1></body></html>');
}
else
{
	require('../lgsl_files/lgsl_config.php');
}

//---------------------------------------------------------+

/**
 * Install Wizard Version
 */
define('LGSL', 'v5.8.2');


//---------------------------------------------------------+

if (isset($_POST['task']))
{
	$task = $_POST['task'];
}

switch (@$task)
{
	case 'license':	if ( isset($_POST['license']) ) { 	if ($_POST['license'] == 'on') 	{	header( "Location: index.php?step=one" ); 	die(); 	} }
		exit( "You must accept the terms of the license agreement." );
		break;

	default: 	break;
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Install and Update Script - LGSL</title>
		<!--Powered By Bright Game Panel-->
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- JS -->
		
  		<link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/font-awesome.css" rel="stylesheet">

        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
		<script src="../js/sweet-alert.min.js"></script>
        <script src="../js/jquery-1.7.2.min.js"></script>
	    <script src="../js/bootstrap.min.js"></script>	

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
			<!--[if lt IE 9]>
			  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
		<!-- Favicon -->
			<link rel="shortcut icon" href="./bootstrap/img/favicon.ico">
	</head>

<body class="gray-bg  top-navigation ">
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
              

            </div>
        </nav>
        </div>
       


		
			<div class="container">
				


<?php



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+



if (!isset($_GET['step'])) // Step == 'zero'
{
?>
		<div class="widget-head-color-box navy-bg p-lg text-center">
                            <div class="m-b-md">
                            <h2 class="font-bold no-margins">
                              Licenta GNU
                            </h2>
                                <small>LGSL <?php echo LGSL; ?></small>
                            </div>
                          
                        </div>
                        <div class="widget-text-box">

					<div style="width:auto;height:480px;overflow:scroll;overflow-y:scroll;overflow-x:hidden;">
<?php
	$license = fopen('../gpl-3.0.txt', 'r');

	while ($rows = fgets($license))
	{
		echo $rows.'<br />';
	}

	fclose($license);
?>
					</div>
				</div>
				<form method="post" action="index.php" align="center">
					<input type="hidden" name="task" value="license" />
					<label class="checkbox">
						<input type="checkbox" name="license">&nbsp;I Accept the Terms of the License Agreement
					</label>
					<div style="text-align: center; margin-top: 19px;">
						<button type="submit" class="btn btn-sm btn-primary">Submit</button>
					</div>
				</form>
		

				<div class="modal fade" aria-hidden="true" id="welcome">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4 b-r">	
                                                <Br />					
 <i class="text-warning fa fa-warning fa-4x"></i>
 <br />
                                                   
                                                 </div>
                                                <div class="col-sm-8">
 <h3>Install and Update Script</h3>

                                                    <p>	Please make backup SQL exist in database. <br/ >
							                              Va rugam faceti un backup la sql-ul existent. <br /></p>

                                                </div>
                                          
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
				<script type="text/javascript">
				$(document).ready(function() {
					$('#welcome').modal('show')
				});
				</script>
<?php
}



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+



else if ($_GET['step'] == 'one')
{
?>


<div class="widget-head-color-box navy-bg p-xs text-center">
                            <div class="m-b-md">
                            <h2 class="font-bold no-margins">
                             Install and Update Script&nbsp;
                            </h2>
                                <small>LGSL <?php echo LGSL; ?></small>
                            </div>
                          
                        </div>
                        <div class="widget-text-box">

				<table class="table">
					<thead>
						<tr>
							<th>Action</th>
							<th>Status</th>
							<th>Note</th>
						</tr>
					</thead>
					<tbody>
						<tr class="success">
							<td>Checking for CONFIGURATION file</td>
							<td><span class="label label-success">FOUND</span></td>
							<td></td>
						</tr>

<?php	if (!$lgsl_config['db']['user'])	{?>
<tr class="error">	<td>Checking your lgsl_config</td>	<td><span class="label label-important">FAILED</span></td>	<td>User for database not exist please edit lgsl_config.php line 116</td></tr>
<?php 	$error = TRUE;	}	else 	{ ?>
		<tr class="success">	<td>Checking your lgsl_config</td>	<td><span class="label label-success"><?php echo "OK"; ?></span></td>	<td></td>	</tr>
<?php 	} ?>


<?php	if (!$lgsl_config['db']['pass']){	 ?>
<tr class="error"><td>Checking your lgsl_config</td><td><span class="label label-important">FAILED</span></td><td>Pass for database not exist please edit lgsl_config.php line 117</td></tr>
<?php  $error = TRUE;	}	else 	{ ?>
		<tr class="success">	<td>Checking your lgsl_config</td>	<td><span class="label label-success"><?php echo "OK"; ?></span></td>	<td></td>	</tr>
<?php 	} ?>
<?php	if (!$lgsl_config['db']['db']){	 ?>
<tr class="error"><td>Checking your lgsl_config</td><td><span class="label label-important">FAILED</span></td><td>Database name not exist please edit lgsl_config.php line 118</td></tr>
<?php  $error = TRUE;	}	else 	{ ?>
<tr class="success">	<td>Checking your lgsl_config</td>	<td><span class="label label-success"><?php echo "OK"; ?></span></td>	<td></td>	</tr>
<?php 	} ?>

<?php	if ($lgsl_config['name_site'] == "expertcs.info"){	 ?>
<tr class="error"><td>Checking your lgsl_config</td><td><span class="label label-important">FAILED</span></td><td>Please edit name_site  line 129</td></tr>
<?php  $error = TRUE;	}	else 	{ ?>
		<tr class="success">	<td>Checking your lgsl_config</td>	<td><span class="label label-success"><?php echo "OK"; ?></span></td>	<td></td>	</tr>
<?php 	} ?>

<?php

	$versioncompare = version_compare(PHP_VERSION, '5.3.4');
	if ($versioncompare == -1)
	{
?>
						<tr class="error">
							<td>Checking your version of PHP</td>
							<td><span class="label label-important">FAILED (<?php echo PHP_VERSION; ?>)</span></td>
							<td>Upgrade to PHP 5.3.4 or greater</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking your version of PHP</td>
							<td><span class="label label-success"><?php echo PHP_VERSION; ?></span></td>
							<td></td>
						</tr>
<?php
	}
	unset($versioncompare);

?>
<?php

	if (ini_get('safe_mode'))
	{
?>
						<tr class="error">
							<td>Checking for PHP safe mode</td>
							<td><span class="label label-important">ON</span></td>
							<td>Please, disable safe mode !!!</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for PHP safe mode</td>
							<td><span class="label label-success">OFF</span></td>
							<td></td>
						</tr>
<?php
	}

?>
<?php

	if (!extension_loaded('mysql'))
	{
?>
						<tr class="error">
							<td>Checking for MySQL extension</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>MySQL extension could not be found or is not installed. Please recompile your Apache with the MySQL extension included.</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for MySQL extension</td>
							<td><span class="label label-success">INSTALLED</span></td>
							<td></td>
						</tr>
<?php

		$mysql_link = @mysql_connect(DBHOST,DBUSER,DBPASSWORD);
		if ($mysql_link == FALSE)
		{
?>
						<tr class="error">
							<td>Checking for MySQL server connection</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>Could not connect to MySQL: "<?php echo mysql_error(); ?>"</td>
						</tr>
<?php
			$error = TRUE;
		}
		else
		{
?>
						<tr class="success">
							<td>Checking for MySQL server connection</td>
							<td><span class="label label-success">SUCCESSFUL</span></td>
							<td></td>
						</tr>
<?php

			$mysql_database_link = @mysql_select_db(DBNAME);
			if ($mysql_database_link == FALSE)
			{
?>
						<tr class="error">
							<td>Checking for MySQL database</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>Could not connect to MySQL database: "<?php echo mysql_error(); ?>"</td>
						</tr>
<?php
				$error = TRUE;
			}
			else
			{
?>
						<tr class="success">
							<td>Checking for MySQL database</td>
							<td><span class="label label-success">SUCCESSFUL</span></td>
							<td></td>
						</tr>
<?php
			}
			mysql_close($mysql_link);
		}
	}

?>
<?php

	if (!function_exists('fsockopen'))
	{
?>
						<tr class="error">
							<td>Checking for FSOCKOPEN function</td>
							<td><span class="label label-important">FAILED</span></td>
							<td></td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for FSOCKOPEN function</td>
							<td><span class="label label-success">SUCCESSFUL</span></td>
							<td></td>
						</tr>
<?php
	}

?>
<?php

	if (!extension_loaded('curl'))
	{
?>
						<tr class="error">
							<td>Checking for Curl extension</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>Curl extension is not installed. (<a href="http://php.net/curl">Curl</a>).</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for Curl extension</td>
							<td><span class="label label-success">INSTALLED</span></td>
							<td></td>
						</tr>
<?php
	}

?>
<?php

	if (!extension_loaded('mbstring'))
	{
?>
						<tr class="error">
							<td>Checking for MBSTRING extension (LGSL - Used to show UTF-8 server and player names correctly)</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>mbstring extension is not installed. (<a href="http://php.net/mbstring">mbstring</a>).</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for MBSTRING extension (LGSL - Used to show UTF-8 server and player names correctly)</td>
							<td><span class="label label-success">INSTALLED</span></td>
							<td></td>
						</tr>
<?php
	}

?>
<?php

	if (!extension_loaded('bz2'))
	{
?>
						<tr class="error">
							<td>Checking for BZIP2 extension (LGSL - Used to show Source server settings over a certain size)</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>BZIP2 extension is not installed. (<a href="http://php.net/bzip2">BZIP2</a>).</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for BZIP2 extension (LGSL - Used to show Source server settings over a certain size)</td>
							<td><span class="label label-success">INSTALLED</span></td>
							<td></td>
						</tr>
<?php
	}

?>
<?php

	if (!extension_loaded('zlib'))
	{
?>
						<tr class="error">
							<td>Checking for ZLIB extension (LGSL - Required for America's Army 3)</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>ZLIB extension is not installed. (<a href="http://php.net/zlib">ZLIB</a>).</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for ZLIB extension (LGSL - Required for America's Army 3)</td>
							<td><span class="label label-success">INSTALLED</span></td>
							<td></td>
						</tr>
<?php
	}

?>
<?php

	if (!extension_loaded('gd') && !extension_loaded('gd2'))
	{
?>
						<tr class="error">
							<td>Checking for GD extension (pChart Requirement)</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>GD / GD2 extensions are not installed. (<a href="http://php.net/book.image.php">GD</a>).</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for GD extension (pChart Requirement)</td>
							<td><span class="label label-success">INSTALLED</span></td>
							<td></td>
						</tr>
<?php
	}

?>
<?php

	if (!function_exists('imagettftext'))
	{
?>
						<tr class="error">
							<td>Checking for FreeType extension (securimage Requirement)</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>FreeType extension is not installed. (<a href="http://php.net/manual/en/image.installation.php">FreeType</a>).</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for FreeType extension (securimage Requirement)</td>
							<td><span class="label label-success">INSTALLED</span></td>
							<td></td>
						</tr>
<?php
	}

?>
<?php

	if (!extension_loaded('simplexml'))
	{
?>
						<tr class="error">
							<td>Checking for SimpleXML extension</td>
							<td><span class="label label-important">FAILED</span></td>
							<td>SimpleXML extension is not installed. (<a href="http://php.net/simplexml">SimpleXML</a>).</td>
						</tr>
<?php
		$error = TRUE;
	}
	else
	{
?>
						<tr class="success">
							<td>Checking for SimpleXML extension</td>
							<td><span class="label label-success">INSTALLED</span></td>
							<td></td>
						</tr>
<?php
	}

?>

					</tbody>
				</table>
				 </div>
                        </div>
<?php

	if (isset($error))
	{
?>
				<div style="text-align: center;">
					<h3><b>Fatal Error(s) Found.</b></h3><br />
					<button class="btn" onclick="window.location.reload();">Check Again</button>
				</div>
<?php
	}
	else
	{
?>
				<div style="text-align: center;">
					<ul class="pager">
						<li>
							<a href="index.php?step=two">Next Step &rarr;</a>
						</li>
					</ul>
				</div>
<?php
	}

}



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+



else if ($_GET['step'] == 'two')
{
	$currentVersion = "5.8.2";
?>

<div class="widget-head-color-box navy-bg p-lg text-center">
    <div class="m-b-md"><h2 class="font-bold no-margins"> Install and Update Script&nbsp;</h2><small>LGSL <?php echo LGSL; ?></small> </div>
</div>
     <div class="widget-text-box">

		

				<div class="alert alert-warning alert-block">
					<strong>FOUND !</strong> Tables exist in the database.<br />
					You can update your previous version of LGSL <?php echo LGSL;?> or perform a clean install <u>which will overwrite all data (LGSL tables with the same prefix) in the database.</u><br />
					It is recommend you back up your database first.<br />
				</div>
				<h4>Current Version:</h4>&nbsp;<span class="label label-info"><?php echo $currentVersion; ?></span><br /><br />
				
				<form action="index.php" method="get">
					<input type="hidden" name="step" value="three" />
					<input name="version" type="radio" value="full" checked="checked" /><b>&nbsp;Install LGSL Version <?php echo LGSL; ?></b><br /><br />
					<button type="submit" class="btn btn-primary">Install SQL Database</button>
				</form>
				</div>


				<div style="text-align: center;">
					<ul class="pager">
						<li>
							<a href="index.php?step=one">&larr; Previous Step</a>
						</li>
					</ul>
				</div>

<?php
}



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+



else if ($_GET['step'] == 'three')
{

	switch (@$_GET['version'])
	{
		case 'full':

			
			//---------------------------------------------------------+

			require("./sql/full.php");

			break;

	

		default:
			exit('<h1><b>Error</b></h1>');
	}

	//---------------------------------------------------------+

?>
				<div class="well">
				<div class="alert alert-block">
					<strong>DELETE THE INSTALL FOLDER</strong><br />
					<?php echo getcwd(); ?>

				</div>
<?php
	if (@$_GET['version'] == 'full') // Full install case
	{
?>
				<h2>Install Complete!</h2>
				<legend>Login Information :</legend>
				Admin Username: <b>lgsladmin</b><br />
				Admin Password: <b>admin</b><br />
				<div class="alert alert-error">
					<strong>Wait!</strong>
					Remember to change the admin username and password.
				</div>
<?php
	}

	}
?>
					</div>
<?php



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+



?>
		
	<div style="margin-top:50px;"> &nbsp; </div>

<div class="footer fixed">
            <div class="pull-right">  <a href="http://expertcs.info/lgsl-2015/" target="_blank">ExpertCS LGSL</a><br />
						Install Script: <?php echo LGSL; ?> - LGSL: <?php echo LGSL; ?><br />
					</div>
            <div class="pull-left">Copyright - 2015. Released Under <a href="http://www.gnu.org/licenses/gpl.html" target="_blank">GPLv3</a>.<br />
						All Images Are Copyrighted By Their Respective Owners. </div>
</div>

			<!--Powered By Bright Game Panel-->

	</body>
</html>

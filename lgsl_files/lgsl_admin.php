<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      LIVE GAME SERVER LIST ] © RICHARD PERRY FROM GREYCUBE.COM           |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  if (!defined("LGSL_ADMIN")) { exit("DIRECT ACCESS ADMIN FILE NOT ALLOWED"); }

  require "lgsl_class.php";

  lgsl_database();
  
$server_list = lgsl_query_group();
$total = lgsl_group_totals($server_list);
if(!isset($_GET['link'])){
  $link = 'home';
}else {
   $link = htmlspecialchars($_GET['link']);
}
?>

    <div class="row" align="center">
                <div class="col-lg-2">
                    <div class="widget style1 lazur-bg">
                        <div class="row vertical-align">
                            <div class="col-xs-3">
                                <i class="fa fa-thumbs-up fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h2 class="font-bold"><?echo verifica_voturi_totale();?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="widget style1 lazur-bg">
                        <div class="row vertical-align">
                            <div class="col-xs-3">
                                <i class="fa fa-list fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h2 class="font-bold"><?echo servere_totale(); ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="widget style1 navy-bg">
                        <div class="row vertical-align">
                            <div class="col-xs-3">
                                 <i class="fa fa-eye fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h2 class="font-bold"><?echo $total['servers_online'];?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="widget style1 red-bg">
                        <div class="row vertical-align">
                            <div class="col-xs-3">
                                <i class="fa fa-eye-slash fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                               <h2 class="font-bold"><?echo $total['servers_offline'];?></h2>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
<?php


switch ($link) {
	case 'add':	    	require "add_server_admin.php";		break;	
	case 'vot':		        require "lista_voturi.php";		break;
  case 'home':          require "server_admin.php";   break;
  case 'delete':       require "detele_server.php";   break;
}



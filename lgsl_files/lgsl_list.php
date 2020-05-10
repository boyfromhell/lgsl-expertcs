<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ © RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  require "lgsl_class.php";

  $server_list = lgsl_query_group();
  $server_list = lgsl_sort_servers($server_list);

//------------------------------------------------------------------------------------------------------------+

  $output .= "
<div class='ibox float-e-margins'> <div class='ibox-title'>   Servere adaugate </div>
  <div class='ibox-content'>
    <table class='table no-margin'>
      <thead>
          <tr> <th> Vot </th> <th> Status </th>   <th> Joc </th>   <th> Ip:Port </th>  <th> Nume server </th>     <th> Jucatori </th>  <th> Tara </th>   <th> Detalii </th>   </tr> </thead>
            ";

    foreach ($server_list as $server)
    {
      $misc   = lgsl_server_misc($server);
      $server = lgsl_server_html($server);

if($misc['text_status'] == "ONLINE"){  $status = "Online";

$juc_on = $server['s']['players'];
$juc_max = $server['s']['playersmax'];

$calculate = $juc_max - $juc_on;
if($juc_on >= $juc_max) {	 $players = "<span class='text-danger'><b> Server Full </b></span>"; } 
elseif($calculate == "1") {	$players  = "<span class='text-danger'><b> Un slot liber </b></span>";}
elseif($calculate == "2") {	$players  = "<span class='text-danger'><b> Doua sloturi libere </b></span>";}
else {	$players  = "$juc_on / $juc_max";}
 
	
			$progressbar=floor(($juc_on / $juc_max) * 100);

		
     $server_voturi = verifica_voturi($server['b']['ip']);
$link = "<a href='#' class='voturi btn btn-xs btn-white ' id='{$server['b']['ip']}' name='vot'><i class='fa fa-thumbs-up'></i> Vot </a>";
      $output .= "
      <tr  table-layout:fixed'>
 
        <td> <div class='voturi btn btn-xs btn-white'>{$server_voturi}</div> {$link} </td> 
        <td> <span class='label label-primary'>{$status}</span></td>
        <td>  <img alt='' src='{$misc['icon_game']}'   title='{$misc['text_type_game']}' style='vertical-align:middle' /></td>
        <td title='{$lgsl_config['text']['slk']}'> <a href='{$misc['software_link']}' style='text-decoration:none'> {$server['b']['ip']}:{$server['b']['c_port']}  </a></td>
        <td title='{$server['s']['name']}' > <div style='width:100%; overflow:hidden; height:1.3em; line-height:1.3em'>  {$misc['name_filtered']}   </div> </td>
        <td style='white-space:nowrap;> {$server['s']['map']} </td>
        <td style='white-space:nowrap;>   	{$players}</td>";

  if ($lgsl_config['locations'])
    {
     $output .= "<td style='white-space:nowrap; text-align:center'><a href='".lgsl_location_link($server['o']['location'])."' style='text-decoration:none'> <img alt='' src='{$misc['icon_location']}' title='{$misc['text_location']}' style='vertical-align:middle; border:none' /> </a></td>";
    }
        $output .= "
         <td style='white-space:nowrap; text-align:center'> 

         <a href='server_".$server['o']['id']."' style='text-decoration:none' class='btn btn-xs btn-info'><i class='fa fa-eye'></i> Detalii </a>
        </td>

      </tr>";
        }else {  $status = "";}
    }


    $output .= "
    </table>
  </div>";


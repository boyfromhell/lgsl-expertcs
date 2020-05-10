<?php
/**
* @author: Stefan 
* @description: Live Game Server List Update #2
* @version: default 5.8 RICHARD PERRY FROM GREYCUBE.COM
* @version: 5.8.2 STEFAN ALEXANDRU FROM EXPERTCS.INFO
*
*
* ******************** Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org) ********************
*
*/

//------------------------------------------------------------------------------------------------------------+


//------------------------------------------------------------------------------------------------------------+
// THIS CONTROLS HOW THE PLAYER FIELDS ARE DISPLAYED

  $fields_show  = array("name", "score", "kills", "deaths", "team", "ping", "bot", "time", "teamindex"); // ORDERED FIRST
  $fields_hide  = array( "pid", "pbguid"); // REMOVED
  $fields_other = TRUE; // FALSE TO ONLY SHOW FIELDS IN $fields_show

    global $lgsl_server_id;
    $server = lgsl_query_cached("", "", "", "", "", "sep", $lgsl_server_id);
    if (!$server) { 
    	$output .= "<div style='margin:auto; text-align:center'> {$lgsl_config['text']['mid']} </div>"; return;
     }
    $fields = lgsl_sort_fields($server, $fields_show, $fields_hide, $fields_other);
    $server = lgsl_sort_players($server);
    $server = lgsl_sort_extras($server);
    $misc   = lgsl_server_misc($server);
    $server = lgsl_server_html($server);
 if($misc['text_status'] == "NO RESPONSE") { $output .= "OFFLINE";  die(" <div style='text-align:center;background-color:#e4eaf2'><br /> Serverul este inchis sau se schimba harta<br /> <br />"); }

?>


<div class='ibox float-e-margins'> <div class='ibox-title'>   Detalii server <?=$misc['name_filtered'];?> </div>
  <div class='ibox-content'>
    <table class='table no-margin'>
    
<?php
    if($server['s']['game'] == "cstrike") {

require "addons.php";

    $dedicat= $server['e']['dedicated'];
    $anticheatc = $server['e']['anticheat'];
    $password = $server['e']['sv_password'];
    $sis = $server['e']['os'];
    if(isset($dedicat) == "d") {  $dedicated = "Dedicat"; } else { $dedicated = "HLTV"; }
    if(isset($sis) == "l") {  $os = "Linux"; } else { $os = "Windows"; }
    /* 0 = NO , 1 = YES */
    if(isset($anticheatc) == "0") {  $anticheat = "Nu"; } else { $anticheat = "Da"; }
    if(isset($password) == "0") {  $parola = "Nu"; } else { $parola = "Da"; }
    if(isset($server['e']['amx_nextmap']) == "") { $nxt = "";}else { $nxt = $server['e']['amx_nextmap'];}
    if(isset($server['e']['amx_timeleft']) == "00:00"){     $server['e']['amx_timeleft']= "Nici o limita a timpului";    }else{     $server['e']['amx_timeleft'] = $server['e']['amx_timeleft'];     }

    $output .= "
          <table class='table no-margin'>
          <tr> <td> Status </td><td style='white-space:nowrap'> {$misc['text_status']} </td> <td> Adresa IP </td><td style='white-space:nowrap'> {$server['b']['ip']} </td></tr>
          <tr> <td> Port Conectare </td><td style='white-space:nowrap'> {$server['b']['c_port']}   </td><td> Query Port </td><td style='white-space:nowrap'> {$server['b']['q_port']}</td></tr>
          <tr> <td> Joc </td><td style='white-space:nowrap'> {$server['s']['game']}    </td><td> Sistem Operare</td><td style='white-space:nowrap'> {$os}    </td> </tr> 
          <tr> <td> Timp Ramas</td><td style='white-space:nowrap'> {$server['e']['amx_timeleft']} </td><td> Jucatori</td><td style='white-space:nowrap'> {$server['s']['players']} / {$server['s']['playersmax']} </td></tr>
          <tr> <td> Buti</td><td style='white-space:nowrap'> {$server['e']['bots']}   </td><td> Tip</td><td style='white-space:nowrap'> {$dedicated}   </td></tr> 
          <tr> <td> Harta </td><td style='white-space:nowrap'> {$server['s']['map']}</td>  <td> Urmatoarea Harta</td><td style='white-space:nowrap'> {$nxt} </td></tr>
          <tr> <td> Versiune AmxmodX </td><td style='white-space:nowrap'> {$server['e']['amxmodx_version']} </td><td> Anticheat </td><td style='white-space:nowrap'> {$anticheat} </td></tr>
          <tr> <td> Timp Bomba </td><td style='white-space:nowrap'> {$server['e']['mp_c4timer']}s  </td><td> Parola? </td><td style='white-space:nowrap'> {$parola} </td></tr>  
          <tr> <td> Pluginuri detectate </td><td colspan='3'> {$addons_server}</td> </tr>
          </table>";

$output .= "
				<div role='tabpanel'>

  <!-- Nav tabs -->
  <ul class='nav nav-tabs' role='tablist'>
    <li role='presentation' class='active'><a href='#jucatori' aria-controls='home' role='tab' data-toggle='tab'>Jucatori</a></li>
    <li role='presentation'><a href='#banner' aria-controls='profile' role='tab' data-toggle='tab'>Banner</a></li>
    <li role='presentation'><a href='#custom' aria-controls='messages' role='tab' data-toggle='tab'>Custom</a></li>
  </ul>

  <!-- Tab panes -->
  <div class='tab-content'>
    <div role='tabpanel' class='tab-pane active' id='jucatori'>
					
					
					";
/* Jucatori */
  if (empty($server['p']) || !is_array($server['p']))
  {
  $output .= " <table class='detalii_server'> <tr> <td colspan='4'>  {$lgsl_config['text']['npi']}
                </td></tr> </table>  ";
  } else {
  $output .= " <table class='table'><tr>";
  foreach ($fields as $field) { $field = ucfirst($field);  $output .= " <td> <b>{$field}</b> </td>";  } $output .= "</tr>";
  foreach ($server['p'] as $player_key => $player) { $output .= " <tr>"; foreach ($fields as $field) {  $output .= "<td> {$player[$field]} </td>"; }
  $output .= "</tr>";  } $output .= "</table>"; 
   }
  $output .= "</div>

      <div role='tabpanel' class='tab-pane' id='banner'>
"; $output .= "
   <table class='table no-margin'>
      <tr>
        <td><b>Banner</b></td>
        <td><img src='lgsl_files/lgsl_image.php?s=".$_GET['s']."'/></td>
      </tr>";
  
  $output .= "
      <tr>
        <td><b>Codes</b></td> <td><input type='text' readonly='readonly' size='55' onclick='select()' value='[url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."][img]http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port'].".png[/img][/url]' /><br />
       </tr> <tr>
        <td><b>Link</b></td> <td><input type='text' readonly='readonly' size='55' onclick='select()' value='<a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\" target=\"_blank\" ><img src=\"http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port'].".png\" /></a>' />
    </td>
      </tr>";
    
  $output .= "
      <tr>
        <td><b>Banner</b></td>
        <td><img src='lgsl_files/lgsl_image.php?s=".$_GET['s']."&type=small'/></td>
      </tr>";
    
  $output .= "
      <tr>
       <td><b>Codes</b></td>
        <td><input type='text' readonly='readonly' size='55' onclick='select()' value='[url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."][img]http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port']."-small.png[/img][/url]' /><br />
           </tr> <tr>
        <td><b>Link</b></td> <td><input type='text' readonly='readonly' size='55' onclick='select()' value='<a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\" target=\"_blank\" ><img src=\"http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port']."-small.png\" /></a>' />
     </td>  
    </tr>";
    
  $output .= "
      <tr>
        <td><b>Banner</b></td>
        <td><img src='lgsl_files/lgsl_image.php?s=".$_GET['s']."&type=sky'/></td>
      </tr>";
    
  $output .= "
      <tr>
    <td><b>Codes</b></td>
        <td><input type='text' readonly='readonly' size='55' onclick='select()' value='[url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."][img]http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port']."-sky.png[/img][/url]' /><br />
           </tr> <tr>
        <td><b>Link</b></td> <td><input type='text' readonly='readonly' size='55' onclick='select()' value='<a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\" target=\"_blank\" ><img src=\"http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port']."-sky.png\" /></a>' />
    </td>
      </tr>";
    
  $output .= "
    </table>";



  $output.="    </div>
    <div role='tabpanel' class='tab-pane' id='custom'>Customize  lgsl_details line 158 #for CS</div>
  </div>

</div>";
		
  
}elseif($server['s']['game'] == "samp") {

if($misc['text_status'] == "NO RESPONSE") { $output .= "OFFLINE";  die();}
 $output .= "<table class='table no-margin'>  <tbody><thead>
  <tr><th colspan=\"8\">{$server['s']['name']}</th></tr></thead>
          <tr>
          <td> Status </td><td style='white-space:nowrap'> {$misc['text_status']} </td>
          <td> Adresa IP </td><td style='white-space:nowrap'> {$server['b']['ip']} </td>
          </tr>     

          <tr>
          <td> Port Conectare </td><td style='white-space:nowrap'> {$server['b']['c_port']}   </td>
          <td> Query Port </td><td style='white-space:nowrap'> {$server['b']['q_port']}</td>
          </tr>

          <tr>
          <td> Joc </td><td style='white-space:nowrap'> {$server['s']['game']}    </td>
          <td> Jucatori</td><td style='white-space:nowrap'> {$server['s']['players']} / {$server['s']['playersmax']} </td>
          </tr>
         
          
          <tr>
           <td> Harta </td><td style='white-space:nowrap'> {$server['s']['map']}</td>
           <td> Mod Joc</td><td> {$server['e']['gamemode']} </td>
          </tr>

      </table>";

    
$output .= "
				<div role='tabpanel'>

  <!-- Nav tabs -->
  <ul class='nav nav-tabs' role='tablist'>
    <li role='presentation' class='active'><a href='#jucatori' aria-controls='home' role='tab' data-toggle='tab'>Jucatori</a></li>
    <li role='presentation'><a href='#banner' aria-controls='profile' role='tab' data-toggle='tab'>Banner</a></li>
    <li role='presentation'><a href='#custom' aria-controls='messages' role='tab' data-toggle='tab'>Custom</a></li>
  </ul>

  <!-- Tab panes -->
  <div class='tab-content'>
    <div role='tabpanel' class='tab-pane active' id='jucatori'>
					
					
					";
/* Jucatori */
  if (empty($server['p']) || !is_array($server['p']))
  {
  $output .= " <table class='detalii_server'> <tr> <td colspan='4'>  {$lgsl_config['text']['npi']}
                </td></tr> </table>  ";
  } else {
  $output .= " <table class='detalii_server'><tr>";
  foreach ($fields as $field) { $field = ucfirst($field);  $output .= " <td> <b>{$field}</b> </td>";  } $output .= "</tr>";
  foreach ($server['p'] as $player_key => $player) { $output .= " <tr>"; foreach ($fields as $field) {  $output .= "<td> {$player[$field]} </td>"; }
  $output .= "</tr>";  } $output .= "</table>"; 
   }
  $output .= "</div>

      <div role='tabpanel' class='tab-pane' id='banner'>
"; $output .= "
    <table class='table no-margin'>
      <tr>
        <td><b>Banner</b></td>
        <td><img src='lgsl_files/lgsl_image.php?s=".$_GET['s']."'/></td>
      </tr>";
  
  $output .= "
      <tr>
        <td><b>Codes</b></td>
        <td><input type='text' readonly='readonly' size='55' onclick='select()' value='[url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."][img]http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port'].".png[/img][/url]' /><br />
           </tr> <tr>
        <td><b>Link</b></td> <td> <input type='text' readonly='readonly' size='55' onclick='select()' value='<a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\" target=\"_blank\" ><img src=\"http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port'].".png\" /></a>' />
    </td>
      </tr>";
    
  $output .= "
      <tr>
        <td><b>Banner</b></td>
        <td><img src='lgsl_files/lgsl_image.php?s=".$_GET['s']."&type=small'/></td>
      </tr>";
    
  $output .= "
      <tr>
       <td><b>Codes</b></td>
        <td><input type='text' readonly='readonly' size='55' onclick='select()' value='[url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."][img]http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port']."-small.png[/img][/url]' /><br />
         </tr> <tr>
        <td><b>Link</b></td> <td>  <input type='text' readonly='readonly' size='55' onclick='select()' value='<a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\" target=\"_blank\" ><img src=\"http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port']."-small.png\" /></a>' />
     </td>  
    </tr>";
    
  $output .= "
      <tr>
        <td><b>Banner</b></td>
        <td><img src='lgsl_files/lgsl_image.php?s=".$_GET['s']."&type=sky'/></td>
      </tr>";
    
  $output .= "
      <tr>
    <td><b>Codes</b></td>
        <td><input type='text' readonly='readonly' size='55' onclick='select()' value='[url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."][img]http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port']."-sky.png[/img][/url]' /><br />
        </tr> <tr>
        <td><b>Link</b></td> <td>   <input type='text' readonly='readonly' size='55' onclick='select()' value='<a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\" target=\"_blank\" ><img src=\"http://".implode('/', (explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)))."/s_".$server['b']['ip']."_".$server['b']['c_port']."-sky.png\" /></a>' />
    </td>
      </tr>";
    
  $output .= "
    </table>";



  $output.="    </div>
    <div role='tabpanel' class='tab-pane' id='custom'>Customize  lgsl_details line 275 #for SA:MP</div>
  </div>

</div>";






}




  $output .= " </div>  </div>
            ";


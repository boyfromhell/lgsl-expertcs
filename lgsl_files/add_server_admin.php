<?php

  if (!defined("LGSL_ADMIN")) { exit("DIRECT ACCESS ADMIN FILE NOT ALLOWED"); }



  $lgsl_mod_list     = lgsl_mod_list(); asort($lgsl_mod_list);
  $lgsl_type_list     = lgsl_type_list(); asort($lgsl_type_list);
  $lgsl_protocol_list = lgsl_protocol_list();

  $id    = 0;
  $last_type = "source";
  $zone_list = array(0,1,2,3,4,5,6,7,8);

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists("fsockopen") && !$lgsl_config['feed']['method'])
  {
    if ((function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec")))
    {
      $output = "<div ><br /><br /><b>FSOCKOPEN IS DISABLED - YOU MUST ENABLE THE FEED OPTION</b><br /><br /></div>".lgsl_help_info(); return;
    }
    else
    {
      $output = "<div ><br /><br /><b>FSOCKOPEN AND CURL ARE DISABLED - LGSL WILL NOT WORK ON THIS HOST</b><br /><br /></div>".lgsl_help_info(); return;
    }
  }

//------------------------------------------------------------------------------------------------------------+

  if ($_POST && get_magic_quotes_gpc()) { $_POST = lgsl_stripslashes_deep($_POST); }

  if (function_exists("mysql_set_charset"))
  {
    @mysql_set_charset("utf8");
  }
  else
  {
    @mysql_query("SET NAMES 'utf8'");
  }
$output .= "
  <div class='wrapper wrapper-content animated fadeInRight'>      
    <div class='row'>    
      <div class='col-lg-12'>    
        <div class='ibox float-e-margins'>
          <div class='ibox-title'>   
            <h5>Adauga servere</h5></div> 
            ";
//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_save_1']) || !empty($_POST['lgsl_save_2']))
  {
    if (!empty($_POST['lgsl_save_1']))
    {
      // LOAD SERVER CACHE INTO MEMORY
      $db = array();
      $mysql_result = mysql_query("SELECT * FROM `{$lgsl_config['db']['table']}`");
      while($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
      {
    $db["{$mysql_row['type']}:{$mysql_row['ip']}:{$mysql_row['q_port']}"] = array($mysql_row['status'], $mysql_row['cache'], $mysql_row['cache_time']);
      }
    }

    // EMPTY SQL TABLE
 
    // CONVERT ADVANCED TO NORMAL DATA FORMAT
    if (!empty($_POST['lgsl_management']))
    {
      $form_lines = explode("\r\n", trim($_POST['form_list']));

      foreach ($form_lines as $form_key => $form_line)
      {
    list($_POST['form_type']    [$form_key],
         $_POST['form_ip']      [$form_key],
         $_POST['form_c_port']  [$form_key],
         $_POST['form_q_port']  [$form_key],
         $_POST['form_s_port']  [$form_key],
         $_POST['form_zone']    [$form_key],
         $_POST['form_disabled'][$form_key],
         $_POST['form_comment'] [$form_key]) = explode(":", "{$form_line}:::::::");
      }
    }

    foreach ($_POST['form_type'] as $form_key => $not_used)
    {


      
     // $_POST['form_comment'][$form_key] = lgsl_htmlspecialchars($_POST['form_comment'][$form_key]);

      $type   = mysql_real_escape_string(strtolower(trim($_POST['form_type']    [$form_key])));
      $ip     = mysql_real_escape_string(   trim($_POST['form_ip']      [$form_key])); 
      $ip_tuilizator  = mysql_real_escape_string(trim($_SERVER['REMOTE_ADDR']));
      $c_port     = mysql_real_escape_string(intval(trim($_POST['form_c_port']  [$form_key])));
      $q_port     = mysql_real_escape_string(intval(trim($_POST['form_q_port']  [$form_key])));
      $s_port     = mysql_real_escape_string(intval(trim($_POST['form_c_port']  [$form_key])));
      $zone   = "";
      $disabled   = isset($_POST['form_disabled'][$form_key]) ? intval(trim($_POST['form_disabled'][$form_key])) : "0";
      $comment    = "";
      $voturi     = mysql_real_escape_string(   trim($_POST['form_voturi'] [$form_key]));
      $mods = mysql_real_escape_string(   trim($_POST['form_mods'] [$form_key]));
      // CACHE INDEXED BY TYPE:IP:Q_PORT SO IF THEY CHANGE THE CACHE IS IGNORED
      list($status, $cache, $cache_time) = isset($db["{$type}:{$ip}:{$q_port}"]) ? $db["{$type}:{$ip}:{$q_port}"] : array("0", "", "");

      $status     = mysql_real_escape_string($status);
      $cache      = mysql_real_escape_string($cache);
      $cache_time = mysql_real_escape_string($cache_time);

      // THIS PREVENTS PORTS OR WHITESPACE BEING PUT IN THE IP WHILE ALLOWING IPv6
      if     (preg_match("/(\[[0-9a-z\:]+\])/iU", $ip, $match)) { $ip = $match[1]; }
      elseif (preg_match("/([0-9a-z\.\-]+)/i", $ip, $match))    { $ip = $match[1]; }

      list($c_port, $q_port, $s_port) = lgsl_port_conversion($type, $c_port, $q_port, $s_port);

      // DISCARD SERVERS WITH AN EMPTY IP AND AUTO DISABLE SERVERS WITH SOMETHING WRONG
      if     (!$ip)        { continue; }
      elseif ($c_port < 1 || $c_port > 99999)     { $disabled = 1; $c_port = 0; }
      elseif ($q_port < 1 || $q_port > 99999)     { $disabled = 1; $q_port = 0; }
      elseif (!isset($lgsl_protocol_list[$type])) { $disabled = 1; }

      $check_exist =  @mysql_num_rows(@mysql_query("SELECT ip FROM {$lgsl_config['db']['table']} WHERE `ip` LIKE '$ip'"));
   if($check_exist > 0) {
 $output .= "<div class='ibox-content ibox-heading red-bg'> <h3>Server existent</h3> <small><i class='fa fa-warning'></i> Verifica cu atentie lista cu servere adaugate.</small></div> ";
   }else {
      $mysql_query  = "INSERT INTO `{$lgsl_config['db']['table']}` (`type`,`ip`, `ip_utilizator`,`c_port`,`q_port`,`s_port`,`zone`,`disabled`,`comment`,`status`,`cache`,`cache_time`, `voturi`, `mod`) VALUES ('{$type}','{$ip}', '{$ip}','{$c_port}','{$q_port}','{$s_port}','{$zone}','{$disabled}','{$comment}','{$status}','{$cache}','{$cache_time}', '{$voturi}', '{$mods}')";
      $mysql_result = mysql_query($mysql_query) or die(mysql_error());

    $output .= "<div class='ibox-content ibox-heading navy-bg'> <h3>Server adaugat cu sucess</h3> <small><i class='fa fa-warning'></i> Serverul a fost adaugat cu success.</small></div> ";
    }
    }
  }
$output .= "  <div class='ibox-content'> 

               <form action='#' method='post'>          
 <table class='table table-striped'>
        <thead>
        <tr>
          <th>[ Joc ]  </th>
          <th>[ IP ] </th>
          <th>[ Port Conectare ]</th>
          <th>[ Query Port ] </th>
          <th>[ Dezactivat ] </th>
          <th>[ Voturi ] </th>
          <th>[ Mods ] </th>
          </tr></thead><tbody>";

//---------------------------------------------------------+

   

//---------------------------------------------------------+
        $id ++; // NEW SERVER ID CONTINUES ON FROM LAST

        $output .= "
        <tr>
         
          <td>
           <div class='ui-select'>
            <select class=' form-control' name='form_type[{$id}]'>";
//---------------------------------------------------------+
            foreach ($lgsl_type_list as $type => $description)
            {
              $output .= "
              <option ".($type == $last_type ? "selected='selected'" : "")." value='{$type}'>{$description}</option>";
            }
//---------------------------------------------------------+
            $output .= "
            </select>
            </div>
          </td>
          <td><input type='text' class='ip_mask form-control' data-mask='999.999.999.9999' name='form_ip[{$id}]'  value='' size='15' maxlength='255' /><span class='help-block'>192.168.100.200</span></td>                      
          <td><input type='text' class='form-control' name='form_c_port[{$id}]' value=''  size='5'  maxlength='5'   /></td>
          <td><input type='text' class='form-control' name='form_q_port[{$id}]' value=''  size='5'  maxlength='5'   /></td>

          <td><input class=' form-control' type='checkbox' name='form_disabled[{$id}]' value='' /></td>
          <td><input type='text' class='form-control' name='form_voturi[{$id}]' value=''  size='5'  maxlength='5'   /></td>
         <td>
            <select class=' form-control' name='form_mods[{$id}]'>";
//---------------------------------------------------------+
            foreach ($lgsl_mod_list as $type => $description)
            {
              $output .= "
              <option value='{$type}'>{$description}</option>";
            }
//---------------------------------------------------------+
            $output .= "
            </select>
            </div></td>

          
           
            </tr>
      </table>

      <input type='hidden' name='lgsl_management' value='0' />
     


       <table class='table span10'>
        <tr>
         <td><input type='submit'  class='btn btn-primary' name='lgsl_save_2'          value='Salveaza' />          </td>
    
</tr>
</table>

    
  </form>";



//------------------------------------------------------------------------------------------------------------+

  function lgsl_stripslashes_deep($value)
  {
    $value = is_array($value) ? array_map('lgsl_stripslashes_deep', $value) : stripslashes($value);
    return $value;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_htmlspecialchars($string)
  {
    // PHP4 COMPATIBLE WAY OF CONVERTING SPECIAL CHARACTERS WITHOUT DOUBLE ENCODING EXISTING ENTITIES
    $string = str_replace("\x05\x06", "", $string);
    $string = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x05\x06$1", $string);
    $string = htmlspecialchars($string, ENT_QUOTES);
    $string = str_replace("\x05\x06", "&", $string);

    return $string;
  }

//------------------------------------------------------------------------------------------------------------+
?>
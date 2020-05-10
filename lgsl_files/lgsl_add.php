<?php



  if (!$lgsl_config['public_add'])  {
?>
<div class="col-lg-12" style="margin-top:20px;"> <div class="hpanel hblue">
            <div class="panel-heading hbuilt"> <?php echo $lgsl_config['text']['asd']; ?> </div>
            <div class="panel-body">           <p><?php echo $lgsl_config['text']['asd']; ?></p>
            </div>  <div class="panel-footer">    <?php echo date("d.m.Y H:m:s");?> </div> </div> </div>
<?php
   return; 
}
//-----------------------------------------------------------------------------------------------------------+
 $lgsl_type_list = lgsl_type_list(); unset($lgsl_type_list['test']);  asort($lgsl_type_list);
 $lgsl_mod_list = lgsl_mod_list();  unset($lgsl_mod_list['test']);  asort($lgsl_mod_list);


  $type   = empty($_POST['form_type'])   ? "source" :        trim($_POST['form_type']);
  $mod    = empty($_POST['form_mod'])   ? "clasic" :        trim($_POST['form_mod']);

  $ip     = empty($_POST['form_ip'])     ? ""       :        trim($_POST['form_ip']);
  $c_port = empty($_POST['form_c_port']) ? 0        : intval(trim($_POST['form_c_port']));
  $q_port = empty($_POST['form_q_port']) ? 0        : intval(trim($_POST['form_q_port']));
  $s_port = 0;

  if     (preg_match("/(\[[0-9a-z\:]+\])/iU", $ip, $match)) { $ip = $match[1]; }
  elseif (preg_match("/([0-9a-z\.\-]+)/i", $ip, $match))    { $ip = $match[1]; }
  else                                                      { $ip = ""; }

  if ($c_port > 99999 || $q_port < 1024) { $c_port = 0; }
  if ($q_port > 99999 || $q_port < 1024) { $q_port = 0; }

  list($c_port, $q_port, $s_port) = lgsl_port_conversion($type, $c_port, $q_port, $s_port);

//-----------------------------------------------------------------------------------------------------------+

  $output .= "<div class='ibox float-e-margins'> <div class='ibox-title'>  Adaugare Servere </div>
  <div class='ibox-content'>        

<form class='form-horizontal' method='post' action=''>
<div class='form-group'>
    <label for='inputEmail3' class='col-sm-2 control-label'>{$lgsl_config['text']['joc']}</label>
  <div class='col-sm-3'> <select class='form-control' name='form_type'>";
  foreach ($lgsl_type_list as $key => $value) {   $output .= "   <option ".($key == $type ? "selected='selected'" : "")." value='{$key}'> {$value} </option>";  } 
  $output .= " </select> 
  </div>
</div>
<div class='form-group'>
  <label for='inputEmail3' class='col-sm-2 control-label'>{$lgsl_config['text']['mod']}</label>
    <div class='col-sm-3'>
      <select class='form-control' name='form_mod'>";
  foreach ($lgsl_mod_list as $key => $value)  {    $output .= "             <option ".($key == $mod ? "selected='selected'" : "")." value='{$key}'> {$value} </option>";           }
            $output .= "
      </select>
  </div>
</div>
<div class='form-group'>
  <label for='inputEmail3' class='col-sm-2 control-label'>{$lgsl_config['text']['dns']}</label>
    <div class='col-sm-3'>
     <input type='text' class='form-control' name='form_ip' value='".lgsl_string_html($ip)."' size='15' maxlength='128' />
      </select>
  </div>
</div>
<div class='form-group'>
  <label for='inputEmail3' class='col-sm-2 control-label'>{$lgsl_config['text']['cpt']}</label>
    <div class='col-sm-3'>
     <input type='text' class='form-control' name='form_c_port' value='".lgsl_string_html($c_port)."' size='5' maxlength='5' />
      </select>
  </div>
</div>
<div class='form-group'>
  <label for='inputEmail3' class='col-sm-2 control-label'>{$lgsl_config['text']['qpt']}</label>
    <div class='col-sm-3'>
     <input type='text' class='form-control' name='form_q_port' value='".lgsl_string_html($q_port)."' size='5' maxlength='5' />
      </select>
  </div>
</div>

<div class='form-group'>
  <div class='col-sm-offset-2 col-sm-10'>
    <input type='submit' class='btn btn-sm btn-primary' name='lgsl_submit_test' value='{$lgsl_config['text']['ats']}' />
           
  </div>
</div>
  </form>

  </div>
  </div>
  </div>
 ";


       

  if (empty($_POST['lgsl_submit_test']) && empty($_POST['lgsl_submit_add'])) { return; }
  if (!isset($lgsl_type_list[$type]) || !isset($lgsl_mod_list[$mod]) || !$ip || !$c_port || !$q_port)        { return; }


  lgsl_database();

  $ip     = mysql_real_escape_string($ip);
  $q_port = mysql_real_escape_string($q_port);
  $c_port = mysql_real_escape_string($c_port);
  $s_port = mysql_real_escape_string($s_port);
  $type   = mysql_real_escape_string($type);
  $ip_utilizator   = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
//-----------------------------------------------------------------------------------------------------------+

  $ip_check     = gethostbyname($ip);
  $mysql_result = mysql_query("SELECT `ip`,`disabled` FROM `{$lgsl_config['db']['table']}` WHERE `type`='{$type}' AND `q_port`='{$q_port}'");

  while ($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
  {
    if ($ip_check == gethostbyname($mysql_row['ip']))
    {
     

        if ($mysql_row['disabled'])
        {
          $output .= $lgsl_config['text']['aaa'];
        }
        else
        {
          ?>
<div class='ibox float-e-margins'> <div class='ibox-title'> <?=$lgsl_config['text']['aas'];?></div>
  <div class='ibox-content'>
  <i class="fa pe-7s-info"></i> <?=$lgsl_config['text']['aan'];?>
    </table>
    </div>
    </div>
          <?php
  
        }

       
      return;
    }
  }

//-----------------------------------------------------------------------------------------------------------+

  $server = lgsl_query_live($type, $ip, $c_port, $q_port, $s_port, "sep");
  $server = lgsl_server_html($server);

  if (!$server['b']['status'])
  {
     ?>
  
<div class="col-lg-3">
          <div class="widget red-bg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-warning fa-4x"></i>
                            <h1 class="m-xs"></h1>
                            <h3 class="font-bold no-margins">
                                <?=$lgsl_config['text']['nrs'];?>
                            </h3>
                         
                        </div>
                    </div>
</div>
          <?php
          return ;
  }

//-----------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_submit_add']))
  {
    $disabled = ($lgsl_config['public_add'] == "2") ? "0" : "1";
  $ip = gethostbyname($ip);
    $mysql_query  = "INSERT INTO `{$lgsl_config['db']['table']}` (`type`,`ip`, `ip_utilizator`,`c_port`,`q_port`,`s_port`,`disabled`,`cache`,`cache_time`, `voturi`, `mod`) VALUES ('{$type}','{$ip}','{$ip_utilizator}','{$c_port}','{$q_port}','{$s_port}','{$disabled}','','', '0', '{$mod}')";
    $mysql_result = mysql_query($mysql_query) or die(mysql_error());



      if ($disabled)
      {
           ?>
      <div class='ibox float-e-margins'> <div class='ibox-title'>     {$lgsl_config['text']['aas']}  </div>
  <div class='ibox-content'>  
      <i class="fa pe-7s-info"></i> <?=$lgsl_config['text']['ada'];?>    
      </div> 
          <?     }     else      {  ?>

      <div class='ibox float-e-margins'> <div class='ibox-title'>     {$lgsl_config['text']['aas']}  </div>
  <div class='ibox-content'>  
      <i class="fa pe-7s-info"></i> <?=$lgsl_config['text']['adn'];?>    
      </div>      
   


          <?
      }
   
  }
//-----------------------------------------------------------------------------------------------------------+
	$output .= "
 <div class='ibox float-e-margins'> <div class='ibox-title'>     {$lgsl_config['text']['asc']}  </div>
  <div class='ibox-content'>        




  <form method='post' action=''>
    <table cellpadding='4' cellspacing='2' class='table'>
      <tr> <td> <b> Nume:  </b> </td> <td style='white-space:nowrap'> {$server['s']['name']}                                   </td> </tr>
      <tr> <td> <b> Joc: </b> </td> <td style='white-space:nowrap'> {$server['s']['game']}                                </td> </tr>
      <tr> <td> <b> Harta: </b> </td> <td style='white-space:nowrap'> {$server['s']['map']}                                    </td> </tr>
      <tr> <td> <b> Jucatori: </b> </td> <td style='white-space:nowrap'> {$server['s']['players']} / {$server['s']['playersmax']} </td> </tr>
    </table>
    <div style='text-align:center;'>
       <input type='hidden' name='form_type'       value='".lgsl_string_html($type)."'   />
      <input type='hidden' name='form_ip'         value='".lgsl_string_html($ip)."'     />
      <input type='hidden' name='form_c_port'     value='".lgsl_string_html($c_port)."' />
      <input type='hidden' name='form_q_port'     value='".lgsl_string_html($q_port)."' />
      <input type='submit' name='lgsl_submit_add'  class='btn btn-info'  value='{$lgsl_config['text']['aas']}' />
    </div>
  </form>
 </div></div></div>  ";
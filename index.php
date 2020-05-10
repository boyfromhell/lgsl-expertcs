<?php
@session_start();
//------------------------------------------------------------------------------------------------------------+
  header("Content-Type:text/html; charset=utf-8");
//------------------------------------------------------------------------------------------------------------+
/**
* @author: Rich Pery And Edited by Stefan
*/

require"header.php";
?>



  <div class='wrapper wrapper-content animated fadeInRight'>      
    <div class='row'>    
    <div class="col-lg-2"> <?php  require"stanga.php";  ?></div>
      <div class='col-lg-10'>    

  

    
<?php
//------------------------------------------------------------------------------------------------------------+
  global $output, $lgsl_server_id;
  $output = "";

  $s = isset($_GET['s']) ? $_GET['s'] : "";

  if     (is_numeric($s)) { $lgsl_server_id = $s; require "lgsl_files/lgsl_details.php"; }

  elseif ($s == "add")    {                       require "lgsl_files/lgsl_add.php";     }
  else                    {                       require "lgsl_files/lgsl_list.php";    }

  echo $output;

  unset($output);
//------------------------------------------------------------------------------------------------------------+
?>



            </div>
</div>
</div>

</div>

<?php
require "footer.php";
?>
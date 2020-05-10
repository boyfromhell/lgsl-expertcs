<?php
@session_start();

?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>


<?php 
// This is for security 
// Only for delete server 
$randd = rand(99999999999999999,9999999999999999999999999);
$_SESSION['check'] = md5($randd); 

//
///
?>
<div id="random" style="display:none"><?php echo $randd; ?></div>
<script type="text/javascript">
var randdd = document.getElementById('random').innerHTML;
/**
** @author: Stefan - www.expertrcs.info
** @version:1.0.4 - Stergere Server 
*/
$(function() {
$(".sterge").click(function()   {
var id = $(this).attr("id");

//var dataString = 'id='+ id ;
var damn = $(this);
  $(this).fadeIn(1).html('&nbsp;&nbsp;<i class="fa fa-cog fa-spin"></i>'); 
  $.ajax({ 
    type: "GET",                    url: "del.php?sv="+id+"&x="+randdd,         
            // data: dataString,               
             cache: false,  
      success:  function(html)   {      damn.html(html);  }  });     
  return false;  
}); 
});
</script>

<div class='wrapper wrapper-content animated fadeInRight'>
            <div class='row'>
                <div class='col-lg-12'>
                <div class='ibox float-e-margins'>
                    <div class='ibox-title'> <h5>Stergere Server</h5> </div>
                     <div class="ibox-content ibox-heading">
                        <h3> <i class="fa fa-warnings"></i> Serverele sterse nu pot fi recuperate.</h3>
                        <small><i class="fa fa-stack-exchange"></i> Acest mesaj apare pentru securitatea site-ului.</small>
                    </div>
                    <div class='ibox-content'>


<table class='table no-margin'>
	<thead>
			<tr>
          <th> Id </th>
          <th>IP </th>
          <th>Voturi </th>
          <th>Mods</th>
          <th>Game </th>
      </tr>
	</thead>
				<tbody>

<?php
function cleanuserinput($dirty){
  if (get_magic_quotes_gpc()) {
    $clean = mysql_real_escape_string(stripslashes($dirty));   
  }else{
    $clean = mysql_real_escape_string($dirty);  
  } 
  return $clean;
}


      $mysql_result = mysql_query("SELECT * FROM `{$lgsl_config['db']['table']}` ORDER BY `id` ASC");

      while($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
      {
        $id = $mysql_row['id']; // ID USED AS [] ONLY RETURNS TICKED CHECKBOXES
         $output .= "
        <tr>
          
          <td>".lgsl_string_html($mysql_row['id'])."</td>       
          <td>".lgsl_string_html($mysql_row['ip'])."</td>
          <td>".lgsl_string_html($mysql_row['voturi'])."</td>
          <td>".lgsl_string_html($mysql_row['mod'])."</td>                
          <td>".lgsl_string_html($mysql_row['type'])."</td>
          <td> <a href='' class='sterge btn btn-sm btn-info' id='".lgsl_string_html($mysql_row['ip'])."'> Delete</a>   </td>
          </tr>";

      
      }

  $output .= "</tbody>
</table>";

?>










  
        </div>
        </div>
        </div>
        </div>
        </div>
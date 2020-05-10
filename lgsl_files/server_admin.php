
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Servere Adaugate</h5>
                       
                    </div>

<?php
                 $check_exist =  @mysql_num_rows(@mysql_query("SELECT * FROM `{$lgsl_config['db']['table']}`"));
   if($check_exist  < 1) {
die("<div class='ibox-content ibox-heading navy-bg'> <h3>Nici un server in baza de date</h3> <small><i class='fa fa-warning'></i> Nu exista servere de afisat.</small></div>");
   }else {     

?>


                    <div class="ibox-content">


				
										<table class='table no-margin'>
								        <thead>
							       <tr>
       
          <th>IP </th>
          <th>Port Conectare</th>
          <th>Query Port </th>
          <th>Dezactivat</th>
          <th>Voturi </th>
          <th>Mods</th>
          </tr>
								        </thead>
								        <tbody>

<?php
//---------------------------------------------------------+

      $mysql_result = mysql_query("SELECT * FROM `{$lgsl_config['db']['table']}` ORDER BY `id` ASC");

      while($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
      {
        $id = $mysql_row['id']; // ID USED AS [] ONLY RETURNS TICKED CHECKBOXES

if($mysql_row['disabled'] == "1") {
	 $disabled = "Yes";
}else {
	$disabled= "No";
}
         
        $output .= "
        <tr>
         
         
          <td >".lgsl_string_html($mysql_row['ip'])."</td>
          <td >".lgsl_string_html($mysql_row['c_port'])."</td>
          <td >".lgsl_string_html($mysql_row['q_port'])."</td>
                    <td >".$disabled."</td>
          <td >".lgsl_string_html($mysql_row['voturi'])."</td>
          <td >".lgsl_string_html($mysql_row['mod'])."</td>
                

          </tr>";

        $last_type = $mysql_row['type']; // SET LAST TYPE ( $mysql_row EXISTS ONLY WITHIN THE LOOP )
      }
//---------------------------------------------------------+
        $id ++; // NEW SERVER ID CONTINUES ON FROM LAST

  
  $output .= "</tbody>
</table>";

?>



</div>
</div>
</div>
</div>
</div>
<?php } ?>
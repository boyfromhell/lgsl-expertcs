<div class='wrapper wrapper-content animated fadeInRight'>
            <div class='row'>
                <div class='col-lg-12'>
                <div class='ibox float-e-margins'>
                    <div class='ibox-title'>
                        <h5>Lista Voturi</h5>
                       
                    </div>
<?php
                 $check_exist =  @mysql_num_rows(@mysql_query("SELECT * FROM `lgsl_voturi`"));
   if($check_exist  < 1) {
die("<div class='ibox-content ibox-heading navy-bg'> <h3>Nici un vot in baza de date</h3> <small><i class='fa fa-warning'></i> Nu exista voturi de afisat.</small></div>");
   }else {     

?>
                    <div class='ibox-content'>


        
                    <table class='table no-margin'>
                           <thead>
                     <tr align="center">       
                       <th>IP</th>
                <th>Server Votat</th>               
                <th>Zi.Luna.An</th>
                <th>Ora</th>
          </tr>
                        </thead>
                     
<?php
function cleanuserinput($dirty){
  if (get_magic_quotes_gpc()) {
    $clean = mysql_real_escape_string(stripslashes($dirty));   
  }else{
    $clean = mysql_real_escape_string($dirty);  
  } 
  return $clean;
}

$servere_totale = @mysql_num_rows(@mysql_query("SELECT * FROM `lgsl_voturi`"));
$servere_pagina = 15;


if(isset($_GET['pagina'])){
$cerinta = htmlspecialchars($_GET['pagina']);
}else {
	$cerinta = "1";
}

if(!$cerinta) { $cerinta = 1;}else {$cerinta = $cerinta;}
$pagina = str_replace(array('\'', '"', ',' , ';', '<', '>', '-'), '', $cerinta);
if(!is_numeric($pagina)) { $pagina = 1; } else { $pagina = $pagina; }
if(!isset($pagina)) { $pagina = 1; } else { $pagina = $pagina; } 


$selectare = (($pagina * $servere_pagina) - $servere_pagina); 



$getdata = mysql_query("SELECT * FROM `lgsl_voturi` ORDER BY  data DESC LIMIT {$selectare}, {$servere_pagina} ") or die(mysql_error());
while($row = mysql_fetch_array($getdata))
{

$server_votat = $row['vot_pentru'];
$ip_vot = $row['ip'];
$data_vot = $row['data'];
$ora_vot = $row['ora_minut'];

$arata_ip = $ip_vot;

if($arata_ip = "127.0.0.1") { 	$arata_ip = "Localhost"; }else { 	$arata_ip =$arata_ip; }

$dataxs = date("d.m.Y");

?>

<tr>
<td><?=$arata_ip;?></td>
<td><?=$server_votat;?></td>
<?
if($data_vot == $dataxs){
    echo  "<td>Astazi</td>";
}else {
    echo  "<td>{$data_vot}</td>";
}
?>
<td><?=$ora_vot;?></td>


</tr>

<?}?>

</table>


<div class="btn-group">
                <ul>            
        <?
$pagini = ceil($servere_totale / $servere_pagina);

if($pagina > 1)
{
$inapoi = ($pagina - 1);
echo "<li class='btn btn-white'><a href='index.php?link=vot&pagina=$inapoi'><i class='fa fa-chevron-left'></i></a></li>";
}
else
{
echo "<li class='btn btn-white'><i class='fa fa-chevron-left'></i></li>";
 }

for($curent = 1; $curent <= $pagini; $curent++)
{
if(($pagina) == $curent)
{
echo '<li class="btn btn-white  active"><a href="#">'.$curent.'</a></li>';
}
else
{
echo "<li class='btn btn-white'><a href='index.php?link=vot&pagina=$curent'>{$curent}</a></li>";
}
}

if($pagina < $pagini)
{
$inainte = ($pagina + 1);
echo "<li class='btn btn-white'><a href='index.php?link=vot&pagina=$inainte'><i class='fa fa-chevron-right'></i></a></li>";
}
else
{
echo '<li class="btn btn-white"><i class="fa fa-chevron-right"></i></li>';
}
    ?>

                         
                                </ul>
                            </div>



</div>
</div>
</div>
</div>
</div>

<?php }?>
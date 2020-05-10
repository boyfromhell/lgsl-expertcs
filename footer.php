
<?php
  $s = isset($_GET['s']) ? $_GET['s'] : "";

  if     (is_numeric($s)) { 
  	$juc_on = $server['s']['players'];
$juc_max = $server['s']['playersmax'];

$calculate = $juc_max - $juc_on;
if($juc_on >= $juc_max) {	 $players = "<span class='text-danger'><b> Server Full </b></span>"; } 
elseif($calculate == "1") {	$players  = "<span class='text-danger'><b> Un slot liber </b></span>";}
elseif($calculate == "2") {	$players  = "<span class='text-danger'><b> Doua sloturi libere </b></span>";}
else {	$players  = "$juc_on / $juc_max";}

?>
<div class="footer fixed">
            <div class="pull-right">        
            <strong>Detalii server</strong>  <span class='text-success'><?=$misc['name_filtered'];?></span> 
            <strong>Jucatori on</strong>  <span class='text-success'><?=$players;?></span> 
            </div><div>   <strong>Copyright</strong> <?=$lgsl_config['name_site'];?> &copy; 2014-2015   </div>
</div>
<?php
}else {
?>


<div class="footer fixed">
            <div class="pull-right">   Servere totale <strong><?=servere_totale();?></strong> in baza de date.    </div>
            <div>  <strong>Copyright</strong> <?=$lgsl_config['name_site'];?> &copy; 2014-2015  </div>
</div>

<?php
}
?>
        </div>
        </div>
          <!-- Toastr script -->
 



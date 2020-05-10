<?php
/**
** Stefan 2015 - 
**
*/
$server_list = lgsl_query_group();
$total = lgsl_group_totals($server_list);



if(!isset($server_list)){
?>
	<div class="freebies">
				<div class="sidebar-addons">
				 Nu pot reda lista
				</div>
	</div>

<?php }else{ ?>

<div class='ibox float-e-margins'>
 <div class='ibox-title'>  Meniu </div>
  <div class='ibox-content'>

  <ul class="nav">
                    <li><i class="fa fa-circle-o text-success"></i> Servere:         <span class='pull-right text-success'><?=$total['servers'];?></span>	</li>
					<li><i class="fa fa-circle-o text-success"></i> Jucatori on:     <span class='pull-right text-success'><?=$total['players'];?></span>	</li>
					<li><i class="fa fa-circle-o text-success"></i> Sloturi Dis:     <span class='pull-right text-success'><?=$total['sloturi_on'];?></span>	</li>
					<li><i class="fa fa-circle-o text-success"></i> Sloturi Totale: 	<span class='pull-right text-success'><?=$total['playersmax'];?></span>	</li>					
					<li><i class="fa fa-circle-o text-success"></i> Voturi totale: 	<span class='pull-right text-success'><?echo verifica_voturi_totale();?></span></li>					
					
				</ul>
			
		
					<ul class="nav">
						<li><i class="fa fa-circle-o text-success"></i>	Servers Online   <span class='pull-right text-success'><?=$total['servers_online'];?></span></li> 
						<li><i class="fa fa-circle-o text-danger"></i>  Servers Offline  <span class='pull-right text-danger'><?=$total['servers_offline'];?></span></li>      
					</ul>
				

</div>
</div>


			<?php
				}
			?>
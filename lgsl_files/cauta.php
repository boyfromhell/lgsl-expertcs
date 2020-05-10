<?php
require_once("lgsl_config.php");
require_once("lgsl_class.php");
lgsl_database();

?>


<?php


if(empty($_GET)){	header('Location: index.php'); }

$term = mysql_real_escape_string($_GET['term']);
$keywords = preg_split('#\s+#', $term);


$c = 0;
foreach($keywords as $keyword){	if(strlen($keyword) < 3){		$c++;	} }
if($c > 0){
	$errors = "One of the keywords you entered is too short.";
}
if(strlen($term) < 4){
	$errors = "Search string too short!";
}


	

	$name_where		   = "`ip` LIKE '%" . implode("%' OR `ip` LIKE '%", $keywords) . "%'";
	$query             = mysql_query("SELECT * FROM `lgsl` WHERE {$name_where} AND `disabled` = 0");
	
	if(@mysql_num_rows($query) == 0) { die("<i>This server  <b>" . $term . "</b> not exist in <b>database</b>.Please check another ip/dns</i><br /><br />");
	}else { echo "<i>Cautare servere dupa urmatorul ip introdus sau cifra <b>" . $term . "</b></i><br /><br />";

 
?>
<table class="table table-bordered table-stripped" style="background:white;">
	<tbody>
<?php

	while($server_datas = mysql_fetch_assoc($query)){


	$server_data = lgsl_query_cached($server_datas['type'], $server_datas['ip'], $server_datas['c_port'], $server_datas['q_port'], $server_datas['s_port'], 'se'); 
?>
		
		<tr>
			<td>
				<?php if($server_data['s']['name']){	?>	<span class="badge badge-success">Online</span>&nbsp;<?php } else { ?> 	<span class="badge badge-important">Error</span>&nbsp; <?php } ?>
				<?php echo $server_datas['ip'] . ":" . $server_datas['c_port']; ?><br />
			</td>
			<td>
				<strong>Name:</strong> <?php echo $server_data['s']['name']; ?><br />
			</td>
			<td>
				<strong>Online players:</strong> <?php echo $server_data['s']['players'] . " / " . $server_data['s']['playersmax']; ?><br />
			</td>
			
			<td>
				<strong>Votes:</strong> <?php echo $server_datas['voturi']; ?></td>
			</tr>

<?php } ?>
	</tbody>
</table>
<?php
}


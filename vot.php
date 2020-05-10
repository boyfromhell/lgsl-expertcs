<?php	
@session_start();
require"./lgsl_files/lgsl_config.php";
require"./lgsl_files/lgsl_class.php";
lgsl_database();

if(isset($_GET['x']))
{
	if(md5($_GET['x']) == $_SESSION['check'])
	{
        $date = date('d.m.Y');
		$ora_minut = date('H:i');
		$ip = $_SERVER['REMOTE_ADDR'];
		$sv = htmlspecialchars($_GET['sv']);

		$ip_server = gethostbyname($sv);
		
		$verifica = mysql_num_rows(mysql_query("SELECT * FROM lgsl WHERE `ip`='$ip_server' LIMIT 1"));
				
		if($verifica == 0) {
		 echo "Serverul nu exista in baza de date";
		}
		else 
		{
			$tmpQuery =  mysql_query("SELECT * FROM `lgsl_voturi` WHERE `ip`='$ip' && `vot_pentru`='$ip_server' && `data`='$date'");
			if(mysql_num_rows($tmpQuery) == 0) 
			{
				mysql_query("INSERT INTO `lgsl_voturi` (`ip`, `data`, `vot_pentru`, `ora_minut`) VALUES ('$ip', '$date', '$ip_server', '$ora_minut')");
				mysql_query("UPDATE `lgsl` SET voturi=voturi+1 WHERE ip='$ip_server'");
			?>
<script>
         toastr.success('Ai votat cu success','Vot acceptat')
       </script>
		<?php 	} else { 	?>
			

<script> toastr.error('Eroare Vot','Astazi ai votat!')</script>
		<?php
			}
		}
	}
}

		?>
<?php


$conn = new mysqli(DBHOST,DBUSER,DBPASSWORD,DBNAME);
 
// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}


	function query_basic($query)
	{
		global $conn;
		$result = $conn->query($query);
		if ($result == FALSE)
		{
			$msg = "\r\n<br /><b>Invalid query</b> : ".mysql_error()."\n";
			echo $msg;
		}
	}
	



			query_basic( "DROP TABLE IF EXISTS lgsl");
			query_basic("CREATE TABLE IF NOT EXISTS `lgsl`(  `id`         INT     (11)  NOT NULL auto_increment,  `type`       VARCHAR (50)  NOT NULL DEFAULT '',  `ip`         VARCHAR (255) NOT NULL DEFAULT '',  `ip_utilizator` varchar(255) NOT NULL DEFAULT '',  `c_port`     VARCHAR (5)   NOT NULL DEFAULT '0',  `q_port`     VARCHAR (5)   NOT NULL DEFAULT '0',  `s_port`     VARCHAR (5)   NOT NULL DEFAULT '0',  `zone`       VARCHAR (255) NOT NULL DEFAULT '',  `disabled`   TINYINT (1)   NOT NULL DEFAULT '0',  `comment`    VARCHAR (255) NOT NULL DEFAULT '',  `status`     TINYINT (1)   NOT NULL DEFAULT '0',  `cache`      TEXT          NOT NULL,  `cache_time` TEXT          NOT NULL,  `voturi` varchar(255)      NOT NULL,  `mod` varchar(255)         NOT NULL,   PRIMARY KEY (`id`)  );");

			query_basic( "DROP TABLE IF EXISTS lgsl_voturi");
			query_basic("CREATE TABLE IF NOT EXISTS `lgsl_voturi` ( `id`         INT     (11)  NOT NULL auto_increment,   `ip`         VARCHAR (255) NOT NULL DEFAULT '',   `data`       VARCHAR (255) NOT NULL DEFAULT '',      `vot_pentru` VARCHAR (255) NOT NULL DEFAULT '',    `ora_minut` 	varchar(255)  NOT NULL ,    PRIMARY KEY (`id`));");


			




?>
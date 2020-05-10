<?php

//------------------------------------------------------------------------------------------------------------+
//[ PREPARE CONFIG - DO NOT CHANGE OR MOVE THIS ]

  global $lgsl_config; $lgsl_config = array();

//------------------------------------------------------------------------------------------------------------+
//[ FEED: 0=OFF 1=CURL OR FSOCKOPEN 2=FSOCKOPEN ONLY / LEAVE THE URL ALONE UNLESS YOU KNOW WHAT YOUR DOING ]

  $lgsl_config['feed']['method'] = 2;
   $lgsl_config['feed']['url']    = "http://www.greycube.co.uk/lgsl/feed/lgsl_files/lgsl_feed.php";

//------------------------------------------------------------------------------------------------------------+
//[ BACKGROUND COLORS: TEXT HARD TO READ ? CHANGE THESE TO CONTRAST THE FONT COLOR / www.colorpicker.com ]

  $lgsl_config['background'][1] = "background-color:#e4eaf2";
  $lgsl_config['background'][2] = "background-color:#f4f7fa";

//------------------------------------------------------------------------------------------------------------+
//[ SHOW LOCATION FLAGS: 0=OFF 1=GEO-IP "GB"=MANUALLY SET COUNTRY CODE FOR SPEED ]

  $lgsl_config['locations'] = 1;

//------------------------------------------------------------------------------------------------------------+
//[ SHOW TOTAL SERVERS AND PLAYERS AT BOTTOM OF LIST: 0=OFF 1=ON ]

  $lgsl_config['list']['totals'] = 1;

//------------------------------------------------------------------------------------------------------------+
//[ SORTING OPTIONS ]

  $lgsl_config['sort']['servers'] = "id";   // OPTIONS: id  type  zone  players  status
  $lgsl_config['sort']['players'] = "score"; // OPTIONS: name  score

//------------------------------------------------------------------------------------------------------------+
//[ ZONE SIZING: HEIGHT OF PLAYER BOX DYNAMICALLY CHANGES WITH THE NUMBER OF PLAYERS ]

  $lgsl_config['zone']['width']     = "160"; // images will be cropped unless also resized to match
  $lgsl_config['zone']['line_size'] = "19";  // player box height is this number multiplied by player names
  $lgsl_config['zone']['height']    = "100"; // player box height limit

//------------------------------------------------------------------------------------------------------------+
//[ ZONE GRID: NUMBER=WIDTH OF GRID - INCREASE FOR HORIZONTAL ZONE STACKING ]

  $lgsl_config['grid'][1] = 1;
  $lgsl_config['grid'][2] = 1;
  $lgsl_config['grid'][3] = 1;
  $lgsl_config['grid'][4] = 1;
  $lgsl_config['grid'][5] = 1;
  $lgsl_config['grid'][6] = 1;
  $lgsl_config['grid'][7] = 1;
  $lgsl_config['grid'][8] = 1;

//------------------------------------------------------------------------------------------------------------+
//[ ZONE SHOWS PLAYER NAMES: 0=HIDE 1=SHOW ]

  $lgsl_config['players'][1] = 1;
  $lgsl_config['players'][2] = 1;
  $lgsl_config['players'][3] = 1;
  $lgsl_config['players'][4] = 1;
  $lgsl_config['players'][5] = 1;
  $lgsl_config['players'][6] = 1;
  $lgsl_config['players'][7] = 1;
  $lgsl_config['players'][8] = 1;

//------------------------------------------------------------------------------------------------------------+
//[ ZONE RANDOMISATION: NUMBER=MAX RANDOM SERVERS TO BE SHOWN ]

  $lgsl_config['random'][0] = 0;
  $lgsl_config['random'][1] = 0;
  $lgsl_config['random'][2] = 0;
  $lgsl_config['random'][3] = 0;
  $lgsl_config['random'][4] = 0;
  $lgsl_config['random'][5] = 0;
  $lgsl_config['random'][6] = 0;
  $lgsl_config['random'][7] = 0;
  $lgsl_config['random'][8] = 0;

//------------------------------------------------------------------------------------------------------------+
// [ HIDE OFFLINE SERVERS: 0=HIDE 1=SHOW

  $lgsl_config['hide_offline'][0] = 0;
  $lgsl_config['hide_offline'][1] = 0;
  $lgsl_config['hide_offline'][2] = 0;
  $lgsl_config['hide_offline'][3] = 0;
  $lgsl_config['hide_offline'][4] = 0;
  $lgsl_config['hide_offline'][5] = 0;
  $lgsl_config['hide_offline'][6] = 0;
  $lgsl_config['hide_offline'][7] = 0;
  $lgsl_config['hide_offline'][8] = 0;

//------------------------------------------------------------------------------------------------------------+
//[ e107 VERSION: TITLES - OTHER VERSIONS ARE SET BY THE CMS ]

  $lgsl_config['title'][0] = "Live Game Server List";
  $lgsl_config['title'][1] = "Game Server";
  $lgsl_config['title'][2] = "Game Server";
  $lgsl_config['title'][3] = "Game Server";
  $lgsl_config['title'][4] = "Game Server";
  $lgsl_config['title'][5] = "Game Server";
  $lgsl_config['title'][6] = "Game Server";
  $lgsl_config['title'][7] = "Game Server";
  $lgsl_config['title'][8] = "Game Server";

//------------------------------------------------------------------------------------------------------------+
//[ STAND-ALONE VERSION: LGSL ADMIN LOGON ]

  $lgsl_config['admin']['user'] = "admin";
  $lgsl_config['admin']['pass'] = "admin";

//------------------------------------------------------------------------------------------------------------+
//[ DATABASE SETTINGS: FOR STAND-ALONE OR TO OVERRIDE CMS DEFAULTS ]

  $lgsl_config['db']['server'] = "localhost";
  $lgsl_config['db']['user']   = "";
  $lgsl_config['db']['pass']   = "";
  $lgsl_config['db']['db']     = "";
  $lgsl_config['db']['table']  = "lgsl";

  define("DBHOST", $lgsl_config['db']['server']);
  define("DBUSER", $lgsl_config['db']['user']);
  define("DBPASSWORD", $lgsl_config['db']['pass']);
  define("DBNAME", $lgsl_config['db']['db']);
  define("DBTABLE", $lgsl_config['db']['table']);
      
//------------------------------------------------------------------------------------------------------------+
//[ ADTIONAL SETTINGS] 

  $lgsl_config['name_site']  = "nume-lung-apare";
// Register API keys at https://www.google.com/recaptcha/admin
//	 $siteKey = "";
//	 $secret = "";

//------------------------------------------------------------------------------------------------------------+
//[ HOSTING FIXES ]

  $lgsl_config['direct_index'] = 0;  // 1=link to index.php instead of the folder
  $lgsl_config['no_realpath']  = 0;  // 1=do not use the realpath function
  $lgsl_config['url_path']     = ""; // full url to /lgsl_files/ for when auto detection fails

//------------------------------------------------------------------------------------------------------------+
//[ ADVANCED SETTINGS ]

  $lgsl_config['management']    = 0;         // 1=show advanced management in the admin by default
  $lgsl_config['host_to_ip']    = 0;         // 1=show the servers ip instead of its hostname
  $lgsl_config['public_add']    = 2;         // 1=servers require approval OR 2=servers shown instantly
  $lgsl_config['public_feed']   = 0;         // 1=feed requests can add new servers to your list
  $lgsl_config['cache_time']    = 60;        // seconds=time before a server needs updating
  $lgsl_config['live_time']     = 3;         // seconds=time allowed for updating servers per page load
  $lgsl_config['timeout']       = 0;         // 1=gives more time for servers to respond but adds loading delay
  $lgsl_config['retry_offline'] = 0;         // 1=repeats query when there is no response but adds loading delay
  $lgsl_config['cms']           = "sa";      // sets which CMS specific code to use

//------------------------------------------------------------------------------------------------------------+
//[ TRANSLATION  - Romanian - For suport RO / EN www.expertcs.info or stefan_rienro @ yahoo.ro -  ]



  $lgsl_config['text']['vsd'] = "Click sa vezi detaliile serverului";
  $lgsl_config['text']['slk'] = "Link Joc";
  $lgsl_config['text']['sts'] = "Status:";
  $lgsl_config['text']['adr'] = "Adresa:";
  $lgsl_config['text']['cpt'] = "Connection Port:";
  $lgsl_config['text']['qpt'] = "Query Port:";
  $lgsl_config['text']['typ'] = "Tip:";
  $lgsl_config['text']['gme'] = "Joc:";
  $lgsl_config['text']['map'] = "Harta:";
  $lgsl_config['text']['plr'] = "Jucatori:";
  $lgsl_config['text']['npi'] = "Nu sunt jucatori pe server";
  $lgsl_config['text']['nei'] = "NO EXTRA INFO";
  $lgsl_config['text']['ehs'] = "Setting";
  $lgsl_config['text']['ehv'] = "Value";
  $lgsl_config['text']['onl'] = "ONLINE";
  $lgsl_config['text']['onp'] = "ONLINE WITH PASSWORD";
  $lgsl_config['text']['nrs'] = "Server OFFLINE";
  $lgsl_config['text']['pen'] = "WAITING TO BE QUERIED";
  $lgsl_config['text']['zpl'] = "PLAYERS:";
  $lgsl_config['text']['mid'] = "INVALID SERVER ID";
  $lgsl_config['text']['nnm'] = "--";
  $lgsl_config['text']['nmp'] = "--";
  $lgsl_config['text']['tns'] = "Servers:";
  $lgsl_config['text']['tnp'] = "Players:";
  $lgsl_config['text']['tmp'] = "Max Players:";
  $lgsl_config['text']['asd'] = "Adaugarea serverelor de catre public a fost oprita";
  $lgsl_config['text']['awm'] = "THIS AREA ALLOWS YOU TO TEST AND THEN ADD ONLINE GAME SERVERS TO THE LIST";
  $lgsl_config['text']['ats'] = "Test Server";
  $lgsl_config['text']['aaa'] = "Serverul a fost adaugat trebuie aprobat de un admin";
  $lgsl_config['text']['aan'] = "Serverul exista in baza de date";
  $lgsl_config['text']['anr'] = "Serverul este inchis sau se schimba harta";
  $lgsl_config['text']['ada'] = "Serverul a fost aprobat de admin";
  $lgsl_config['text']['adn'] = "Serverul a fost adaugat";
  $lgsl_config['text']['asc'] = "Serverul este online verifica daca datele sunt corecte";
  $lgsl_config['text']['aas'] = "Adauga Server";
  $lgsl_config['text']['loc'] = "Tara:";
  $lgsl_config['text']['nse'] = "Nu exista servere in baza de date."; // Not exist servers in database
  $lgsl_config['text']['cse'] = "Detalii"; // details
  $lgsl_config['text']['joc'] = "Joc";
  $lgsl_config['text']['mod'] = "Mod";
  $lgsl_config['text']['dns'] = "DNS/IP";    
  $lgsl_config['text']['acs'] = "Nu permite multiplicarea serverelor in baza de date";
  $lgsl_config['text']['sec'] = "Securitate";  
  $lgsl_config['text']['conect']  = "Conectare";
///---------- For English please activate this and close Text up :) or di
  /* 
    $lgsl_config['text']['sec'] = "Security";  
  $lgsl_config['text']['vsd'] = "Click to see details of the server";
  $lgsl_config['text']['slk'] = "Link game";
  $lgsl_config['text']['sts'] = "Status:";
  $lgsl_config['text']['adr'] = "Address:";
  $lgsl_config['text']['cpt'] = "Connection Port:";
  $lgsl_config['text']['qpt'] = "Query Port:";
  $lgsl_config['text']['typ'] = "Type:";
  $lgsl_config['text']['gme'] = "Game";
  $lgsl_config['text']['map'] = "Map:";
  $lgsl_config['text']['plr'] = "Players:";
  $lgsl_config['text']['npi'] = "No players in the server";
  $lgsl_config['text']['nei'] = "NO EXTRA INFO";
  $lgsl_config['text']['ehs'] = "Setting";
  $lgsl_config['text']['ehv'] = "Value";
  $lgsl_config['text']['onl'] = "ONLINE";
  $lgsl_config['text']['onp'] = "ONLINE WITH PASSWORD";
  $lgsl_config['text']['nrs'] = "Server OFFLINE";
  $lgsl_config['text']['pen'] = "WAITING TO BE QUERIED";
  $lgsl_config['text']['zpl'] = "PLAYERS:";
  $lgsl_config['text']['mid'] = "INVALID SERVER ID";
  $lgsl_config['text']['nnm'] = "--";
  $lgsl_config['text']['nmp'] = "--";
  $lgsl_config['text']['tns'] = "Servers:";
  $lgsl_config['text']['tnp'] = "Players:";
  $lgsl_config['text']['tmp'] = "Max Players:";
  $lgsl_config['text']['asd'] = "Adding servers to the public has been stopped";
  $lgsl_config['text']['awm'] = "THIS AREA ALLOWS YOU TO TEST AND THEN ADD ONLINE GAME SERVERS TO THE LIST";
  $lgsl_config['text']['ats'] = "Test Server";
  $lgsl_config['text']['aaa'] = "The server was added to be approved by an admin";
  $lgsl_config['text']['aan'] = "Server exist in database";
  $lgsl_config['text']['anr'] = "The server is turned off or change the map";
  $lgsl_config['text']['ada'] = "The server has been approved by admin";
  $lgsl_config['text']['adn'] = "The server was successfully added";
  $lgsl_config['text']['asc'] = "The server is online check whether the data are correct";
  $lgsl_config['text']['aas'] = "Add Server";
  $lgsl_config['text']['loc'] = "Country:";
  $lgsl_config['text']['nse'] = "No database servers."; // Not exist servers in database
  $lgsl_config['text']['cse'] = "Detalii"; // details
  $lgsl_config['text']['joc'] = "Game:";
  $lgsl_config['text']['mod'] = "Mod";  
  $lgsl_config['text']['acs'] = "Do not allow multiplication of database servers";
  */

//------------------------------------------------------------------------------------------------------------+

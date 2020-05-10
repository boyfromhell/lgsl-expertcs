<?php
/*
 * Dynamic Server Image Status addon for LGSL
 * Copyright (C) 2012 SpiffyTek
 *
 * http://spiffytek.com/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 3 as published by
 * the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */


error_reporting(0);

//------------------------------------------------------------------------------------------------------------+
// SETTINGS

$cache_enable = true; // true/false // Enable/Disable Caching of generated images
$name_type_vertical = true; // false/true // Global default/fallback for printing the Servername verticaly on "Sky" images.

//------------------------------------------------------------------------------------------------------------+
// GET THE LGSL CORE
require_once "lgsl_config.php";
  
require_once "lgsl_class.php";

  
//------------------------------------------------------------------------------------------------------------+
// GET THE SERVER DETAILS AND PREPARE IT FOR DISPLAY
$s = cleaninput($_GET['s']);

if (strpos($s, ":")){
	$is_ip = true;
	$s2 = explode(":", $s, 2);
}
if (strpos($s, "_")){
	$is_ip = true;
	$s2 = explode("_", $s, 2);
}

if ($is_ip){
	$lookup = lgsl_lookup_ip($s2[0], $s2[1]);
	$lgsl_server_id = $lookup['id'];
	if(!$lookup){
		$s2[0] = gethostbyname($s2[0]);
		$lookup = lgsl_lookup_ip($s2[0], $s2[1]);
		$lgsl_server_id = $lookup['id'];
	}
}
else { 
	$lookup = $s; 
	$lgsl_server_id = $s;
}

global $lgsl_server_id;

if($lookup){
	$server = lgsl_query_cached("", "", "", "", "", "sep", $lgsl_server_id);
	$fields = lgsl_sort_fields($server, $fields_show, $fields_hide, $fields_other);
	$server = lgsl_sort_players($server);
	$server = lgsl_sort_extras($server);
	$misc   = lgsl_server_misc($server);
}
if(!$lookup || !$server){
	if(!$is_ip){ error_img("This server does not exist in Database", $s, cleaninput($_GET['type'])); }
	else { error_img("This server does not exist in Database", $s2[0].":".$s2[1], cleaninput($_GET['type'])); }
}

//------------------------------------------------------------------------------------------------------------+
// PREPARE THE IMAGE INFOS
// WHAT BACKGROUND IMAGE WE USE. THE LAYOUT IS "image/<GAMETYPE>/<GAME>_<IMGTYPE>.png"

$type = cleaninput($_GET['type']);
	  if (empty($type)){
	   $type = "normal";
    }

$bgimg = cleaninput($_GET['bg']);
	  if (empty($bgimg)){
	   $bgimg = "{$server['b']['type']}/{$server['s']['game']}";
    }

$bgimg = "image/{$bgimg}_{$type}.png";

// IMAGE CACHE
$cache_file = "image/cache/".$server['b']['ip']."_".$server['b']['c_port']."-".$type;
$cache_time = lgsl_cache_info($lgsl_server_id);
$cache_time_expire = $cache_time[0];
$cache = array("file" => $cache_file, "cache_expire" => $cache_time_expire);

if($cache_enable && file_exists($cache["file"])){
	if((time() - filemtime($cache["file"]) < $lgsl_config['cache_time']) || $server['b']['pending']){
		make_img(false, true, $cache, true);	
	}
}

// CHECK IF BACKGROUND IMAGE EXISTS, IF NOT USE DEFAULT
if (!file_exists($bgimg)) {
    $bgimg = "image/default_{$type}.png";
	if (!file_exists($bgimg)) {
		$bgimg = "image/default.png";
		$type = "INVALID";
	}
}
if($server['disabled'] == 1){
    $bgimg = "image/default_{$type}.png";
	if (!file_exists($bgimg)) {
		$bgimg = "image/default.png";
		$type = "INVALID";
	}
}

//------------------------------------------------------------------------------------------------------------+
// GET THE REQUIRED VARIABLES FROM LGSL
// Rename status "NO RESPONSE" into "OFFLINE"
if ($misc['text_status']=="NO RESPONSE"){
  $misc['text_status'] = "Offline";
}

// Dummies
$string0 = "";
$string1 = "";
$string2 = "";
$string3 = "";
$string4 = "";

// If available; Strip Bots from current player and seperate true/total ammount.
// Currently that only works on Sourcegames or any other game wich defines the bot ammount via "bots" tag in querry.
// There are probably more games wich provide bot ammount info via querry, taged as "bots" or under other name.
// Output format is: Trueplayers (Totalplayers)/Maxplayers
$botinfo = true;
$trueplayers = $server['s']['players'] - $server['e']['bots'];
$slotusage = "{$server['s']['players']}/{$server['s']['playersmax']}";

if(!$server['e']||!$server['e']['bots']||$server['e']['bots']=""){ $botinfo = false; }

if($botinfo){
	$slotusage = "{$trueplayers} ({$server['s']['players']})/{$server['s']['playersmax']}";
}

// And now for real, first we do a little exeption for Left4Dead/2 (and TF2) since they have long mapnames wich would blow out on "small" image type
// as workarround we just remove the "Status" line
if($server['disabled'] == 0){
	if ($server['s']['game']=="left4dead" || $server['s']['game']=="left4dead2" || $server['s']['game']=="tf" && $type=="small"){
	$string0 = $server['s']['name'];
	$string1 = "{$server['b']['ip']}:{$server['b']['c_port']}";
	$string2 = $server['s']['map'];
	$string4 = $slotusage;
	}
	else{
	$string0 = $server['s']['name'];
	$string1 = "{$server['b']['ip']}:{$server['b']['c_port']}";
	$string2 = $server['s']['map'];
	$string3 = $slotusage;
	$string4 = ucfirst(strtolower($misc['text_status']));
	}
}

//------------------------------------------------------------------------------------------------------------+
// DEFINE CREATE IMAGE FROM IMAGE SOURCE

$im = imagecreatefrompng($bgimg);

// MAP
if($server['disabled'] == 1){
$misc['image_map'] = "other/map_no_response.png";
}
$im_map_info = getimagesize($misc['image_map']);
if ($im_map_info[2] == 1) { $im_map = imagecreatefromgif($misc['image_map']);  }
if ($im_map_info[2] == 2) { $im_map = imagecreatefromjpeg($misc['image_map']); }
if ($im_map_info[2] == 3) { $im_map = imagecreatefrompng($misc['image_map']);  }

if($server['disabled'] == 0){
	// GAMEICON
	$im_icon_info = getimagesize($misc['icon_game']);
	if ($im_icon_info[2] == 1) { $im_icon = imagecreatefromgif($misc['icon_game']);  }
	if ($im_icon_info[2] == 2) { $im_icon = imagecreatefromjpeg($misc['icon_game']); }
	if ($im_icon_info[2] == 3) { $im_icon = imagecreatefrompng($misc['icon_game']);  }

	// GEO IP (optional)
	if (file_exists("geoip.inc.php")){
		$geoip = true;
		require_once "geoip.inc.php";
		
		$gi = geoip_open("GeoIP.dat", GEOIP_STANDARD);
		$clookup = geoip_country_code_by_addr($gi, $server['b']['ip']);
		if (empty($clookup)){ $clookup = geoip_country_code_by_name($gi, $server['b']['ip']); }
		$clookup = strtolower($clookup);
		$cimg = "image/_cflag/{$clookup}.png";
		if (!file_exists($cimg)) { $cimg = "image/_cflag/noflag.png"; }
		$cimage_info = getimagesize($cimg);
		$cimage = imagecreatefrompng($cimg);
	}
}

//------------------------------------------------------------------------------------------------------------+
// TEXT COLOR & FORMATING. PLAY WITH IT!
// WE USE 2 FONTS HERE, FIRST IS FOR THE HEADING/SERVERNAME (UTF-8), SECOND IS FOR THE CONTENT SUCH AS CURRENT MAP
$text_font0 = "image/_font/Cyberbas.ttf";

$size0 = 10; //Normal
$size2 = 9; //Small
$size4 = 10; //Sky

$text_font1 = "image/_font/Sansation_Regular.ttf";

$size1 = 10; //Normal
$size3 = 10; //Small
$size5 = 9; //Sky
    
// TEXT SETTINGS    	
if (file_exists("image/color_settings.php")){	include_once "image/color_settings.php";}

// Fallback/default Textcolor
if(!$text_color0){	$text_color0 = ImageColorAllocate($im,255,255,255);}
if(!$text_color1){	$text_color1 = ImageColorAllocate($im,255,255,255);}

// Fallback/default for the Text outline
if (!$txt_outline){
	switch($type){
		case "small":			$txt_outline = false;		break;
		case "normal":			$txt_outline = false;		break;
		case "sky":			$txt_outline = false;		break;
	}
}
 
//------------------------------------------------------------------------------------------------------------+   

//------------------------------------------------------------------------------------------------------------+    
// LOCATIONS/TYPES

switch($type){
	case "normal":
		if ($geoip){ imagecopyresampled($im, $cimage, 265, 5, 0, 0, 16, 11, $cimage_info[0], $cimage_info[1]); } // Country  
		pretty_text_ttf($im,$size0,0,2,15,$text_color0,$text_font0,substr($string0,0,47), $txt_outline); // Servername
		pretty_text_ttf($im,$size1,0,65,45,$text_color0,$text_font1,$string1, $txt_outline); // IP:PORT
		pretty_text_ttf($im,$size1,0,65,63,$text_color0,$text_font1,$string2, $txt_outline); // Map
		pretty_text_ttf($im,$size1,0,292,45,$text_color0,$text_font1,$string3, $txt_outline); // Players
		pretty_text_ttf($im,$size1,0,293,63,$text_color0,$text_font1,$string4, $txt_outline); // Status
	break;
	
	case "small":
		if ($geoip){ imagecopyresampled($im, $cimage, 315, 1, 0, 0, 16, 11, $cimage_info[0], $cimage_info[1]); } // Country
		pretty_text_ttf($im,$size2,0,2,10,$text_color0,$text_font0,substr($string0,0,45), $txt_outline); // Servername
		pretty_text_ttf($im,$size3,0,2,24,$text_color0,$text_font1,$string1, $txt_outline); // IP:Port
		pretty_text_ttf($im,$size3,0,135,24,$text_color0,$text_font1,$string2, $txt_outline); // Map
		pretty_text_ttf($im,$size3,0,240,24,$text_color0,$text_font1,$string3, $txt_outline); // Players
		pretty_text_ttf($im,$size3,0,295,24,$text_color0,$text_font1,$string4, $txt_outline); // Status
	break;
	
	case "sky":
	// DEFINE
		$im_map_width  = 130;
		$im_map_height = 120;
		$im_map_posx   = 35;
		$im_map_posy   = 112;

		$im_icon_width  = 16;
		$im_icon_height = 16;
		$im_icon_posx   = 35;
		$im_icon_posy   = 113;

		imagecopyresampled($im, $im_map, $im_map_posx, $im_map_posy, 0, 0, $im_map_width, $im_map_height, $im_map_info[0], $im_map_info[1]); // Mapimage
		if($server['disabled'] == 0){
			imagecopyresampled($im, $im_icon, $im_icon_posx, $im_icon_posy, 0, 0, $im_icon_width, $im_icon_height, $im_icon_info[0], $im_icon_info[1]); // Gameicon
			if ($geoip){ imagecopyresampled($im, $cimage, $im_icon_posx + 112, $im_icon_posy, 0, 0, 16, 11, $cimage_info[0], $cimage_info[1]); } // Country
		}
		if($name_type_vertical){ pretty_text_ttf($im,$size4,270,5,20,$text_color1,$text_font0,substr($string0,0,28), $txt_outline); } // Servername Vertical
		else{ pretty_text_ttf($im,$size5,0,5,15,$text_color1,$text_font0,substr($string0,0,19), $txt_outline); } // Servername
		pretty_text_ttf($im,$size5,0,27,30,$text_color1,$text_font1,"IP:Port:  ".$string1, $txt_outline); // IP:Port
		pretty_text_ttf($im,$size5,0,35,52,$text_color1,$text_font1,"Harta    :  ".substr($string2,0,19), $txt_outline); // Map
		pretty_text_ttf($im,$size5,0,35,74,$text_color1,$text_font1,"Jucatori:  ".$string3, $txt_outline); // Players
		pretty_text_ttf($im,$size5,0,35,96,$text_color1,$text_font1,"Status :  ".substr($string4,0,19), $txt_outline); // Status
	break;

// WHATEVER HAPPENS, ALWAYS PRINT SOMETHING & HOPE THAT AT LEAST THE DEFAULT IMAGE EXISTS...
	default:
		$text_color0 = ImageColorAllocate($im,0,0,0);
		imagettftext($im,11,0,10,14,$text_color0,$text_font0,$string0);
		imagettftext($im,10,0,10,34,$text_color0,$text_font1,$string1);
		imagettftext($im,10,0,10,54,$text_color0,$text_font1,$string2);
		imagettftext($im,10,0,10,74,$text_color0,$text_font1,$string3);
		imagettftext($im,10,0,10,94,$text_color0,$text_font1,$string4);
	break;
}

//------------------------------------------------------------------------------------------------------------+

//------------------------------------------------------------------------------------------------------------+
// NOW LET THE MAGIC HAPPEN AND PULL ALL THAT INTO AN IMAGE.
make_img($im);

//------------------------------------------------------------------------------------------------------------+
// CUSTOM FUNCTIONS

function pretty_text($im, $fontsize, $x, $y, $string, $color, $outline = false) {
	$black  = imagecolorallocate($bgImg, 0, 0, 0);

	// Black outline
	if($outline){
		imagestring($im, $fontsize, $x - 1, $y - 1, $string, $black);
		imagestring($im, $fontsize, $x - 1, $y, $string, $black);
		imagestring($im, $fontsize, $x - 1, $y + 1, $string, $black);
		imagestring($im, $fontsize, $x, $y - 1, $string, $black);
		imagestring($im, $fontsize, $x, $y + 1, $string, $black);
		imagestring($im, $fontsize, $x + 1, $y - 1, $string, $black);
		imagestring($im, $fontsize, $x + 1, $y, $string, $black);
		imagestring($im, $fontsize, $x + 1, $y + 1, $string, $black);
	}

	// Your text
	imagestring($im, $fontsize, $x, $y, $string, $color);
	return $im;
}


function pretty_text_ttf($im, $fontsize, $angle, $x, $y, $color, $font, $string, $outline = false) {
	$black  = imagecolorallocate($bgImg, 0, 0, 0);

	// Black outline
	if($outline){
		imagettftext($im, $fontsize, $angle, $x - 1, $y - 1, $black, $font, $string);
		imagettftext($im, $fontsize, $angle, $x - 1, $y, $black, $font, $string);
		imagettftext($im, $fontsize, $angle, $x - 1, $y + 1, $black, $font, $string);
		imagettftext($im, $fontsize, $angle, $x, $y - 1, $black, $font, $string);
		imagettftext($im, $fontsize, $angle, $x, $y + 1, $black, $font, $string);
		imagettftext($im, $fontsize, $angle, $x + 1, $y - 1, $black, $font, $string);
		imagettftext($im, $fontsize, $angle, $x + 1, $y, $black, $font, $string);
		imagettftext($im, $fontsize, $angle, $x + 1, $y + 1, $black, $font, $string);
	}

	// Your text
	imagettftext($im, $fontsize, $angle, $x, $y, $color, $font, $string);
	return $im;
}


function lgsl_lookup_ip($ip, $port)
  {
    global $lgsl_config;

    lgsl_database();

    $mysql_query  = "SELECT `id` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `ip`='{$ip}' AND c_port='{$port}' LIMIT 1";
    $mysql_result = mysql_query($mysql_query) or die(mysql_error());
    $mysql_row    = mysql_fetch_array($mysql_result, MYSQL_ASSOC);

    return $mysql_row;
  }
  
  
function error_img($msg, $id, $type){
	if(empty($type)) { $type = "normal"; }
	$bgimg = "image/default_{$type}.png";
	if (!file_exists($bgimg)) {
		$bgimg = "image/default.png";
	}
	
	$im = imagecreatefrompng($bgimg);
	$text_color = ImageColorAllocate($im,255,0,0);
	
	switch($type){
		case "normal":
			imagestring($im,6,2,5,"ERROR! ID/IP: ".$id,$text_color);
			imagestring($im,5,2,20,$msg,$text_color);
		break;
		case "small":
			imagestring($im,6,2,0,"ERROR! ID/IP: ".$id,$text_color);
			imagestring($im,5,2,10,$msg,$text_color);
		break;
		case "sky":
			$misc['image_map'] = "other/map_no_response.jpg";
			$im_map_info = getimagesize($misc['image_map']);
			$im_map = imagecreatefromjpeg($misc['image_map']);
			$im_map_width  = 130;
			$im_map_height = 120;
			$im_map_posx   = 25;
			$im_map_posy   = 112;
		
			imagecopyresampled($im, $im_map, $im_map_posx, $im_map_posy, 0, 0, $im_map_width, $im_map_height, $im_map_info[0], $im_map_info[1]);
			imagestring($im,1,6,28,"ERROR! ID/IP: ".$id,$text_color);
			imagestring($im,1,6,45,$msg,$text_color);
		break;
	}	
	make_img($im);	
}


function make_img($im = false, $cache_on = false, $cache_data = false, $force_cached = false, $format = false){
	header("Content-type: image/png");
	
	if($cache_on && $cache_data["file"]){
		$expire = gmdate("D, d M Y H:i:s", $cache_data["cache_expire"])." GMT";
		//$last = gmdate("D, d M Y H:i:s", filemtime($cache_data["file"]))." GMT";
		
		header("Expires: ".$expire);
		
		if(!$force_cached){ imagepng($im, $cache_data["file"], 9); }
		readfile($cache_data["file"]);
	}
	else{ imagepng($im, null, 9); }
	
	imagedestroy($im);
	exit;
}


function lgsl_cache_info($id){
    global $lgsl_config;

    lgsl_database();
	
	$mysql_query  = "SELECT `cache_time` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `id`='{$id}' LIMIT 1";
    $mysql_result = mysql_query($mysql_query) or die(mysql_error());
    $mysql_row    = mysql_fetch_array($mysql_result, MYSQL_ASSOC);
	
	$cache_time = empty($mysql_row['cache_time']) ? array(0,0,0) : explode("_", $mysql_row['cache_time']);

    return $cache_time;
}


function cleaninput($input){
	$remove = array("#\\\\+#", "#/+#", "#\\+#", "#\s+#", "#http+#", "#ftp+#", "#%00+#", "#\\0+#", "#\\x00+#", "#\(+#", "#\)+#", "#\{+#", "#\}+#");
	// Some rules might be paranoid
	
	$input = preg_replace($remove, "", $input); 
	$input = htmlspecialchars($input, ENT_QUOTES);
	
	return $input;
}
?>
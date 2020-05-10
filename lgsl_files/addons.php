<?php
error_reporting(E_ALL);
// ---------------------------------------------------------+ - +--------------------------------------------------------- \\
if (isset($server['e']['dp_version'])) { $dproto = "<a href='http://dproto.com'>dproto</a> , "; } else { $dproto = "";}
if (isset($server['e']['metamod_version'])) { $metamod = "<a href='http://metamod.org'>Metamod</a> , "; }else { $metamod = "";}
if (isset($server['e']['amxmodx_version'])) { $amxmodx = "<a href='http://amxmodx.org'>AMX Mod X</a> , "; } else {$amxmodx = ""; }
if (isset($server['e']['admin_mod_version'])) { $adminmod = "<a href='http://adminmod.org'>Admin Mod</a> , "; }else { $adminmod = "";}
if (isset($server['e']['csdm_version'])) { $respawn = "<a href='http://bailopan.net/csdm'>CSDM (Respawn)</a> , "; } else {$respawn = "";}
if (isset($server['e']['showip'])) { $showip = "<a href='http://forums.alliedmods.net/showthread.php?p=707549'>ShowIP</a> , ";} 							 else { $showip= "";}
if (isset($server['e']['gal_version'])) { $galileo = "<a href='http://forums.alliedmods.net/showthread.php?t=77391'>Galileo</a> , "; } 							 else { $galileo = "";}
if (isset($server['e']['speclist'])) { $speclist = "<a href='http://forums.alliedmods.net/showthread.php?p=408500'>SpecList</a> , "; } 							 else { $speclist = "";}
if (isset($server['e']['amx_ptb_version'])) { $ptb = "<a href='http://forums.alliedmods.net/showthread.php?t=26598'>PTB</a> , "; }  							 else { $ptb = "";}
if (isset($server['e']['c4 timer'])) { $c4timer = "<a href='http://forums.alliedmods.net/showthread.php?p=483666'>C4 Timer</a> , "; }                            else { $c4timer = "";}
if (isset($server['e']['cfg rank'])) { $cfgrank = "<a href='http://forum.tutorialecstrike.com/index.php?topic=7562.0'>CFG Rank</a> , "; } 						 else { $cfgrank = "";}
if (isset($server['e']['afk_version'])) { $afkkicker = "<a href='http://forums.alliedmods.net/showthread.php?p=2874'>AFK Kicker</a> , "; } 						 else { $afkkicker = "";}
if (isset($server['e']['allchat_version'])) { $allchat = "<a href='http://forums.alliedmods.net/showthread.php?p=493053'>All Chat</a> , "; } else { $allchat= "";}
if (isset($server['e']['aesp_version'])) { $adminesp = "<a href='http://forums.alliedmods.net/showthread.php?t=23691'>Admin-ESP</a> , "; } else {  $adminesp ="";}
if (isset($server['e']['redirect_version'])) { $redirect = "<a href='http://forums.alliedmods.net/showthread.php?t=29886'>xRedirect</a> , "; } else { $redirect = "";}
if (isset($server['e']['admanager_version'])) { $adminsmanager = "<a href='http://forums.alliedmods.net/showthread.php?t=64142'>Admins Manager</a> , "; } else {              $adminsmanager = "";}
if (isset($server['e']['connectsound_version'])) { $connectsound = "<a href='http://forums.alliedmods.net/showthread.php?p=19865'>Connect Sound</a> , "; } else {              $connectsound ="";}
if (isset($server['e']['version_loading_music2'])) { $loadingmusic2 = "<a href='http://forums.alliedmods.net/showthread.php?t=52029'>Loading Music II</a> , "; } else { 	   $loadingmusic2 ="";}
if (isset($server['e']['zp_extra_sawnoff'])) { $sawnoffshotgun = "<a href='https://forums.alliedmods.net/showthread.php?t=99312'>Sawn-OFF Shotgun</a> , "; } else {            $sawnoffshotgun = "";}
if (isset($server['e']['anticfgflood_version'])) { $anticfgflood = "<a href='http://www.extreamcs.com/forum/viewtopic.php?f=29&t=64780'>Anti CFG Flood</a> , "; } else { 	   $anticfgflood= "";}
if (isset($server['e']['amxbans_version'])) { $amxbans = "<a href='http://forum.amxbans.net/viewtopic.php?t=20'>AmxBans</a> ,";}else{$amxbans = "";}
// ---------------------------------------------------------+ - +--------------------------------------------------------- \\
$addons_server = $dproto.$metamod.$amxmodx.$adminmod . $respawn. $showip . $galileo . $speclist . $ptb .$c4timer .$cfgrank.$afkkicker.$allchat.$adminesp.$redirect.$adminsmanager.$connectsound.
$loadingmusic2.$sawnoffshotgun.$anticfgflood.$amxbans;
// ---------------------------------------------------------+ - +--------------------------------------------------------- \\
if (!$addons_server) { $addons_server = "---"; }
// ---------------------------------------------------------+ - +--------------------------------------------------------- \\
?>
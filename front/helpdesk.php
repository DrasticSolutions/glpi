<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2008 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------


$NEEDED_ITEMS=array("user","group","tracking","document","computer","printer","networking","peripheral","monitor","software","infocom","phone","rulesengine","rule.tracking","planning");
define('GLPI_ROOT', '..');
include (GLPI_ROOT . "/inc/includes.php");

checkRight("create_ticket","1");

commonHeader("Helpdesk",$_SERVER['PHP_SELF'],"maintain","helpdesk");

if (isset($_POST["_my_items"])&&!empty($_POST["_my_items"])){
	$splitter=split("_",$_POST["_my_items"]);
	if (count($splitter)==2){
		$_POST["device_type"]=$splitter[0];
		$_POST["computer"]=$splitter[1];
	}
}


if (isset($_GET["device_type"])) $device_type=$_GET["device_type"];
else if (isset($_SESSION["helpdeskSaved"]["device_type"])) $device_type=$_SESSION["helpdeskSaved"]["device_type"];
else $device_type=0;

if (isset($_GET["computer"])) $computer=$_GET["computer"];
else if (isset($_SESSION["helpdeskSaved"]["computer"])) $computer=$_SESSION["helpdeskSaved"]["computer"];
else $computer=0;

if (!isset($_SESSION["helpdeskSaved"]["user"])) $user=$_SESSION["glpiID"];
else $user=$_SESSION["helpdeskSaved"]["user"];

if (!isset($_SESSION["helpdeskSaved"]["FK_group"])) $group=0;
else $group=$_SESSION["helpdeskSaved"]["FK_group"];

if (!isset($_SESSION["helpdeskSaved"]["assign"])) $assign=0;
else $assign=$_SESSION["helpdeskSaved"]["assign"];

if (!isset($_SESSION["helpdeskSaved"]["assign_group"])) $assign_group=0;
else $assign_group=$_SESSION["helpdeskSaved"]["assign_group"];

if (!isset($_SESSION["helpdeskSaved"]["minute"])) $minute=0;
else $minute=$_SESSION["helpdeskSaved"]["minute"];

if (!isset($_SESSION["helpdeskSaved"]["hour"])) $hour=0;
else $hour=$_SESSION["helpdeskSaved"]["hour"];

if (!isset($_SESSION["helpdeskSaved"]["category"])) $category=0;
else $category=$_SESSION["helpdeskSaved"]["category"];

if (!isset($_SESSION["helpdeskSaved"]["priority"])) $priority=3;
else $priority=$_SESSION["helpdeskSaved"]["priority"];

if (!isset($_SESSION["helpdeskSaved"]["request_type"])) $request_type=1;
else $request_type=$_SESSION["helpdeskSaved"]["request_type"];

if (!isset($_SESSION["helpdeskSaved"]["name"])) $name='';
else $name=stripslashes($_SESSION["helpdeskSaved"]["name"]);

if (!isset($_SESSION["helpdeskSaved"]["contents"])) $contents='';
else $contents=stripslashes($_SESSION["helpdeskSaved"]["contents"]);


if (isset($_SESSION["helpdeskSaved"])&&count($_GET)==0){
	unset($_SESSION["helpdeskSaved"]);
}

$track=new Job();

if (isset($_POST["priority"])){
	if ($newID=$track->add($_POST)){
		logEvent($newID, "tracking", 4, "tracking", $_SESSION["glpiname"]." ".$LANG["log"][20]." $newID.");
	}
	glpi_header($_SERVER['HTTP_REFERER']);


} else {
	addFormTracking($device_type,$computer,$_SERVER['PHP_SELF'],$user,$group,$assign,$assign_group,$name,$contents,$category,$priority,$request_type,$hour,$minute);
}


commonFooter();


?>

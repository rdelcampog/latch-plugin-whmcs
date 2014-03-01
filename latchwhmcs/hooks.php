<?php
/**
 * LatchWHMCS Hook(s)
 *
 * This is LatchWHMCS hooks file for the addon module. Shortly, the hook checks a series of values ​​in the addon module database, connects to Latch and finally, destroys the session if Latch status is off. 
 *
 * For more info, see addon documentation @ https://github.com/Korrosivo/latch-plugin-whmcs
 *
 * @package    LatchWHMCS
 * @author     Rubén del Campo <yo@rubendelcampo.es>
 * @copyright  Copyright (c) Rubén del Campo 2014-2015
 * @version    $Id$
 * @link       https://github.com/Korrosivo/latch-plugin-whmcs
 */

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

function latch($vars) {

    $t = "mod_latchwhmcs";
    $c = "user";
    $d = "";
    $q = select_query($t, $c, $d);
    $d = mysql_fetch_array($q);
	$a = $vars['adminid'];
	
	$g = @mysql_query("SELECT * FROM mod_latchwhmcs WHERE adminid = '$a'");
    $sg = mysql_fetch_array($g);
    $aid = $sg['appid'];
    $sec = $sg['secret'];
    $uid = $sg['userid'];
    $xid = $sg['adminid'];

	require_once('inc/latch/Latch.php');
	require_once('inc/latch/LatchResponse.php');
	require_once('inc/latch/Error.php');

	$api = new Latch($aid, $sec);
	
	$res = $api->status($uid);
	
	$dat = $res->getData();
	$err = $res->getError();
	
	if (!empty($dat) && $dat->{"operations"}->{$aid}->{"status"} === "off"){
		session_destroy();
	} 
	
	if (!empty($err)) {
		if ($err->getCode() == 201) {
            $qd = update_query("mod_latchwhmcs", array("userid" => NULL), array("adminid" => $xid));
		}
	}
}

add_hook("AdminLogin",1,"latch","");
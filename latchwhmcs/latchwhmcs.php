<?php
/**
 * LatchWHMCS addon module 
 *
 * For more info, see addon documentation @ https://github.com/Korrosivo/latch-plugin-whmcs
 *
 * @package    LatchWHMCS
 * @author     Rubén del Campo <yo@rubendelcampo.es>
 * @license    GPL v2.1 http://www.gnu.org/licenses/lgpl-2.1.txt
 * @version    $Id$
 * @link       https://github.com/Korrosivo/latch-plugin-whmcs
 */

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

function latchwhmcs_config() {
    $configarray = array(
    "name" => "Latch WHMCS (admin) <span class='label'>beta</span>",
    "description" => "Unofficial WHMCS addon for integrating admin login with Latch (more info about Latch @ <a href='https://latch.elevenpaths.com/'>https://latch.elevenpaths.com/</a>).",
    "version" => "1.0",
    "author" => "Rubén del Campo",
    "language" => "english",
    "fields" => array(
        "appid" => array ("FriendlyName" => "Application ID", "Type" => "text", "Size" => "30", "Description" => "Application ID (obtained after creating an application in <a href='https://latch.elevenpaths.com/www/developerArea'>Developers Area</a>)", ),
        "secret" => array ("FriendlyName" => "Secret key", "Type" => "text", "Size" => "30", "Description" => "Same as above, secret key obtained after creating an application", ),
    ));
    return $configarray;
}

function latchwhmcs_activate() {

    # Create Custom DB Table
    $query = "CREATE TABLE `mod_latchwhmcs` (`key` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`appid` varchar( 100 ) NOT NULL,`secret` varchar( 100 ) NOT NULL,`userid` varchar( 100 ), `adminid` varchar( 2 ) UNIQUE )";
    $result = full_query($query);

    # Return Result
    return array('status'=>'success','description'=>'Latch WHMCS has been successfully installed. Please, go to the add-on page for pairing your account and start using Latch.');
}

function latchwhmcs_deactivate() {

    # Remove Custom DB Table
    $query = "DROP TABLE `mod_latchwhmcs`";
    $result = full_query($query);

    # Return Result
    return array('status'=>'success','description'=>'Latch WHMCS has benn successfully deactivated and your app info, wiped from the WHMCS database.');
}

function latchwhmcs_upgrade($vars) {
    $m_version = $vars['version'];
}

function latchwhmcs_output($vars) {
	
	// $$$ Include variables and styles
	include_once("inc/inc.php");

	// === Div container
	echo($msg_header);

	// ### If AppID or Secret Key not set in config window, show an error
    if (!$cfg_aid OR !$cfg_sec) {
    
    	echo($msg_notconfigured);
    	
    } else {
    
        $q = select_query("mod_latchwhmcs", "userid", "");
        $d = mysql_fetch_array($comp_query);

       	// ### Store AppID and SecretKey set in the config window on WHMCS database
        if (1 === 1) {
            $firstrun = insert_query("mod_latchwhmcs", array("appid" => $cfg_aid, "secret" => $cfg_sec, "adminid" => $g_admin));
		}
		
		$q = @mysql_query("SELECT * FROM mod_latchwhmcs WHERE `adminid` = $g_admin");
        $d = mysql_fetch_array($q);
        
        // $$$ Variables of the data stored in the database.
        $sql_aid = $d['appid'];
        $sql_sec = $d['secret'];
        $sql_uid = $d['userid'];
        $sql_xid = $d['adminid'];
        
        // ### If stored values in database are not the ones in config window, purge database and store values again
        if($sql_aid != $cfg_aid OR $sql_sec != $cfg_sec){
			$q = @mysql_query("DELETE FROM mod_latchwhmcs WHERE appid = '$sql_aid'");
	        $q = insert_query("mod_latchwhmcs", array("appid" => $cfg_aid, "secret" => $cfg_sec, "userid" => NULL));
        }
		
		// ### If pair button pressed, store UserID obtained, in WHMCS database
		if($_POST['pairing']){
			$api = new Latch($sql_aid, $sql_sec);
			$res = $api->pair($_POST['pairing']);
			$dat = $res->getData();
			$err = $res->getError();
			$tuid = $dat->{"accountId"};
            $q = update_query("mod_latchwhmcs", array("userid" => $tuid), array("adminid" => $g_admin));
            echo($msg_proccessing); header("refresh:3;");
            
		}
		
		// ### If unpair button pressed, unpair UserID stored in WHMCS database
        if($_POST['unpair']){
			$api = new Latch($sql_aid, $sql_sec);
			$res = $api->unpair($sql_uid);				
			$dat = $res->getData();
			$err = $res->getError();
            $q = update_query("mod_latchwhmcs", array("userid" => NULL), array("adminid" => $g_admin));
            echo($msg_proccessing); header("refresh:3;");
        } 

		// ### If not UserID defined and not pairing, show pairing screen
		if(!$sql_uid && !$_POST['pairing']){
			echo($msg_pair);
		// ### If UserID defined, not pairing and not unpairing, show unpair screen
		} else if($sql_uid && !$_POST['pairing'] && !$_POST['unpair']){
			echo($msg_unpair);
		}
		
	}
	
	// === Close div container
    echo($msg_footer);

}
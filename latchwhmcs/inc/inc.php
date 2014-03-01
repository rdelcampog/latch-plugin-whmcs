<?php
/**
 * LatchWHMCS includes 
 *
 * For more info, see addon documentation @ https://github.com/Korrosivo/latch-plugin-whmcs
 *
 * @package    LatchWHMCS
 * @author     Rubén del Campo <yo@rubendelcampo.es>
 * @license    GPL v2.1 http://www.gnu.org/licenses/lgpl-2.1.txt
 * @version    $Id$
 * @link       https://github.com/Korrosivo/latch-plugin-whmcs
 */

// $$$ Addon variables
$m_name = "latchwhmcs";
$m_path = "../modules/addons/$m_name";
$m_link = $vars['modulelink'];
$m_version = $vars['version'];
$g_admin = $_SESSION['adminid'];

// $$$ Require Latch SDK
require_once('latch/Latch.php');
require_once('latch/LatchResponse.php');
require_once('latch/Error.php');

// Query to obtain config window variables
$q = @mysql_query("SELECT * FROM tbladdonmodules WHERE module = 'latchwhmcs'");
while ($arr = mysql_fetch_array($q)) {$settings[$arr['setting']] = $arr['value'];}

// $$$ Config window variables
$cfg_aid = $settings['appid'];
$cfg_sec = $settings['secret'];

// $$$ Forms and errors
$msg_header = "<div style='text-align:center;margin:40px auto;display:block;width: 500px;padding: 40px 50px 50px 50px;border-radius: 10px;box-shadow: 0px 0px 25px 0px #DDD;'>";
$msg_footer = "</div>";

$msg_notconfigured = "<img src='$m_path/inc/logo.gif' style='width: 199px;display: block;margin: 15px auto;'><div class='errorbox'><p><strong>Wait a minute, cowboy!</strong></p><p>Before pairing your WHMCS installation with Latch, you need to setup your application ID and secret key in the <a href='configaddonmods.php'>add-on configuration page</a>.</p></div>";

$route = $_SERVER["PHP_SELF"];

$msg_unpair = "<img src='$m_path/inc/logo.gif' style='width: 199px;display: block;margin: 15px auto;'><h1>WHMCS is paired with your Latch app.</h1><form action='$m_link' method='post'><input type='submit' name='unpair' value='Unpair WHMCS' class='btn btn-large btn-danger' style='width: 205px;display: block;font-size: 16px;height: 40px;margin:10px auto;'></form>";

$msg_pair = "<img src='$m_path/inc/logo.gif' style='width: 199px;display: block;margin: 15px auto;'><form action='$m_link' method='post'><h1>Enter your pairing code:</h1><input type='text' name='pairing' maxlength='6' style='width: 200px;font-family: consolas;font-size: 4em;height: 75px;text-align: center;display:block;margin:10px auto;'><input type='submit' value='Pair WHMCS!' class='btn btn-primary' style='width: 205px;display: block;font-size: 16px;height: 40px;margin:10px auto;'></form>";

$msg_proccessing = "<img src='$m_path/inc/logo.gif' style='width: 199px;display: block;margin: 15px auto;'><h1>Communicating with Latch servers.</h1><p>Page will refresh in three seconds.</p><p><a href='$m_link'>Click here</a> to reload page now.</p>";

?>
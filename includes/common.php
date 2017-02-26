<?php
/* 
 * Common.php
 * Loads all common functions and classes
 */
//Include and load config
require("{$root_path}includes/config.{$phpex}");
$config = new config();

//Next include required classes and functions
require("{$root_path}includes/functions.{$phpex}");
require("{$root_path}includes/classes/class.dbal.{$phpex}");
require("{$root_path}includes/classes/class.template.{$phpex}");
require("{$root_path}includes/classes/class.user.{$phpex}");
require("{$root_path}includes/classes/class.website.{$phpex}");
require("{$root_path}includes/constants.{$phpex}");

//Open database connection
$db = new dbal($config->mysql_server, $config->mysql_user, $config->mysql_pass, $config->mysql_db, $config->mysql_port);
//Load settings from Database
$query = "SELECT * FROM " . SETTINGS_TABLE;
$result = $db->query($query);
$ar = $db->fetchall($result);
foreach ($ar as $key => $val)
{
    $config->config[$val['setting_name']] = $val['setting_value'];
}

$script_name = explode('.', basename(str_replace(array('\\', '//'), '/', $_SERVER['PHP_SELF'])));

//Load classes


$template = new template($config->template_dir . '/elegant_black/template/','default');
$mode = request_var('mode', 'home');
$i = request_var('i', null);
//This will be overridden in index.php as only 2 files are used for displaying pages. This part is mainly for modules which have different template files.
$template_file = $script_name[0] . '/' . (($mode != 'home') ? $mode : 'index') . (($i) ? '_' . $i : '') . '.html';

//Load some sitewide variables into the template :)
$template->assign_vars(array(
   'SITE_TITLE' => $config->config['site_title'],
   'SITE_DESCRIPTION' => $config->config['site_desc'],
   'CREDIT_LINE' => "Powered by <a href=\"http://www.hypersite.info\">HyperSite v1.0 &copy;</a>",
   'ALLOW_USER_LOGIN' => $config->config['allow_users'],
));

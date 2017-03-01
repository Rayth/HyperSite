<?php
error_reporting(E_ALL);
$phpex = "php";
$root_path = "./";
require("{$root_path}includes/common.{$phpex}");

$template->assign_vars(array(
   'SCRIPT_NAME' => $script_name[0],
));

switch ($mode)
{
    case 'home':
        //Manually override the template file variable
        $template_file = "{$script_name[0]}/index.html";
        $template->assign_var('INTRO_TEXT', $config->config['site_intro']);
        $query = "SELECT * FROM " . PAGES_TABLE . " WHERE page_identifier='home'";
        $result = $db->query($query);
        $page = $db->fetchrow($result);
        $template->assign_vars(array(
           'PAGE_TITLE' => $page['page_title'],
            'PAGE_TEXT' => $page['page_text']
        ));
    break;
    default:
        //Manually set template file
        $template_file = "{$script_name[0]}/viewpage.html";
        $query = "SELECT * FROM " . PAGES_TABLE . " WHERE page_identifier='{$mode}'";
        $result = $db->query($query);
        $page = $db->fetchrow($result);
        $template->assign_vars(array(
           'PAGE_TITLE' => $page['page_title'],
            'PAGE_TEXT' => $page['page_text']
        ));
    break;
}
$template->set_filenames(array(
    'body' => $template_file
));
$template->display('body');
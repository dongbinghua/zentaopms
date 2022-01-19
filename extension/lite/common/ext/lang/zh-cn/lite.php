<?php
$lang->mainNav->menuOrder = array();

$lang->mainNav->menuOrder[5]  = 'my';
$lang->mainNav->menuOrder[20] = 'project';
$lang->mainNav->menuOrder[35] = 'doc';
$lang->mainNav->menuOrder[45] = 'system';
$lang->mainNav->menuOrder[65] = 'admin';

/* My menu. */
$lang->my->menu           = new stdclass();
$lang->my->menu->index    = array('link' => "$lang->dashboard|my|index");
$lang->my->menu->calendar = array('link' => "$lang->calendar|my|calendar|", 'subModule' => 'todo', 'alias' => 'todo');
$lang->my->menu->task     = array('link' => "{$lang->task->common}|my|contribute|mode=task&type=assignedTo", 'subModule' => 'task');

global $config;
if($config->edition != 'open') $lang->my->menu->effort = array('link' => '日志|effort|calendar|', 'exclude' => 'my-todo');

/* My menu order. */
$lang->my->menuOrder     = array();
$lang->my->menuOrder[5]  = 'index';
$lang->my->menuOrder[10] = 'calendar';
if($config->edition != 'open') $lang->my->menuOrder[15] = 'effort';
$lang->my->menuOrder[20] = 'task';

$lang->my->dividerMenu = ',calendar,';

$lang->project->target = '目标';

/* Scrum menu. */
$lang->scrum->menu            = new stdclass();
$lang->scrum->menu->index     = array('link' => "{$lang->dashboard}|project|index|project=%s");
$lang->scrum->menu->execution = array('link' => "$lang->executionKanban|project|execution|status=all&projectID=%s", 'subModule' => 'kanban');
$lang->scrum->menu->story     = array('link' => "{$lang->project->target}|projectstory|story|projectID=%s", 'subModule' => 'projectstory,tree', 'alias' => 'story,track');
$lang->scrum->menu->doc       = array('link' => "{$lang->doc->common}|doc|tableContents|type=project&objectID=%s", 'subModule' => 'doc');
$lang->scrum->menu->dynamic   = array('link' => "$lang->dynamic|project|dynamic|project=%s");
$lang->scrum->menu->settings  = array('link' => "$lang->settings|project|view|project=%s", 'subModule' => 'stakeholder', 'alias' => 'edit,manageproducts,group,managemembers,manageview,managepriv,whitelist,addwhitelist,team');

$lang->scrum->dividerMenu = ',execution,settings,';

/* Scrum menu order. */
$lang->scrum->menuOrder     = array();
$lang->scrum->menuOrder[5]  = 'index';
$lang->scrum->menuOrder[10] = 'execution';
$lang->scrum->menuOrder[15] = 'story';
$lang->scrum->menuOrder[20] = 'doc';
$lang->scrum->menuOrder[25] = 'dynamic';
$lang->scrum->menuOrder[30] = 'settings';

$lang->execution->menu           = new stdclass();
$lang->execution->menu->kanban   = array('link' => "看板|execution|kanban|executionID=%s");
$lang->execution->menu->list     = array('link' => "列表|execution|task|executionID=%s");
$lang->execution->menu->calendar = array('link' => "日历|execution|calendar|executionID=%s");
$lang->execution->menu->gantt    = array('link' => "甘特图|execution|gantt|executionID=%s");
$lang->execution->menu->tree     = array('link' => "树状图|execution|tree|executionID=%s");
$lang->execution->menu->group    = array('link' => "分组视图|execution|groupTask|executionID=%s");

$lang->scrum->menu->doc['subMenu'] = new stdclass();

$lang->scrum->menu->settings['subMenu']              = new stdclass();
$lang->scrum->menu->settings['subMenu']->view        = array('link' => "$lang->overview|project|view|project=%s", 'alias' => 'edit');
$lang->scrum->menu->settings['subMenu']->members     = array('link' => "{$lang->team->common}|project|team|project=%s", 'alias' => 'managemembers,team');
$lang->scrum->menu->settings['subMenu']->whitelist   = array('link' => "{$lang->whitelist}|project|whitelist|project=%s", 'subModule' => 'personnel');

unset($lang->doc->menu->product);
unset($lang->doc->menu->api);
unset($lang->doc->menu->execution);

$lang->URCommon = '目标';
$lang->SRCommon = '目标';

/* Doc menu. */
$lang->doc->menu            = new stdclass();
$lang->doc->menu->dashboard = array('link' => "{$lang->dashboard}|doc|index");
$lang->doc->menu->recent    = array('link' => "{$lang->doc->recent}|doc|browse|browseTyp=byediteddate", 'alias' => 'recent');
$lang->doc->menu->my        = array('link' => "{$lang->doc->my}|doc|browse|browseTyp=openedbyme", 'alias' => 'my');
$lang->doc->menu->collect   = array('link' => "{$lang->doc->favorite}|doc|browse|browseTyp=collectedbyme", 'alias' => 'collect');
$lang->doc->menu->project   = array('link' => "{$lang->doc->project}|doc|tableContents|type=project", 'alias' => 'showfiles,project');
$lang->doc->menu->custom    = array('link' => "{$lang->doc->custom}|doc|tableContents|type=custom", 'alias' => 'custom');

$lang->doc->dividerMenu = ',project,';

/* Doc menu order. */
$lang->doc->menuOrder     = array();
$lang->doc->menuOrder[5]  = 'dashboard';
$lang->doc->menuOrder[10] = 'recent';
$lang->doc->menuOrder[15] = 'my';
$lang->doc->menuOrder[20] = 'collect';
$lang->doc->menuOrder[25] = 'project';
$lang->doc->menuOrder[30] = 'custom';

$lang->doc->menu->project['subMenu'] = new stdclass();
$lang->doc->menu->custom['subMenu']  = new stdclass();

/* Admin menu. */
$lang->admin->menu            = new stdclass();
$lang->admin->menu->index     = array('link' => "$lang->indexPage|admin|index", 'alias' => 'register,certifytemail,certifyztmobile,ztcompany');
$lang->admin->menu->company   = array('link' => "{$lang->personnel->common}|company|browse|", 'subModule' => ',user,dept,group,');
$lang->admin->menu->custom    = array('link' => "{$lang->custom->common}|custom|index", 'exclude' => 'custom-browsestoryconcept,custom-timezone,custom-estimate');
$lang->admin->menu->extension = array('link' => "{$lang->extension->common}|extension|browse", 'subModule' => 'extension');
$lang->admin->menu->dev       = array('link' => "$lang->redev|dev|api", 'alias' => 'db', 'subModule' => 'dev,editor,entry');
$lang->admin->menu->message   = array('link' => "{$lang->message->common}|message|index", 'subModule' => 'message,mail,webhook');
$lang->admin->menu->system    = array('link' => "{$lang->admin->system}|backup|index", 'subModule' => 'cron,backup,action,admin,search', 'exclude' => 'admin-index,admin-xuanxuan,admin-register,admin-ztcompany');

/* Admin menu order. */
$lang->admin->menuOrder = array();
$lang->admin->menuOrder[5]  = 'index';
$lang->admin->menuOrder[10] = 'company';
$lang->admin->menuOrder[15] = 'custom';
$lang->admin->menuOrder[20] = 'message';
$lang->admin->menuOrder[25] = 'extension';
$lang->admin->menuOrder[30] = 'dev';
$lang->admin->menuOrder[35] = 'system';

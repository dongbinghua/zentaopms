<?php
/**
 * The action module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     action
 * @version     $Id: zh-tw.php 4955 2013-07-02 01:47:21Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->action->common     = '系統日誌';
$lang->action->product    = $lang->productCommon;
$lang->action->project    = $lang->projectCommon;
$lang->action->objectType = '對象類型';
$lang->action->objectID   = '對象ID';
$lang->action->objectName = '對象名稱';
$lang->action->actor      = '操作者';
$lang->action->action     = '動作';
$lang->action->actionID   = '記錄ID';
$lang->action->date       = '日期';
$lang->action->extra      = '附加值';

$lang->action->trash       = '資源回收筒';
$lang->action->undelete    = '還原';
$lang->action->hideOne     = '隱藏';
$lang->action->hideAll     = '全部隱藏';
$lang->action->editComment = '修改備註';
$lang->action->create      = '添加備註';
$lang->action->comment     = '備註';

$lang->action->trashTips      = '提示：為了保證系統的完整性，禪道系統的刪除都是標記刪除。';
$lang->action->textDiff       = '文本格式';
$lang->action->original       = '原始格式';
$lang->action->confirmHideAll = '您確定要全部隱藏這些記錄嗎？';
$lang->action->needEdit       = '要還原%s的名稱或代號已經存在，請編輯更改。';
$lang->action->historyEdit    = '歷史記錄編輯不能為空。';
$lang->action->noDynamic      = '暫時沒有動態。';

$lang->action->history = new stdclass();
$lang->action->history->action = '關聯日誌';
$lang->action->history->field  = '欄位';
$lang->action->history->old    = '舊值';
$lang->action->history->new    = '新值';
$lang->action->history->diff   = '不同';

$lang->action->dynamic = new stdclass();
$lang->action->dynamic->today      = '今天';
$lang->action->dynamic->yesterday  = '昨天';
$lang->action->dynamic->twoDaysAgo = '前天';
$lang->action->dynamic->thisWeek   = '本週';
$lang->action->dynamic->lastWeek   = '上周';
$lang->action->dynamic->thisMonth  = '本月';
$lang->action->dynamic->lastMonth  = '上月';
$lang->action->dynamic->all        = '所有';
$lang->action->dynamic->hidden     = '已隱藏';
$lang->action->dynamic->search     = '搜索';

$lang->action->periods['all']       = $lang->action->dynamic->all;
$lang->action->periods['today']     = $lang->action->dynamic->today;
$lang->action->periods['yesterday'] = $lang->action->dynamic->yesterday;
$lang->action->periods['thisweek']  = $lang->action->dynamic->thisWeek;
$lang->action->periods['lastweek']  = $lang->action->dynamic->lastWeek;
$lang->action->periods['thismonth'] = $lang->action->dynamic->thisMonth;
$lang->action->periods['lastmonth'] = $lang->action->dynamic->lastMonth;

$lang->action->objectTypes['product']     = $lang->productCommon;
$lang->action->objectTypes['story']       = $lang->productSRCommon;
$lang->action->objectTypes['productplan'] = $lang->planCommon;
$lang->action->objectTypes['release']     = '發佈';
$lang->action->objectTypes['program']     = '項目集';
$lang->action->objectTypes['project']     = '項目';
$lang->action->objectTypes['execution']   = $lang->executionCommon;
$lang->action->objectTypes['task']        = '任務';
$lang->action->objectTypes['build']       = '版本';
$lang->action->objectTypes['bug']         = 'Bug';
$lang->action->objectTypes['case']        = '用例';
$lang->action->objectTypes['caseresult']  = '用例結果';
$lang->action->objectTypes['stepresult']  = '用例步驟';
$lang->action->objectTypes['testtask']    = '測試單';
$lang->action->objectTypes['user']        = '用戶';
$lang->action->objectTypes['doc']         = '文檔';
$lang->action->objectTypes['doclib']      = '文檔庫';
$lang->action->objectTypes['todo']        = '待辦';
$lang->action->objectTypes['branch']      = '分支';
$lang->action->objectTypes['module']      = '模組';
$lang->action->objectTypes['testsuite']   = '套件';
$lang->action->objectTypes['caselib']     = '用例庫';
$lang->action->objectTypes['testreport']  = '報告';
$lang->action->objectTypes['entry']       = '應用';
$lang->action->objectTypes['risk']        = '風險';
$lang->action->objectTypes['issue']       = '問題';
$lang->action->objectTypes['design']      = '設計';
$lang->action->objectTypes['stakeholder'] = '干係人';
$lang->action->objectTypes['webhook']     = 'Webhook';

/* 用來描述操作歷史記錄。*/
$lang->action->desc = new stdclass();
$lang->action->desc->common         = '$date, <strong>$action</strong> by <strong>$actor</strong>。' . "\n";
$lang->action->desc->extra          = '$date, <strong>$action</strong> as <strong>$extra</strong> by <strong>$actor</strong>。' . "\n";
$lang->action->desc->opened         = '$date, 由 <strong>$actor</strong> 創建。' . "\n";
$lang->action->desc->created        = '$date, 由 <strong>$actor</strong> 創建。' . "\n";
$lang->action->desc->added          = '$date, 由 <strong>$actor</strong> 添加。' . "\n";
$lang->action->desc->changed        = '$date, 由 <strong>$actor</strong> 變更。' . "\n";
$lang->action->desc->edited         = '$date, 由 <strong>$actor</strong> 編輯。' . "\n";
$lang->action->desc->assigned       = '$date, 由 <strong>$actor</strong> 指派給 <strong>$extra</strong>。' . "\n";
$lang->action->desc->closed         = '$date, 由 <strong>$actor</strong> 關閉。' . "\n";
$lang->action->desc->deleted        = '$date, 由 <strong>$actor</strong> 刪除。' . "\n";
$lang->action->desc->deletedfile    = '$date, 由 <strong>$actor</strong> 刪除了附件：<strong><i>$extra</i></strong>。' . "\n";
$lang->action->desc->editfile       = '$date, 由 <strong>$actor</strong> 編輯了附件：<strong><i>$extra</i></strong>。' . "\n";
$lang->action->desc->erased         = '$date, 由 <strong>$actor</strong> 刪除。' . "\n";
$lang->action->desc->undeleted      = '$date, 由 <strong>$actor</strong> 還原。' . "\n";
$lang->action->desc->hidden         = '$date, 由 <strong>$actor</strong> 隱藏。' . "\n";
$lang->action->desc->commented      = '$date, 由 <strong>$actor</strong> 添加備註。' . "\n";
$lang->action->desc->activated      = '$date, 由 <strong>$actor</strong> 激活。' . "\n";
$lang->action->desc->blocked        = '$date, 由 <strong>$actor</strong> 阻塞。' . "\n";
$lang->action->desc->moved          = '$date, 由 <strong>$actor</strong> 移動，之前為 "$extra"。' . "\n";
$lang->action->desc->confirmed      = '$date, 由 <strong>$actor</strong> 確認' . $lang->productSRCommon . '變動，最新版本為<strong>#$extra</strong>。' . "\n";
$lang->action->desc->caseconfirmed  = '$date, 由 <strong>$actor</strong> 確認用例變動，最新版本為<strong>#$extra</strong>。' . "\n";
$lang->action->desc->bugconfirmed   = '$date, 由 <strong>$actor</strong> 確認Bug。' . "\n";
$lang->action->desc->frombug        = '$date, 由 <strong>$actor</strong> Bug轉化而來，Bug編號為 <strong>$extra</strong>。';
$lang->action->desc->started        = '$date, 由 <strong>$actor</strong> 啟動。' . "\n";
$lang->action->desc->restarted      = '$date, 由 <strong>$actor</strong> 繼續。' . "\n";
$lang->action->desc->delayed        = '$date, 由 <strong>$actor</strong> 延期。' . "\n";
$lang->action->desc->suspended      = '$date, 由 <strong>$actor</strong> 掛起。' . "\n";
$lang->action->desc->recordestimate = '$date, 由 <strong>$actor</strong> 記錄工時，消耗 <strong>$extra</strong> 小時。';
$lang->action->desc->editestimate   = '$date, 由 <strong>$actor</strong> 編輯工時。';
$lang->action->desc->deleteestimate = '$date, 由 <strong>$actor</strong> 刪除工時。';
$lang->action->desc->canceled       = '$date, 由 <strong>$actor</strong> 取消。' . "\n";
$lang->action->desc->svncommited    = '$date, 由 <strong>$actor</strong> 提交代碼，版本為<strong>#$extra</strong>。' . "\n";
$lang->action->desc->gitcommited    = '$date, 由 <strong>$actor</strong> 提交代碼，版本為<strong>#$extra</strong>。' . "\n";
$lang->action->desc->finished       = '$date, 由 <strong>$actor</strong> 完成。' . "\n";
$lang->action->desc->paused         = '$date, 由 <strong>$actor</strong> 暫停。' . "\n";
$lang->action->desc->verified       = '$date, 由 <strong>$actor</strong> 驗收。' . "\n";
$lang->action->desc->diff1          = '修改了 <strong><i>%s</i></strong>，舊值為 "%s"，新值為 "%s"。<br />' . "\n";
$lang->action->desc->diff2          = '修改了 <strong><i>%s</i></strong>，區別為：' . "\n" . "<blockquote class='textdiff'>%s</blockquote>" . "\n<blockquote class='original'>%s</blockquote>";
$lang->action->desc->diff3          = '將檔案名 %s 改為 %s 。' . "\n";
$lang->action->desc->linked2bug     = '$date 由 <strong>$actor</strong> 關聯到版本 <strong>$extra</strong>';
$lang->action->desc->resolved       = '$date, 由 <strong>$actor</strong> 解決。' . "\n";

/* 用來描述和父子任務相關的操作歷史記錄。*/
$lang->action->desc->createchildren     = '$date, 由 <strong>$actor</strong> 創建子任務 <strong>$extra</strong>。' . "\n";
$lang->action->desc->linkchildtask      = '$date, 由 <strong>$actor</strong> 關聯子任務 <strong>$extra</strong>。' . "\n";
$lang->action->desc->unlinkchildrentask = '$date, 由 <strong>$actor</strong> 移除子任務 <strong>$extra</strong>。' . "\n";
$lang->action->desc->linkparenttask     = '$date, 由 <strong>$actor</strong> 關聯到父任務 <strong>$extra</strong>。' . "\n";
$lang->action->desc->unlinkparenttask   = '$date, 由 <strong>$actor</strong> 從父任務<strong>$extra</strong>取消關聯。' . "\n";
$lang->action->desc->deletechildrentask = '$date, 由 <strong>$actor</strong> 刪除子任務<strong>$extra</strong>。' . "\n";

/* 用來描述和父子需求相關的操作歷史記錄。*/
$lang->action->desc->createchildrenstory = '$date, 由 <strong>$actor</strong> 創建子需求 <strong>$extra</strong>。' . "\n";
$lang->action->desc->linkchildstory      = '$date, 由 <strong>$actor</strong> 關聯子需求 <strong>$extra</strong>。' . "\n";
$lang->action->desc->unlinkchildrenstory = '$date, 由 <strong>$actor</strong> 移除子需求 <strong>$extra</strong>。' . "\n";
$lang->action->desc->linkparentstory     = '$date, 由 <strong>$actor</strong> 關聯到父需求 <strong>$extra</strong>。' . "\n";
$lang->action->desc->unlinkparentstory   = '$date, 由 <strong>$actor</strong> 從父需求<strong>$extra</strong>取消關聯。' . "\n";
$lang->action->desc->deletechildrenstory = '$date, 由 <strong>$actor</strong> 刪除子需求<strong>$extra</strong>。' . "\n";

/* 關聯用例和移除用例時的歷史操作記錄。*/
$lang->action->desc->linkrelatedcase   = '$date, 由 <strong>$actor</strong> 關聯相關用例 <strong>$extra</strong>。' . "\n";
$lang->action->desc->unlinkrelatedcase = '$date, 由 <strong>$actor</strong> 移除相關用例 <strong>$extra</strong>。' . "\n";

/* 用來顯示動態信息。*/
$lang->action->label = new stdclass();
$lang->action->label->created             = '創建';
$lang->action->label->opened              = '創建';
$lang->action->label->added               = '添加';
$lang->action->label->changed             = '變更了';
$lang->action->label->edited              = '編輯了';
$lang->action->label->assigned            = '指派了';
$lang->action->label->closed              = '關閉了';
$lang->action->label->deleted             = '刪除了';
$lang->action->label->deletedfile         = '刪除附件';
$lang->action->label->editfile            = '編輯附件';
$lang->action->label->erased              = '刪除了';
$lang->action->label->undeleted           = '還原了';
$lang->action->label->hidden              = '隱藏了';
$lang->action->label->commented           = '評論了';
$lang->action->label->communicated        = '溝通了';
$lang->action->label->activated           = '激活了';
$lang->action->label->blocked             = '阻塞了';
$lang->action->label->resolved            = '解決了';
$lang->action->label->reviewed            = '評審了';
$lang->action->label->moved               = '移動了';
$lang->action->label->confirmed           = "確認了{$lang->productSRCommon}";
$lang->action->label->bugconfirmed        = '確認了';
$lang->action->label->tostory             = "轉{$lang->productSRCommon}";
$lang->action->label->frombug             = "轉{$lang->productSRCommon}";
$lang->action->label->fromlib             = '從用例庫導入';
$lang->action->label->totask              = '轉任務';
$lang->action->label->svncommited         = '提交代碼';
$lang->action->label->gitcommited         = '提交代碼';
$lang->action->label->linked2plan         = "關聯{$lang->planCommon}";
$lang->action->label->unlinkedfromplan    = "移除{$lang->planCommon}";
$lang->action->label->changestatus        = '修改狀態';
$lang->action->label->marked              = '編輯了';
$lang->action->label->linked2project      = "關聯{$lang->projectCommon}";
$lang->action->label->unlinkedfromproject = "移除{$lang->projectCommon}";
$lang->action->label->unlinkedfrombuild   = "移除版本";
$lang->action->label->linked2release      = "關聯發佈";
$lang->action->label->unlinkedfromrelease = "移除發佈";
$lang->action->label->linkrelatedbug      = "關聯了相關Bug";
$lang->action->label->unlinkrelatedbug    = "移除了相關Bug";
$lang->action->label->linkrelatedcase     = "關聯了相關用例";
$lang->action->label->unlinkrelatedcase   = "移除了相關用例";
$lang->action->label->linkrelatedstory    = "關聯了相關{$lang->productSRCommon}";
$lang->action->label->unlinkrelatedstory  = "移除了相關{$lang->productSRCommon}";
$lang->action->label->subdividestory      = "細分了{$lang->productSRCommon}";
$lang->action->label->unlinkchildstory    = "移除了細分{$lang->productSRCommon}";
$lang->action->label->started             = '開始了';
$lang->action->label->restarted           = '繼續了';
$lang->action->label->recordestimate      = '記錄了工時';
$lang->action->label->editestimate        = '編輯了工時';
$lang->action->label->canceled            = '取消了';
$lang->action->label->finished            = '完成了';
$lang->action->label->paused              = '暫停了';
$lang->action->label->verified            = '驗收了';
$lang->action->label->delayed             = '延期';
$lang->action->label->suspended           = '掛起';
$lang->action->label->login               = '登錄系統';
$lang->action->label->logout              = "退出登錄";
$lang->action->label->deleteestimate      = "刪除了工時";
$lang->action->label->linked2build        = "關聯了";
$lang->action->label->linked2bug          = "關聯了";
$lang->action->label->linkchildtask       = "關聯子任務";
$lang->action->label->unlinkchildrentask  = "取消關聯子任務";
$lang->action->label->linkparenttask      = "關聯到父任務";
$lang->action->label->unlinkparenttask    = "從父任務取消關聯";
$lang->action->label->batchcreate         = "批量創建任務";
$lang->action->label->createchildren      = "創建子任務";
$lang->action->label->managed             = "維護";
$lang->action->label->deletechildrentask  = "刪除子任務";
$lang->action->label->createchildrenstory = "創建子需求";
$lang->action->label->linkchildstory      = "關聯子需求";
$lang->action->label->unlinkchildrenstory = "取消關聯子需求";
$lang->action->label->linkparentstory     = "關聯到父需求";
$lang->action->label->unlinkparentstory   = "從父需求取消關聯";
$lang->action->label->deletechildrenstory = "刪除子需求";
$lang->action->label->tracked             = '跟蹤了';
$lang->action->label->hangup              = '掛起了';

/* 動態信息按照對象分組 */
$lang->action->dynamicAction = new stdclass();
$lang->action->dynamicAction->todo['opened']               = '創建待辦';
$lang->action->dynamicAction->todo['edited']               = '編輯待辦';
$lang->action->dynamicAction->todo['erased']               = '刪除待辦';
$lang->action->dynamicAction->todo['finished']             = '完成待辦';
$lang->action->dynamicAction->todo['activated']            = '激活待辦';
$lang->action->dynamicAction->todo['closed']               = '關閉待辦';
$lang->action->dynamicAction->todo['assigned']             = '指派待辦';
$lang->action->dynamicAction->todo['undeleted']            = '還原待辦';
$lang->action->dynamicAction->todo['hidden']               = '隱藏待辦';

$lang->action->dynamicAction->program['PGMCreate']         = '創建項目集';
$lang->action->dynamicAction->program['PGMEdit']           = '編輯項目集';
$lang->action->dynamicAction->program['PGMActivate']       = '激活項目集';
$lang->action->dynamicAction->program['PGMDelete']         = '刪除項目集';
$lang->action->dynamicAction->program['PGMClose']          = '關閉項目集';
$lang->action->dynamicAction->program['PRJCreate']         = '創建項目';
$lang->action->dynamicAction->program['PRJEdit']           = '編輯項目';
$lang->action->dynamicAction->program['PRJStart']          = '開始項目';
$lang->action->dynamicAction->program['PRJSuspend']        = '延期項目';
$lang->action->dynamicAction->program['PRJActivate']       = '激活項目';
$lang->action->dynamicAction->program['PRJClose']          = '關閉項目';

$lang->action->dynamicAction->product['opened']            = '創建' . $lang->productCommon;
$lang->action->dynamicAction->product['edited']            = '編輯' . $lang->productCommon;
$lang->action->dynamicAction->product['deleted']           = '刪除' . $lang->productCommon;
$lang->action->dynamicAction->product['closed']            = '關閉' . $lang->productCommon;
$lang->action->dynamicAction->product['undeleted']         = '還原' . $lang->productCommon;
$lang->action->dynamicAction->product['hidden']            = '隱藏' . $lang->productCommon;
$lang->action->dynamicAction->productplan['opened']        = "創建{$lang->planCommon}";
$lang->action->dynamicAction->productplan['edited']        = "編輯{$lang->planCommon}";
$lang->action->dynamicAction->release['opened']            = '創建發佈';
$lang->action->dynamicAction->release['edited']            = '編輯發佈';
$lang->action->dynamicAction->release['changestatus']      = '修改發佈狀態';
$lang->action->dynamicAction->release['undeleted']         = '還原發佈';
$lang->action->dynamicAction->release['hidden']            = '隱藏發佈';
$lang->action->dynamicAction->story['opened']              = "創建{$lang->productSRCommon}";
$lang->action->dynamicAction->story['edited']              = "編輯{$lang->productSRCommon}";
$lang->action->dynamicAction->story['activated']           = "激活{$lang->productSRCommon}";
$lang->action->dynamicAction->story['reviewed']            = "評審{$lang->productSRCommon}";
$lang->action->dynamicAction->story['closed']              = "關閉{$lang->productSRCommon}";
$lang->action->dynamicAction->story['assigned']            = "指派{$lang->productSRCommon}";
$lang->action->dynamicAction->story['changed']             = "變更{$lang->productSRCommon}";
$lang->action->dynamicAction->story['linked2plan']         = "{$lang->productSRCommon}關聯{$lang->planCommon}";
$lang->action->dynamicAction->story['unlinkedfromplan']    = "{$lang->planCommon}移除{$lang->productSRCommon}";
$lang->action->dynamicAction->story['linked2release']      = "{$lang->productSRCommon}關聯發佈";
$lang->action->dynamicAction->story['unlinkedfromrelease'] = "發佈移除{$lang->productSRCommon}";
$lang->action->dynamicAction->story['linked2build']        = "{$lang->productSRCommon}關聯版本";
$lang->action->dynamicAction->story['unlinkedfrombuild']   = "版本移除{$lang->productSRCommon}";
$lang->action->dynamicAction->story['unlinkedfromproject'] = '移除項目';
$lang->action->dynamicAction->story['undeleted']           = "還原{$lang->productSRCommon}";
$lang->action->dynamicAction->story['hidden']              = "隱藏{$lang->productSRCommon}";

$lang->action->dynamicAction->project['opened']            = '創建' . $lang->projectCommon;
$lang->action->dynamicAction->project['edited']            = '編輯' . $lang->projectCommon;
$lang->action->dynamicAction->project['deleted']           = '刪除' . $lang->projectCommon;
$lang->action->dynamicAction->project['started']           = '開始' . $lang->projectCommon;
$lang->action->dynamicAction->project['delayed']           = '延期' . $lang->projectCommon;
$lang->action->dynamicAction->project['suspended']         = '掛起' . $lang->projectCommon;
$lang->action->dynamicAction->project['activated']         = '激活' . $lang->projectCommon;
$lang->action->dynamicAction->project['closed']            = '關閉' . $lang->projectCommon;
$lang->action->dynamicAction->project['managed']           = '維護' . $lang->projectCommon;
$lang->action->dynamicAction->project['undeleted']         = '還原' . $lang->projectCommon;
$lang->action->dynamicAction->project['hidden']            = '隱藏' . $lang->projectCommon;
$lang->action->dynamicAction->project['moved']             = '導入任務';
$lang->action->dynamicAction->task['opened']               = '創建任務';
$lang->action->dynamicAction->task['edited']               = '編輯任務';
$lang->action->dynamicAction->task['commented']            = '備註任務';
$lang->action->dynamicAction->task['assigned']             = '指派任務';
$lang->action->dynamicAction->task['confirmed']            = "確認{$lang->productSRCommon}變更";
$lang->action->dynamicAction->task['started']              = '開始任務';
$lang->action->dynamicAction->task['finished']             = '完成任務';
$lang->action->dynamicAction->task['recordestimate']       = '記錄工時';
$lang->action->dynamicAction->task['editestimate']         = '編輯工時';
$lang->action->dynamicAction->task['deleteestimate']       = '刪除工時';
$lang->action->dynamicAction->task['paused']               = '暫停任務';
$lang->action->dynamicAction->task['closed']               = '關閉任務';
$lang->action->dynamicAction->task['canceled']             = '取消任務';
$lang->action->dynamicAction->task['activated']            = '激活任務';
$lang->action->dynamicAction->task['createchildren']       = '創建子任務';
$lang->action->dynamicAction->task['unlinkparenttask']     = '從父任務取消關聯';
$lang->action->dynamicAction->task['deletechildrentask']   = '刪除子任務';
$lang->action->dynamicAction->task['linkparenttask']       = '關聯到父任務';
$lang->action->dynamicAction->task['linkchildtask']        = '關聯子任務';
$lang->action->dynamicAction->task['createchildrenstory']  = '創建子需求';
$lang->action->dynamicAction->task['unlinkparentstory']    = '從父需求取消關聯';
$lang->action->dynamicAction->task['deletechildrenstory']  = '刪除子需求';
$lang->action->dynamicAction->task['linkparentstory']      = '關聯到父需求';
$lang->action->dynamicAction->task['linkchildstory']       = '關聯子需求';
$lang->action->dynamicAction->task['undeleted']            = '還原任務';
$lang->action->dynamicAction->task['hidden']               = '隱藏任務';
$lang->action->dynamicAction->task['svncommited']          = 'SVN提交';
$lang->action->dynamicAction->task['gitcommited']          = 'GIT提交';
$lang->action->dynamicAction->build['opened']              = '創建版本';
$lang->action->dynamicAction->build['edited']              = '編輯版本';

$lang->action->dynamicAction->bug['opened']                = '創建Bug';
$lang->action->dynamicAction->bug['edited']                = '編輯Bug';
$lang->action->dynamicAction->bug['activated']             = '激活Bug';
$lang->action->dynamicAction->bug['assigned']              = '指派Bug';
$lang->action->dynamicAction->bug['closed']                = '關閉Bug';
$lang->action->dynamicAction->bug['bugconfirmed']          = '確認Bug';
$lang->action->dynamicAction->bug['resolved']              = '解決Bug';
$lang->action->dynamicAction->bug['undeleted']             = '還原Bug';
$lang->action->dynamicAction->bug['hidden']                = '隱藏Bug';
$lang->action->dynamicAction->bug['deleted']               = '刪除Bug';
$lang->action->dynamicAction->bug['confirmed']             = "確認{$lang->productSRCommon}變更";
$lang->action->dynamicAction->bug['tostory']               = "轉{$lang->productSRCommon}";
$lang->action->dynamicAction->bug['totask']                = '轉任務';
$lang->action->dynamicAction->bug['linked2plan']           = "Bug關聯{$lang->planCommon}";
$lang->action->dynamicAction->bug['unlinkedfromplan']      = "{$lang->planCommon}移除Bug";
$lang->action->dynamicAction->bug['linked2release']        = 'Bug關聯發佈';
$lang->action->dynamicAction->bug['unlinkedfromrelease']   = '發佈移除Bug';
$lang->action->dynamicAction->bug['linked2bug']            = 'Bug關聯版本';
$lang->action->dynamicAction->bug['unlinkedfrombuild']     = '版本移除Bug';
$lang->action->dynamicAction->testtask['opened']           = '創建測試單';
$lang->action->dynamicAction->testtask['edited']           = '編輯測試單';
$lang->action->dynamicAction->testtask['started']          = '啟動測試單';
$lang->action->dynamicAction->testtask['activated']        = '激活測試單';
$lang->action->dynamicAction->testtask['closed']           = '完成測試單';
$lang->action->dynamicAction->testtask['blocked']          = '阻塞測試單';
$lang->action->dynamicAction->case['opened']               = '創建用例';
$lang->action->dynamicAction->case['edited']               = '編輯用例';
$lang->action->dynamicAction->case['deleted']              = '刪除用例';
$lang->action->dynamicAction->case['undeleted']            = '還原用例';
$lang->action->dynamicAction->case['hidden']               = '隱藏用例';
$lang->action->dynamicAction->case['reviewed']             = '評審用例';
$lang->action->dynamicAction->case['confirmed']            = "確認{$lang->productSRCommon}變更";
$lang->action->dynamicAction->case['fromlib']              = '從用例庫導入';
$lang->action->dynamicAction->testreport['opened']         = '創建測試報告';
$lang->action->dynamicAction->testreport['edited']         = '編輯測試報告';
$lang->action->dynamicAction->testreport['deleted']        = '刪除測試報告';
$lang->action->dynamicAction->testreport['undeleted']      = '還原測試報告';
$lang->action->dynamicAction->testreport['hidden']         = '隱藏測試報告';
$lang->action->dynamicAction->testsuite['opened']          = '創建測試套件';
$lang->action->dynamicAction->testsuite['edited']          = '編輯測試套件';
$lang->action->dynamicAction->testsuite['deleted']         = '刪除測試套件';
$lang->action->dynamicAction->testsuite['undeleted']       = '還原測試套件';
$lang->action->dynamicAction->testsuite['hidden']          = '隱藏測試套件';
$lang->action->dynamicAction->caselib['opened']            = '創建用例庫';
$lang->action->dynamicAction->caselib['edited']            = '編輯用例庫';
$lang->action->dynamicAction->caselib['deleted']           = '刪除用例庫';
$lang->action->dynamicAction->caselib['undeleted']         = '還原用例庫';
$lang->action->dynamicAction->caselib['hidden']            = '隱藏用例庫';

$lang->action->dynamicAction->doclib['created']            = '創建文檔庫';
$lang->action->dynamicAction->doclib['edited']             = '編輯文檔庫';
$lang->action->dynamicAction->doc['created']               = '創建文檔';
$lang->action->dynamicAction->doc['edited']                = '編輯文檔';
$lang->action->dynamicAction->doc['commented']             = '備註文檔';
$lang->action->dynamicAction->doc['deleted']               = '刪除文檔';
$lang->action->dynamicAction->doc['undeleted']             = '還原文檔';
$lang->action->dynamicAction->doc['hidden']                = '隱藏文檔';

$lang->action->dynamicAction->user['created']              = '創建用戶';
$lang->action->dynamicAction->user['edited']               = '編輯用戶';
$lang->action->dynamicAction->user['login']                = '用戶登錄';
$lang->action->dynamicAction->user['logout']               = '用戶退出';
$lang->action->dynamicAction->user['undeleted']            = '還原用戶';
$lang->action->dynamicAction->user['hidden']               = '隱藏用戶';
$lang->action->dynamicAction->user['loginxuanxuan']        = '登錄客戶端';

$lang->action->dynamicAction->entry['created']             = '添加應用';
$lang->action->dynamicAction->entry['edited']              = '編輯應用';

/* 用來生成相應對象的連結。*/
$lang->action->label->product     = $lang->productCommon . '|product|view|productID=%s';
$lang->action->label->productplan = "{$lang->planCommon}|productplan|view|productID=%s";
$lang->action->label->release     = '發佈|release|view|productID=%s';
$lang->action->label->story       = "{$lang->productSRCommon}|story|view|storyID=%s";
$lang->action->label->program     = "項目集|program|pgmproduct|programID=%s";
$lang->action->label->project     = "項目|program|index|projectID=%s";
$lang->action->label->execution   = "執行|project|task|projectID=%s";
$lang->action->label->task        = '任務|task|view|taskID=%s';
$lang->action->label->build       = '版本|build|view|buildID=%s';
$lang->action->label->bug         = 'Bug|bug|view|bugID=%s';
$lang->action->label->case        = '用例|testcase|view|caseID=%s';
$lang->action->label->testtask    = '測試單|testtask|view|caseID=%s';
$lang->action->label->testsuite   = '測試套件|testsuite|view|suiteID=%s';
$lang->action->label->caselib     = '用例庫|caselib|view|libID=%s';
$lang->action->label->todo        = '待辦|todo|view|todoID=%s';
$lang->action->label->doclib      = '文檔庫|doc|browse|libID=%s';
$lang->action->label->doc         = '文檔|doc|view|docID=%s';
$lang->action->label->user        = '用戶|user|view|account=%s';
$lang->action->label->testreport  = '報告|testreport|view|report=%s';
$lang->action->label->entry       = '應用|entry|browse|';
$lang->action->label->webhook     = 'Webhook|webhook|browse|';
$lang->action->label->space       = ' ';
$lang->action->label->risk        = '風險|risk|view|riskID=%s';
$lang->action->label->issue       = '問題|issue|view|issueID=%s';
$lang->action->label->design      = '設計|design|view|designID=%s';
$lang->action->label->stakeholder = '干係人|stakeholder|view|userID=%s';

/* Object type. */
$lang->action->search->objectTypeList['']            = '';
$lang->action->search->objectTypeList['product']     = $lang->productCommon;
$lang->action->search->objectTypeList['program']     = '項目';
$lang->action->search->objectTypeList['project']     = $lang->projectCommon;
$lang->action->search->objectTypeList['bug']         = 'Bug';
$lang->action->search->objectTypeList['case']        = '用例';
$lang->action->search->objectTypeList['caseresult']  = '用例結果';
$lang->action->search->objectTypeList['stepresult']  = '用例步驟';
$lang->action->search->objectTypeList['story']       = $lang->productSRCommon;
$lang->action->search->objectTypeList['task']        = '任務';
$lang->action->search->objectTypeList['testtask']    = '測試單';
$lang->action->search->objectTypeList['user']        = '用戶';
$lang->action->search->objectTypeList['doc']         = '文檔';
$lang->action->search->objectTypeList['doclib']      = '文檔庫';
$lang->action->search->objectTypeList['todo']        = '待辦';
$lang->action->search->objectTypeList['build']       = '版本';
$lang->action->search->objectTypeList['release']     = '發佈';
$lang->action->search->objectTypeList['productplan'] = $lang->planCommon;
$lang->action->search->objectTypeList['branch']      = '分支';
$lang->action->search->objectTypeList['testsuite']   = '套件';
$lang->action->search->objectTypeList['caselib']     = '公共庫';
$lang->action->search->objectTypeList['testreport']  = '報告';

/* 用來在動態顯示中顯示動作 */
$lang->action->search->label['']                    = '';
$lang->action->search->label['created']             = $lang->action->label->created;
$lang->action->search->label['opened']              = $lang->action->label->opened;
$lang->action->search->label['changed']             = $lang->action->label->changed;
$lang->action->search->label['edited']              = $lang->action->label->edited;
$lang->action->search->label['assigned']            = $lang->action->label->assigned;
$lang->action->search->label['closed']              = $lang->action->label->closed;
$lang->action->search->label['deleted']             = $lang->action->label->deleted;
$lang->action->search->label['deletedfile']         = $lang->action->label->deletedfile;
$lang->action->search->label['editfile']            = $lang->action->label->editfile;
$lang->action->search->label['erased']              = $lang->action->label->erased;
$lang->action->search->label['undeleted']           = $lang->action->label->undeleted;
$lang->action->search->label['hidden']              = $lang->action->label->hidden;
$lang->action->search->label['commented']           = $lang->action->label->commented;
$lang->action->search->label['activated']           = $lang->action->label->activated;
$lang->action->search->label['blocked']             = $lang->action->label->blocked;
$lang->action->search->label['resolved']            = $lang->action->label->resolved;
$lang->action->search->label['reviewed']            = $lang->action->label->reviewed;
$lang->action->search->label['moved']               = $lang->action->label->moved;
$lang->action->search->label['confirmed']           = $lang->action->label->confirmed;
$lang->action->search->label['bugconfirmed']        = $lang->action->label->bugconfirmed;
$lang->action->search->label['tostory']             = $lang->action->label->tostory;
$lang->action->search->label['frombug']             = $lang->action->label->frombug;
$lang->action->search->label['totask']              = $lang->action->label->totask;
$lang->action->search->label['svncommited']         = $lang->action->label->svncommited;
$lang->action->search->label['gitcommited']         = $lang->action->label->gitcommited;
$lang->action->search->label['linked2plan']         = $lang->action->label->linked2plan;
$lang->action->search->label['unlinkedfromplan']    = $lang->action->label->unlinkedfromplan;
$lang->action->search->label['changestatus']        = $lang->action->label->changestatus;
$lang->action->search->label['marked']              = $lang->action->label->marked;
$lang->action->search->label['linked2project']      = $lang->action->label->linked2project;
$lang->action->search->label['unlinkedfromproject'] = $lang->action->label->unlinkedfromproject;
$lang->action->search->label['started']             = $lang->action->label->started;
$lang->action->search->label['restarted']           = $lang->action->label->restarted;
$lang->action->search->label['recordestimate']      = $lang->action->label->recordestimate;
$lang->action->search->label['editestimate']        = $lang->action->label->editestimate;
$lang->action->search->label['canceled']            = $lang->action->label->canceled;
$lang->action->search->label['finished']            = $lang->action->label->finished;
$lang->action->search->label['paused']              = $lang->action->label->paused;
$lang->action->search->label['verified']            = $lang->action->label->verified;
$lang->action->search->label['login']               = $lang->action->label->login;
$lang->action->search->label['logout']              = $lang->action->label->logout;

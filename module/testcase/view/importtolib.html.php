<?php
/**
 * The importfromlib view file of testcase module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     testcase
 * @version     $Id
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id='mainContent'>
  <div class='center-block'>
    <div class='main-header'>
      <h2>
        <small> <?php echo $lang->testcase->importToLib;?></small>
      </div>
    </div>
    <form id='libs' method='post' target='hiddenwin'>
      <table class='table table-form'>
        <tr>
          <td class='select-lib'><?php echo $lang->testcase->selectLibAB;?></td>
          <td class='required'><?php echo html::select('lib', $libraries, '', "class='form-control chosen' id='lib'");?></td>
        </tr>
        <tr>
          <td colspan='2' class='text-center'><?php echo html::submitButton($lang->testcase->import);?></td>
        </tr>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>

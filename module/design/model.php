<?php
/**
 * The model file of design module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Shujie Tian <tianshujie@easycorp.ltd>
 * @package     design
 * @version     $Id: model.php 5107 2020-09-02 09:46:12Z tianshujie@easycorp.ltd $
 * @link        http://www.zentao.net
 */
?>
<?php
class designModel extends model
{
    /**
     * Create a design.
     *
     * @param  int    $projectID
     * @access public
     * @return void
     */
    public function create($projectID)
    {
        $design = fixer::input('post')
            ->stripTags('desc', $this->config->allowedTags)
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->add('project', $projectID)
            ->add('version', 1)
            ->remove('files,labels')
            ->get();

        $design = $this->loadModel('file')->processImgURL($design, 'desc', $this->post->uid);
        $this->dao->insert(TABLE_DESIGN)->data($design)
            ->autoCheck()
            ->batchCheck($this->config->design->create->requiredFields, 'notempty')
            ->exec();

        if(!dao::isError())
        {
            $designID = $this->dao->lastInsertID();
            $this->file->updateObjectID($this->post->uid, $designID, 'design');
            $files = $this->file->saveUpload('design', $designID);

            $spec = new stdclass();
            $spec->design  = $designID;
            $spec->version = 1;
            $spec->name    = $design->name;
            $spec->desc    = $design->desc;
            $spec->files   = empty($files) ? '' : implode(',', array_keys($files));
            $this->dao->insert(TABLE_DESIGNSPEC)->data($spec)->exec();

            return $designID;
        }

        return false;
    }

    /**
     * Batch create designs.
     *
     * @param  int    $projectID
     * @param  int    $productID
     * @access public
     * @return bool
     */
    public function batchCreate($projectID = 0, $productID = 0)
    {
        $data = fixer::input('post')->get();

        $this->loadModel('action');
        foreach($data->name as $i => $name)
        {
            if(!trim($name)) continue;

            $design = new stdclass();
            $design->story       = isset($data->story[$i]) ? $data->story[$i] : '';
            $design->type        = $data->type[$i];
            $design->name        = $name;
            $design->product     = $productID;
            $design->project     = $projectID;
            $design->desc        = nl2br($data->desc[$i]);
            $design->createdBy   = $this->app->user->account;
            $design->createdDate = helper::now();

            $this->dao->insert(TABLE_DESIGN)->data($design)->autoCheck()->batchCheck($this->config->design->create->requiredFields, 'notempty')->exec();

            $designID = $this->dao->lastInsertID();
            $this->action->create('design', $designID, 'Opened');
        }

        return true;
    }

    /**
     * Update a design.
     *
     * @param  int    $designID
     * @access public
     * @return bool
     */
    public function update($designID = 0)
    {
        $oldDesign = $this->getByID($designID);
        $design = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->stripTags($this->config->design->editor->edit['id'], $this->config->allowedTags)
            ->remove('file,files,labels,children,toList')
            ->get();

        $design = $this->loadModel('file')->processImgURL($design, 'desc', $this->post->uid);
        $this->dao->update(TABLE_DESIGN)->data($design)->autoCheck()->batchCheck('name,type', 'notempty')->where('id')->eq($designID)->exec();

        if(!dao::isError())
        {
            $this->file->updateObjectID($this->post->uid, $designID, 'design');
            $files = $this->file->saveUpload('design', $designID);
            $designChanged = ($oldDesign->name != $design->name || $oldDesign->desc != $design->desc || !empty($files));

            if($designChanged)
            {
                $design  = $this->getByID($designID);
                $version = $design->version + 1;
                $spec = new stdclass();
                $spec->design  = $designID;
                $spec->version = $version;
                $spec->name    = $design->name;
                $spec->desc    = $design->desc;
                $spec->files   = empty($files) ? '' : implode(',', array_keys($files));
                $this->dao->insert(TABLE_DESIGNSPEC)->data($spec)->exec();

                $this->dao->update(TABLE_DESIGN)->set('version')->eq($version)->where('id')->eq($designID)->exec();
            }

            return common::createChanges($oldDesign, $design);
        }

        return false;
    }

    /**
     * Assign a design.
     *
     * @param  int    $designID
     * @access public
     * @return array|bool
     */
    public function assign($designID = 0)
    {
        $oldDesign = $this->getByID($designID);

        $design = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::today())
            ->setDefault('assignedDate', helper::today())
            ->stripTags($this->config->design->editor->assignto['id'], $this->config->allowedTags)
            ->remove('uid,comment,files,label')
            ->get();

        $this->dao->update(TABLE_DESIGN)->data($design)->autoCheck()->where('id')->eq((int)$designID)->exec();

        if(!dao::isError()) return common::createChanges($oldDesign, $design);
        return false;
    }

    /**
     * LinkCommit a design.
     *
     * @param  int    $designID
     * @param  int    $repoID
     * @access public
     * @return void
     */
    public function linkCommit($designID = 0, $repoID = 0)
    {
        $revisions = $_POST['revision'];

        foreach($revisions as $revision)
        {
            $data = new stdclass();
            $data->project  = $this->session->project;
            $data->product  = $this->session->product;
            $data->AType    = 'design';
            $data->AID      = $designID;
            $data->BType    = 'commit';
            $data->BID      = $revision;
            $data->relation = 'completedin';
            $data->extra    = $repoID;

            $this->dao->replace(TABLE_RELATION)->data($data)->autoCheck()->exec();

            $data->AType    = 'commit';
            $data->AID      = $revision;
            $data->BType    = 'design';
            $data->BID      = $designID;
            $data->relation = 'completedfrom';

            $this->dao->replace(TABLE_RELATION)->data($data)->autoCheck()->exec();
        }

        $oldCommit = $this->dao->findByID($designID)->from(TABLE_DESIGN)->fetch('commit');
        $revisions = join(',', $revisions);
        $commit    = $oldCommit ? $oldCommit . ',' . $revisions : $revisions;

        $design = new stdclass();
        $design->commit     = $commit;
        $design->commitedBy = $this->app->user->account;
        $this->dao->update(TABLE_DESIGN)->data($design)->autoCheck()->where('id')->eq($designID)->exec();
    }

    /**
     * Unlink commit.
     *
     * @param  int    $designID
     * @param  int    $commitID
     * @access public
     * @return void
     */
    public function unlinkCommit($designID = 0, $commitID = 0)
    {
        /* Delete data in the zt_relation.*/
        $this->dao->delete()->from(TABLE_RELATION)->where('AType')->eq('design')->andwhere('AID')->eq($designID)->andwhere('BType')->eq('commit')->andwhere('relation')->eq('completedin')->andWhere('BID')->eq($commitID)->exec();
        $this->dao->delete()->from(TABLE_RELATION)->where('AType')->eq('commit')->andwhere('BID')->eq($designID)->andwhere('BType')->eq('design')->andwhere('relation')->eq('completedfrom')->andWhere('AID')->eq($commitID)->exec();

        /* Commit after unlinking. */
        $commit = $this->dao->select('BID')->from(TABLE_RELATION)->where('AType')->eq('design')->andWhere('AID')->eq($designID)->andWhere('BType')->eq('commit')->andwhere('relation')->eq('completedin')->fetchAll('BID');
        $commit = implode(",", array_keys($commit));

        $this->dao->update(TABLE_DESIGN)->set('commit')->eq($commit)->where('id')->eq($designID)->exec();
    }

    /**
     * Get a design by id.
     *
     * @param  int    $designID
     * @access public
     * @return object
     */
    public function getByID($designID = 0)
    {
        $design = $this->dao->select('*')->from(TABLE_DESIGN)->where('id')->eq($designID)->fetch();
        if(!$design) return false;

        $design->files       = $this->loadModel('file')->getByObject('design', $designID);
        $design->productName = $this->dao->findByID($design->product)->from(TABLE_PRODUCT)->fetch('name');


        $design->commit = '';
        $relations = $this->loadModel('common')->getRelations('design', $designID, 'commit');
        foreach($relations as $relation) $design->commit .= html::a(helper::createLink('design', 'revision', "repoID=$relation->BID&projectID={$design->project}"), "#$relation->BID", '_blank');

        return $this->loadModel('file')->replaceImgURL($design, 'desc');
    }

    /**
     * Get design pairs.
     *
     * @param  int    $productID
     * @param  string $type all|HLDS|DDS|DBDS|ADS
     * @access public
     * @return object
     */
    public function getPairs($productID = 0, $type = 'all')
    {
        $designs = $this->dao->select('id, name')->from(TABLE_DESIGN)
            ->where('product')->eq($productID)
            ->andWhere('deleted')->eq(0)
            ->andWhere('type')->eq($type)
            ->fetchPairs();
        foreach($designs as $id => $name) $designs[$id] = $id . ':' . $name;

        return $designs;
    }

    /**
     * Get affected scope.
     *
     * @param  int    $design
     * @access public
     * @return object
     */
    public function getAffectedScope($design = 0)
    {
        /* Get affected tasks. */
        $design->tasks = $this->dao->select('*')->from(TABLE_TASK)
            ->where('deleted')->eq(0)
            ->andWhere('status')->ne('closed')
            ->andWhere('design')->eq($design->id)
            ->orderBy('id desc')->fetchAll();

        return $design;
    }

    /**
     * Get design list.
     *
     * @param  int    $productID
     * @param  int    $projectID
     * @param  string $type all|bySearch|HLDS|DDS|DBDS|ADS
     * @param  int    $param
     * @param  string $orderBy
     * @param  int    $pager
     * @access public
     * @return array
     */
    public function getList($projectID = 0, $productID = 0, $type = 'all', $param = 0, $orderBy = 'id_desc', $pager = null)
    {
        if($type == 'bySearch')
        {
            $designs = $this->getBySearch($projectID, $productID, $param, $orderBy, $pager);
        }
        else
        {
            $designs = $this->dao->select('*')->from(TABLE_DESIGN)
                ->where('deleted')->eq(0)
                ->beginIF($projectID)->andWhere('project')->eq($projectID)->fi()
                ->beginIF($type != 'all')->andWhere('type')->in($type)->fi()
                ->andWhere('product')->eq($productID)
                ->orderBy($orderBy)
                ->page($pager)
                ->fetchAll('id');
        }

        return $designs;
    }

    /**
     * Get commit.
     *
     * @param  int    $designID
     * @param  int    $pager
     * @access public
     * @return object
     */
    public function getCommit($designID = 0, $pager = null)
    {
        $design = $this->dao->select('*')->from(TABLE_DESIGN)->where('id')->eq($designID)->fetch();

        $design->commit = $this->dao->select('*')->from(TABLE_REPOHISTORY)->where('id')->in($design->commit)->page($pager)->fetchAll('id');

        return $design;
    }

    /**
     * Get designs by search.
     *
     * @param  int    $projectID
     * @param  int    $productID
     * @param  int    $queryID
     * @param  string $orderBy
     * @param  int    $pager
     * @access public
     * @return object
     */
    public function getBySearch($projectID = 0, $productID = 0, $queryID = 0, $orderBy = 'id_desc', $pager = null)
    {
        if($queryID)
        {
            $query = $this->loadModel('search')->getQuery($queryID);
            if($query)
            {
                $this->session->set('designQuery', $query->sql);
                $this->session->set('designForm', $query->form);
            }
            else
            {
                $this->session->set('designQuery', ' 1 = 1');
            }
        }
        else
        {
            if($this->session->designQuery == false) $this->session->set('designQuery', ' 1 = 1');
        }

        $designQuery = $this->session->designQuery;

        $designs =  $this->dao->select('*')->from(TABLE_DESIGN)
            ->where($designQuery)
            ->andWhere('deleted')->eq('0')
            ->andWhere('project')->eq($projectID)
            ->andWhere('product')->eq($productID)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');

        return $designs;
    }

    /**
     * Set design menu.
     *
     * @param  int    $projectID
     * @param  int    $products
     * @param  int    $productID
     * @param  string $currentModule
     * @param  string $currentMethod
     * @param  string $extra
     * @param  int    $branch
     * @access public
     * @return void
     */
    public function setMenu($projectID = 0, $products, $productID = 0)
    {
        if($this->app->rawMethod != 'browse') unset($this->lang->waterfall->menu->design['subMenu']->bysearch);
        if(empty($products) || !$productID) return '';
        $currentProduct = $this->loadModel('product')->getById($productID);
        setCookie("lastProduct", $productID, $this->config->cookieLife, $this->config->webRoot, '', false, true);

        $output = '';
        if(!empty($products))
        {
            $dropMenuLink = helper::createLink('design', 'ajaxGetDropMenu', "projectID=$projectID&productID=$productID");
            $output  = "<div class='btn-group angle-btn'><div class='btn-group'><button data-toggle='dropdown' type='button' class='btn btn-limit' id='currentItem' title='{$currentProduct->name}'><span class='text'>{$currentProduct->name}</span> <span class='caret'></span></button><div id='dropMenu' class='dropdown-menu search-list' data-ride='searchList' data-url='$dropMenuLink'>";
            $output .= '<div class="input-control search-box has-icon-left has-icon-right search-example"><input type="search" class="form-control search-input" /><label class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label><a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a></div>';
            $output .= "</div></div></div>";
        }

        return $output;
    }

    /**
     * Build search form.
     *
     * @param  int    $queryID
     * @param  string $actionURL
     * @access public
     * @return void
     */
    public function buildSearchForm($queryID = 0, $actionURL = '')
    {
        $this->config->design->search['actionURL'] = $actionURL;
        $this->config->design->search['queryID']   = $queryID;

        $this->loadModel('search')->setSearchParams($this->config->design->search);
    }

    /**
     * Print assignedTo html.
     *
     * @param  object $design
     * @param  array  $users
     * @access public
     * @return string
     */
    public function printAssignedHtml($design = '', $users = '')
    {
        $btnTextClass   = '';
        $assignedToText = zget($users, $design->assignedTo);

        if(empty($design->assignedTo))
        {
            $btnTextClass   = 'text-primary';
            $assignedToText = $this->lang->design->noAssigned;
        }
        if($design->assignedTo == $this->app->user->account) $btnTextClass = 'text-red';

        $btnClass     = $design->assignedTo == 'closed' ? ' disabled' : '';
        $btnClass     = "iframe btn btn-icon-left btn-sm {$btnClass}";
        $assignToLink = helper::createLink('design', 'assignTo', "designID=$design->id", '', true);
        $assignToHtml = html::a($assignToLink, "<i class='icon icon-hand-right'></i> <span title='" . zget($users, $design->assignedTo) . "' class='{$btnTextClass}'>{$assignedToText}</span>", '', "class='$btnClass'");

        echo !common::hasPriv('design', 'assignTo', $design) ? "<span style='padding-left: 21px' class='{$btnTextClass}'>{$assignedToText}</span>" : $assignToHtml;
    }
}

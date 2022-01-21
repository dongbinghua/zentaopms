/**
 * Load more.
 *
 * @param  string $type
 * @param  int    $regionID
 * @access public
 * @return void
 */
function loadMore(type, regionID)
{
    var method   = 'viewArchived' + type;
    var selector = '#archived' + type + 's';
    var link     = createLink('kanban', method, 'regionID=' + regionID);
    $(selector).load(link, function()
    {
        var windowHeight = $(window).height();
        $(selector + ' .panel-body').css('height', windowHeight - 100);
        $(selector).animate({right: 0}, 500);
    });
}

/**
 * Display the kanban in full screen.
 *
 * @access public
 * @return void
 */
function fullScreen()
{
    var element       = document.getElementById('kanbanContainer');
    var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullscreen;

    if(requestMethod)
    {
        var afterEnterFullscreen = function()
        {
            $('#kanbanContainer').addClass('fullscreen')
                .on('scroll', tryUpdateKanbanAffix);
            $('.actions').hide();
            $('.action').hide();
            $('.kanban-group-header').hide();
            $(".title").attr("disabled", true).css("pointer-events", "none");
            $.cookie('isFullScreen', 1);
        };

        var whenFailEnterFullscreen = function(error)
        {
            exitFullScreen();
        };

        try
        {
            var result = requestMethod.call(element);
            if(result && (typeof result.then === 'function' || result instanceof window.Promise))
            {
                result.then(afterEnterFullscreen).catch(whenFailEnterFullscreen);
            }
            else
            {
                afterEnterFullscreen();
            }
        }
        catch (error)
        {
            whenFailEnterFullscreen(error);
        }
    }
}

/**
 * Exit full screen.
 *
 * @access public
 * @return void
 */
function exitFullScreen()
{
    $('#kanbanContainer').removeClass('fullscreen')
        .off('scroll', tryUpdateKanbanAffix);
    $('.actions').show();
    $('.action').show();
    $('.kanban-group-header').show();
    $(".title").attr("disabled", false).css("pointer-events", "auto");
    $.cookie('isFullScreen', 0);
}

document.addEventListener('fullscreenchange', function (e)
{
    if(!document.fullscreenElement) exitFullScreen();
});

document.addEventListener('webkitfullscreenchange', function (e)
{
    if(!document.webkitFullscreenElement) exitFullScreen();
});

document.addEventListener('mozfullscreenchange', function (e)
{
    if(!document.mozFullScreenElement) exitFullScreen();
});

document.addEventListener('msfullscreenChange', function (e)
{
    if(!document.msfullscreenElement) exitFullScreen();
});

/**
 * Render header of a column.
 */
function renderHeaderCol($column, column, $header, kanbanData)
{
    /* Render group header. */
    var privs       = kanbanData.actions;
    var columnPrivs = kanbanData.columns[0].actions;

    if(privs.includes('sortGroup'))
    {
        var groups = regions[column.region].groups;
        if($header.closest('.kanban').data('zui.kanban'))
        {
            groups = $header.closest('.kanban').data('zui.kanban').data;
        }
        if(groups.length > 1)
        {
            $column.closest('.kanban-board').addClass('sort');
            $column.closest('.kanban-header').find('.kanban-group-header').remove();
            $column.closest('.kanban-header').prepend('<div class="kanban-group-header"><i class="icon icon-md icon-move"></i></div>');
        }
    }

    var regionID     = $column.closest('.kanban').data('id');
    var groupID      = $column.closest('.kanban-board').data('id');
    var laneID       = column.$kanbanData.lanes[0].id ? column.$kanbanData.lanes[0].id : 0;
    var columnID     = $column.closest('.kanban-col').data('id');
    var printMoreBtn = (columnPrivs.includes('setColumn') || columnPrivs.includes('setWIP') || columnPrivs.includes('createColumn') || columnPrivs.includes('copyColumn') || columnPrivs.includes('archiveColumn') || columnPrivs.includes('deleteColumn') || columnPrivs.includes('splitColumn'));

    /* Render more menu. */
    if(columnPrivs.includes('createCard') || printMoreBtn)
    {
        var addItemBtn = '';
        var moreAction = '';

        if(!$column.children('.actions').length) $column.append('<div class="actions"></div>');
        var $actions = $column.children('.actions');

        if(columnPrivs.includes('createCard') && column.parent != -1)
        {
            var cardUrl = createLink('kanban', 'createCard', 'kanbanID=' + kanbanID + '&regionID=' + regionID + '&groupID=' + groupID + '&columnID=' + columnID);
            addItemBtn  = ['<a data-contextmenu="columnCreate" data-toggle="modal" data-action="addItem" data-column="' + column.id + '" data-lane="' + laneID + '" href="' + cardUrl + '" class="text-primary iframe">', '<i class="icon icon-expand-alt"></i>', '</a>'].join('');
        }

        var moreAction = ' <button class="btn btn-link action"  title="' + kanbanLang.moreAction + '" data-contextmenu="column" data-column="' + column.id + '"><i class="icon icon-ellipsis-v"></i></button>';
        $actions.html(addItemBtn + moreAction);
    }
}

/**
 * Render items count of a column.
 */
function renderCount($count, count, column)
{
    /* Render WIP. */
    var limit = !column.limit || column.limit == '-1' ? '<i class="icon icon-md icon-infinite"></i>' : column.limit;
    if($count.parent().find('.limit').length)
    {
        $count.parent().find('.limit').html(limit);
    }
    else
    {
        $count.parent().find('.count').before("<span class='include-first text-grey'>(</span>");
        $count.parent().find('.count').after("<span class='divider text-grey'>/</span><span class='limit text-grey'>" + limit + "</span><span class='include-last text-grey'>)</span>");
    }

    if(column.limit != -1 && column.limit < count)
    {
        $count.parents('.title').parent('.kanban-header-col').css('background-color', '#F6A1A1');
        $count.parents('.title').find('.text').css('max-width', $count.parents('.title').width() - 200);
        $count.css('color', '#E33030');
        if(!$count.parent().find('.error').length) $count.parent().find('.include-last').after("<span class='error text-grey'><icon class='icon icon-help' title='" + kanbanLang.limitExceeded + "'></icon></span>");
    }
    else
    {
        $count.parents('.title').parent('.kanban-header-col').css('background-color', 'transparent');
        $count.parents('.title').find('.text').css('max-width', $count.parents('.title').width() - 120);
        $count.css('color', '#8B91A2');
        $count.parent().find('.error').remove();
    }
}

function renderLaneName($lane, lane, $kanban, columns, kanban)
{
    var canSet    = lane.actions.includes('setLane');
    var canSort   = lane.actions.includes('sortLane') && kanban.lanes.length > 1;
    var canDelete = lane.actions.includes('deleteLane');

    $lane.parent().toggleClass('sort', canSort);

    if(!$lane.children('.actions').length && (canSet || canDelete))
    {
        $([
          '<div class="actions" title="' + kanbanLang.more + '">',
          '<a data-contextmenu="lane" data-lane="' + lane.id + '" data-kanban="' + kanban.id + '">',
          '<i class="icon icon-ellipsis-v"></i>',
          '</a>',
          '</div>'
        ].join('')).appendTo($lane);
    }
}

/**
 * Render avatars of user.
 * @param {String|{account: string, avatar: string}} user User account or user object
 * @returns {string}
 */
function renderUsersAvatar(users, itemID, size)
{
    var avatarSizeClass = 'avatar-' + (size || 'sm');
    //var link = createLink('kanban', 'assigncard', 'id=' + itemID, '', true);

    if(users.length == 0 || (users.length == 1 && users[0] == ''))
    {
        return $('<div class="avatar has-text ' + avatarSizeClass + ' avatar-circle iframe" title="' + noAssigned + '" style="background: #ccc"><i class="icon icon-person"></i></div>');
    }

    var assignees = [];
    for(var user of users)
    {
        var $noPrivAndNoAssigned = $('<div class="avatar has-text ' + avatarSizeClass + ' avatar-circle" title="' + noAssigned + '" style="background: #ccc"><i class="icon icon-person"></i></div>');
        if(!priv.canAssignCard && !user)
        {
            assignees.push($noPrivAndNoAssigned);
            continue;
        }

        if(!user)
        {
            assignees.push($('<div class="avatar has-text ' + avatarSizeClass + ' avatar-circle iframe" title="' + noAssigned + '" style="background: #ccc"><i class="icon icon-person"></i></div>'));
            continue;
        }

        if(typeof user === 'string') user = {account: user};
        if(!user.avatar && window.userList && window.userList[user.account]) user = window.userList[user.account];

        assignees.push($('<div class="avatar has-text ' + avatarSizeClass + ' avatar-circle iframe"></div>').avatar({user: user}));
    }

    if(assignees.length > 3) assignees.splice(3, assignees.length - 3, '<span>...</span>');

    return assignees;
}


/**
 * The function for rendering kanban item
 */
function renderKanbanItem(item, $item)
{
    var $title       = $item.children('.title');
    var privs        = item.actions;
    var printMoreBtn = (privs.includes('editCard') || privs.includes('editCardStatus') ||privs.includes('archiveCard') || privs.includes('copyCard') || privs.includes('deleteCard') || privs.includes('moveCard') || privs.includes('setCardColor'));

    if(privs.includes('sortCard')) $item.parent().addClass('sort');
    if(!$title.length)
    {
        if(privs.includes('viewCard')) $title = $('<a class="title iframe" data-toggle="modal" data-width="80%"></a>').appendTo($item).attr('href', createLink('kanban', 'viewCard', 'cardID=' + item.id, '', true));
        if(!privs.includes('viewCard')) $title = $('<p class="title"></p>').appendTo($item);
    }

    $title.text(item.name).attr('title', item.name);

    if(printMoreBtn)
    {
        $(
        [
            '<div class="actions" title="' + kanbanLang.more + '">',
              '<a data-contextmenu="card" data-id="' + item.id + '">',
                '<i class="icon icon-ellipsis-v"></i>',
              '</a>',
            '</div>'
        ].join('')).appendTo($item);
    }

    var $info = $item.children('.info');
    if(!$info.length) $info = $(
    [
        '<div class="info">',
            '<span class="pri"></span>',
            '<span class="estimate label label-light"></span>',
            '<span class="time label label-light"></span>',
            '<div class="user"></div>',
        '</div>'
    ].join('')).appendTo($item);

    $item.data('card', item);

    $info.children('.estimate').text(item.estimate + kanbancardLang.lblHour);
    if(item.estimate == 0) $info.children('.estimate').hide();

    $info.children('.pri')
        .attr('class', 'pri label-pri label-pri-' + item.pri)
        .text(item.pri);

    $item.css('background-color', item.color);
    $item.toggleClass('has-color', item.color != '#fff' && item.color != '');
    $item.find('.info > .label-light').css('background-color', item.color);

    var $time = $info.children('.time');
    if(item.end == '0000-00-00' && item.begin == '0000-00-00')
    {
        $time.hide();
    }
    else
    {
        var today = new Date();
        var begin = $.zui.createDate(item.begin);
        var end   = $.zui.createDate(item.end);
        var needRemind    = (begin.toLocaleDateString() == today.toLocaleDateString() || end.toLocaleDateString() == today.toLocaleDateString());
        if(item.end == '0000-00-00' && item.begin != '0000-00-00')
        {
            $time.text($.zui.formatDate(begin, 'MM/dd') + ' ' + kanbancardLang.beginAB).attr('title', $.zui.formatDate(begin, 'yyyy/MM/dd') + ' ' +kanbancardLang.beginAB).show();
        }
        else if(item.begin == '0000-00-00' && item.end != '0000-00-00')
        {
            $time.text($.zui.formatDate(end, 'MM/dd') + ' ' + kanbancardLang.deadlineAB).attr('title', $.zui.formatDate(end, 'yyyy/MM/dd') + ' ' + kanbancardLang.deadlineAB).show();
        }
        else if(item.begin != '0000-00-00' && item.end != '0000-00-00')
        {
            $time.text($.zui.formatDate(begin, 'MM/dd') + ' ' +  kanbancardLang.to + ' ' + $.zui.formatDate(end, 'MM/dd')).attr('title', $.zui.formatDate(begin, 'yyyy/MM/dd') + kanbancardLang.to + $.zui.formatDate(end, 'yyyy/MM/dd')).show();
        }

        if(!$item.hasClass('has-color') && needRemind) $time.css('background-color', 'rgba(210, 50, 61, 0.3)');
        if($item.hasClass('has-color') && needRemind)  $time.css('background-color', 'rgba(255, 255, 255, 0.3)');
        if(!needRemind) $time.css('background-color', 'rgba(0, 0, 0, 0.15)');
    }

    /* Display avatars of assignedTo. */
    var assignedTo = item.assignedTo.split(',');
    var $user = $info.children('.user');
    var title = [];
    for(i = 0; i < assignedTo.length; i++) title.push(users[assignedTo[i]]);
    $user.html(renderUsersAvatar(assignedTo, item.id)).attr('title', title);
}

/**
 * Show error message
 * @param {string|object} message Message
 */
function showErrorMessager(message)
{
    var html = false;
    if(message instanceof Error)
    {
        message = message.message;
    }
    else if(typeof message === 'object')
    {
        html = [];
        $.each(message, function(key, msg)
        {
            html.push($.isArray(msg) ? msg.join('') : String(msg));
        });
        message = html.join('<br/>');
    }
    else
    {
        message = String(message);
    }

    if(typeof message === 'string' && message.length)
    {
        $.zui.messager.danger(message, {html: !!html});
    }
}

/**
 * Move a card.
 *
 * @param  int    $cardID
 * @param  int    $fromColID
 * @param  int    $toColID
 * @param  int    $fromLaneID
 * @param  int    $toLaneID
 * @param  int    $kanbanID
 * @param  int    $regionID
 * @access public
 * @return string
 */
function moveCard(cardID, fromColID, toColID, fromLaneID, toLaneID, kanbanID, regionID)
{
    if(!cardID) return false;
    var url = createLink('kanban', 'moveCard', 'cardID=' + cardID + '&fromColID='+ fromColID + '&toColID=' + toColID + '&fromLaneID='+ fromLaneID + '&toLaneID=' + toLaneID + '&kanbanID=' + kanbanID);
    return $.ajax(
    {
        method:   'post',
        dataType: 'json',
        url:       url,
        success: function(data)
        {
            regions = data;
            updateRegion(regionID, data[regionID]);

            /* Disable related operations in full screen mode. */
            if($.cookie('isFullScreen') == 1)
            {
                $('.actions').hide();
                $('.action').hide();
                $('.kanban-group-header').hide();
                $(".title").attr("disabled", true).css("pointer-events", "none");
            }
        },
        error: function(xhr, status, error)
        {
            showErrorMessager(error || lang.timeout);
        }
    });
}

/**
 * Set a card's color.
 *
 * @param int     $cardID
 * @param string  $color
 * @param int     $kanbanID
 * @param int     $regionID
 * @access public
 * @return string
 */
function setCardColor(cardID, color, kanbanID, regionID)
{
    if(!cardID) return false;
    color = color.replace('#', '');
    var url = createLink('kanban', 'setCardColor', 'cardID=' + cardID + '&color=' + color + '&kanbanID=' + kanbanID);
    return $.ajax(
    {
        method:   'post',
        dataType: 'json',
        url:       url,
        success: function(data)
        {
            updateRegion(regionID, data[regionID]);
        },
        error: function(xhr, status, error)
        {
            showErrorMessager(error || lang.timeout);
        }
    });
}

/**
 * Update card status.
 *
 * @param  int $cardID
 * @param  int $kanbanID
 * @access public
 * @return void
 */
function editCardStatus(cardID, kanbanID, regionID)
{
    if(!cardID) return false;
    var url = createLink('kanban', 'editCardStatus', 'cardID=' + cardID + '&kanbanID=' + kanbanID);
    return $.ajax(
    {
        method:   'post',
        dataType: 'json',
        url:       url,
        success: function(data)
        {
            updateRegion(regionID, data[regionID]);
        }
    });
}

/**
 * Update a region.
 *
 * @param  int      regionID
 * @param  array    regionData
 * @access public
 * @return boolean
 */
function updateRegion(regionID, regionData = [])
{
    if(!regionID) return false;

    var $region = $('#kanban'+ regionID).kanban();

    if(!$region.length) return false;
    if(!regionData) regionData = regions[regionID];

    $region.data('zui.kanban').render(regionData.groups);
    resetRegionHeight('open');
    return true;
}

/**
 * Hide kanban action
 */
function hideKanbanAction()
{
    $('.kanban').attr('data-action-enabled', null);
    $('.contextmenu').removeClass('contextmenu-show');
    $('.contextmenu .contextmenu-menu').removeClass('open').removeClass('in');
    $('#moreTasks, #moreColumns').animate({right: -400}, 500);
}

/**
 * Open form for adding task
 * @param {JQuery} $element Trigger element
 */
function openAddTaskForm($element)
{
    var regionID = $element.closest('.kanban').data('id');
    var groupID  = $element.closest('.kanban-board').data('id');
    var laneID   = $element.closest('.kanban-lane').data('id');
    var columnID = $element.closest('.kanban-col').data('id');
    var status   = $element.closest('.kanban-col').data('type');
    var modalUrl = createLink('kanban', 'createCard', 'kanbanID=' + kanbanID + '&regionID=' + regionID + '&groupID=' + groupID + '&columnID=' + columnID);
    $.zui.modalTrigger.show(
    {
        url: modalUrl,
        width: '1000px'
    });
    hideKanbanAction();
}

/**
 * Reset lane height according to window height.
 */
function resetLaneHeight()
{
    var maxHeight = '500px';
    if(laneCount < 2)
    {
        var windowHeight = $(window).height();
        var marginTop    = $('#main').css('margin-top');
        var headerHeight = $('.kanban > .kanban-board:first > .kanban-header').outerHeight();
        var actionHeight = $('.kanban > .kanban-board:first > .kanban-lane > .kanban-col:first > .kanban-lane-actions').outerHeight();

        maxHeight = windowHeight - parseInt(marginTop) - headerHeight - actionHeight;
    }
    $('.kanban-lane-items').css('max-height', maxHeight);
}

/**
 * Close modal and update kanban data.
 */
function closeModalAndUpdateKanban(regionID)
{
    setTimeout(function()
    {
        $.zui.closeModal();
        updateRegion(regionID);
    }, 1200);
}

/**
 * Status change map
 */
var statusChangeMap =
{
    wait:   ['doing', 'done', 'cancel'],
    doing:  ['done', 'cancel'],
    done:   ['doing', 'closed'],
    cancel: ['doing', 'closed'],
    closed: ['doing']
};

/**
 * Find drop columns
 * @param {JQuery} $element Drag element
 * @param {JQuery} $root Dnd root element
 */
function findDropColumns($element, $root)
{
    var $task  = $element;
    var task   = $task.data('task');
    //var status = task.status;
    var $col   = $task.closest('.kanban-col');
    var col    = $col.data();
    var lane   = $col.closest('.kanban-lane').data('lane');
    var allStatusCanChange = statusChangeMap[status];

    hideKanbanAction();

    return $root.find('.kanban-lane-col:not([data-type="EMPTY"],[data-type=""])').filter(function()
    {
        var $newCol = $(this);
        var newCol = $newCol.data();
        var $newLane = $newCol.closest('.kanban-lane');
        var newLane = $newLane.data('lane');

        $newCol.addClass('can-drop-here');
        return true;
    });
}

/**
 * Handle drop card
 * @param {Object} event Drop event object
 */
function handleDropTask($element, event, kanban)
{
    if(!event.target || !event.isNew) return;

    var $card    = $element;
    var $oldCol  = $card.closest('.kanban-col');
    var $newCol  = $(event.target).closest('.kanban-col');
    var oldCol   = $oldCol.data();
    var newCol   = $newCol.data();
    var oldLane  = $oldCol.closest('.kanban-lane').data('lane');
    var newLane  = $newCol.closest('.kanban-lane').data('lane');
    var regionID = $card.closest('.region').data('id');
    var kanbanID = $card.closest('#kanban').data('id');

    if(oldCol.id === newCol.id && newLane.id === oldLane.id) return false;

    var cardID = $card.data().id;
    moveCard(cardID, oldCol.id, newCol.id, oldLane.id, newLane.id, kanbanID, regionID);
}

/**
 * Handle finish drop task
 */
function handleFinishDrop()
{
    $('.kanban').find('.can-drop-here').removeClass('can-drop-here');
}

/**
 * Adjust add button postion in column
 */
function adjustAddBtnPosition($kanban)
{
    if(!$kanban)
    {
        $('.kanban').children('.kanban-board').each(function()
        {
            adjustAddBtnPosition($(this));
        });
        return;
    }

    $kanban.find('.kanban-lane-col:not([data-type="EMPTY"])').each(function()
    {
        var $col = $(this);
        var items = $col.children('.kanban-lane-items')[0];
        $col.toggleClass('has-scrollbar', items.scrollHeight > items.clientHeight);
    });
}

/**
 * Kanban action handlers
 */
var kanbanActionHandlers =
{
    addItem:  openAddTaskForm,
    dropItem: handleDropTask
};

/**
 * Handle kanban action
 */
function handleKanbanAction(action, $element, event, kanban)
{
    $('.kanban').attr('data-action-enabled', action);
    var handler = kanbanActionHandlers[action];
    if(handler) handler($element, event, kanban);
}

function processMinusBtn()
{
    var columnCount = $('#splitTable .child-column').size();
    if(columnCount > 2 && columnCount < 10)
    {
        $('#splitTable .btn-plus').show();
        $('#splitTable .btn-close').show();
    }
    else if(columnCount <= 2)
    {
        $('#splitTable .btn-close').hide();
    }
    else if(columnCount >= 10)
    {
        $('#splitTable .btn-plus').hide();
    }
}

/**
 * Create lane menu.
 *
 * @param  object $options
 * @access public
 * @return void
 */
function createLaneMenu(options)
{
    var lane = options.$trigger.closest('.kanban-lane').data('lane');
    var privs = lane.actions;
    if(!privs.length) return [];

    var items = [];
    if(privs.includes('setLane')) items.push({label: kanbanLang.setLane, icon: 'edit', url: createLink('kanban', 'setLane', 'laneID=' + lane.id + '&executionID=0&from=kanban'), className: 'iframe', attrs: {'data-toggle': 'modal', 'data-width': '635px'}});
    if(privs.includes('deleteLane')) items.push({label: kanbanLang.deleteLane, icon: 'trash', url: createLink('kanban', 'deleteLane', 'lane=' + lane.id), attrs: {'target': 'hiddenwin'}});

    var bounds = options.$trigger[0].getBoundingClientRect();
    items.$options = {x: bounds.right, y: bounds.top};
    return items;
}

/**
 * Create card menu.
 *
 * @param  object $options
 * @access public
 * @return array
 */
function createCardMenu(options)
{
    var card  = options.$trigger.closest('.kanban-item').data('item');
    var privs = card.actions;
    if(!privs.length) return [];

    var items = [];
    if(privs.includes('editCard')) items.push({label: kanbanLang.editCard, icon: 'edit', url: createLink('kanban', 'editCard', 'cardID=' + card.id, '', 'true'), className: 'iframe', attrs: {'data-toggle': 'modal', 'data-width': '80%'}});
    if(privs.includes('editCardStatus') && kanban.performable == 1)
    {
        var statusLang = '';
        var statusIcon = '';
        if(card.status == 'doing')
        {
            statusLang = kanbanLang.finishCard;
            statusIcon = 'checked';
        }
        else
        {
            statusLang = kanbanLang.activeCard;
            statusIcon = 'magic';
        }

        items.push({label: statusLang, icon: statusIcon, onClick: function(){editCardStatus(card.id, card.kanban, card.region);}});
    }
    if(privs.includes('archiveCard') && kanban.archived == '1') items.push({label: kanbanLang.archiveCard, icon: 'card-archive', url: createLink('kanban', 'archiveCard', 'cardID=' + card.id), attrs: {'target': 'hiddenwin'}});
    if(privs.includes('copyCard')) items.push({label: kanbanLang.copyCard, icon: 'copy', url: createLink('kanban', 'copyCard', 'cardID=' + card.id, '', 'true'), className: 'iframe', attrs: {'data-toggle': 'modal'}});
    if(privs.includes('deleteCard')) items.push({label: kanbanLang.deleteCard, icon: 'trash', url: createLink('kanban', 'deleteCard', 'cardID=' + card.id), attrs: {'target': 'hiddenwin'}});
    if(privs.includes('moveCard'))
    {
        var moveCardItems = [];
        var moveColumns   = [];
        var parentColumns = [];
        var regionGroups   = regions[options.$trigger.closest('.region').data('id')].groups;
        for(let i = 0; i < regionGroups.length ; i ++ )
        {
            if(regionGroups[i].id == options.$trigger.closest('.kanban-board').data('id'))
            {
                moveColumns = regionGroups[i].columns;
                break;
            }
        }
        for(let i = moveColumns.length-1 ; i >= 0 ; i -- )
        {
            if(moveColumns[i].parent > 0) parentColumns.push(moveColumns[i].parent);
            if(moveColumns[i].id == card.column || $.inArray(moveColumns[i].id, parentColumns) >= 0) continue;
            moveCardItems.push({label: moveColumns[i].name, onClick: function(){moveCard(card.id, card.column, moveColumns[i].id, card.lane, card.lane, card.kanban, card.region);}});
        }
        moveCardItems = moveCardItems.reverse();
        items.push({label: kanbanLang.moveCard, icon: 'move', items: moveCardItems});
    }
    if(privs.includes('setCardColor'))
    {
        var cardColoritems = [];
        if(!card.color) color = "#fff";
        for(let i = 0 ; i < colorList.length ; i ++ )
        {
            var attr   = card.color == colorList[i] ? '<i class="icon icon-check" style="margin-left: 10px"></i>' : '';
            var border = i == 0 ? 'border:1px solid #b0b0b0;' : '';
            cardColoritems.push({label: "<div class='cardcolor' style='background:" + colorList[i] + ";" + border + "'></div>" + colorListLang[colorList[i]]  + attr ,
                onClick: function(){setCardColor(card.id, colorList[i], card.kanban, card.region);}, html: true, attrs: {id: 'cardcolormenu'}, className: 'color' + i});
        };
        items.push({label: kanbanLang.cardColor, icon: 'color', items: cardColoritems});
    }

    var bounds = options.$trigger[0].getBoundingClientRect();
    items.$options = {x: bounds.right, y: bounds.top};
    return items;
}

function createColumnMenu(options)
{
    var column = options.$trigger.closest('.kanban-col').data('col');
    var privs = column.actions;
    if(!privs.length) return [];

    var items = [];
    if(privs.includes('setColumn')) items.push({label: kanbanLang.editColumn, icon: 'edit', url: createLink('kanban', 'setColumn', 'columnID=' + column.id, '', 'true'), className: 'iframe', attrs: {'data-toggle': 'modal'}});
    if(privs.includes('setWIP')) items.push({label: kanbanLang.setWIP, icon: 'alert', url: createLink('kanban', 'setWIP', 'columnID=' + column.id), className: 'iframe', attrs: {'data-toggle': 'modal', 'data-width' : '500px'}});
    if(privs.includes('splitColumn')) items.push({label: kanbanLang.splitColumn, icon: 'col-split', url: createLink('kanban', 'splitColumn', 'columnID=' + column.id, '', true), className: 'iframe', attrs: {'data-toggle': 'modal'}});
    if(privs.includes('createColumn'))
    {
        items.push({label: kanbanLang.createColumnOnLeft, icon: 'col-add-left', url: createLink('kanban', 'createColumn', 'columnID=' + column.id + '&position=left'), className: 'iframe', attrs: {'data-toggle': 'modal'}});
        items.push({label: kanbanLang.createColumnOnRight, icon: 'col-add-right', url: createLink('kanban', 'createColumn', 'columnID=' + column.id + '&position=right'), className: 'iframe', attrs: {'data-toggle': 'modal'}});
    }
    if(privs.includes('copyColumn')) items.push({label: kanbanLang.copyColumn, icon: 'copy', url: createLink('kanban', 'copyColumn', 'columnID=' + column.id), className: 'iframe', attrs: {'data-toggle': 'modal'}});
    if(privs.includes('archiveColumn') && kanban.archived == '1' && column.$kanbanData.columns.length > 1) items.push({label: kanbanLang.archiveColumn, icon: 'card-archive', url: createLink('kanban', 'archiveColumn', 'columnID=' + column.id), attrs: {'target': 'hiddenwin'}});
    if(privs.includes('deleteColumn') && column.$kanbanData.columns.length > 1) items.push({label: kanbanLang.deleteColumn, icon: 'trash', url: createLink('kanban', 'deleteColumn', 'columnID=' + column.id), attrs: {'target': 'hiddenwin'}});

    var bounds = options.$trigger[0].getBoundingClientRect();
    items.$options = {x: bounds.right, y: bounds.top};
    return items;
}

/** Calculate column height */
function calcColHeight(col, lane, colCards, colHeight, kanban)
{
    if(!isMultiLanes) return 0;

    var options = kanban.options;

    if(!options.displayCards) return 0;
    var displayCards = +(options.displayCards || 2);

    if (typeof displayCards !== 'number' || displayCards < 2) displayCards = 2;
    return (displayCards * (options.cardHeight + options.cardSpace) + options.cardSpace);
}

/* Define menu creators */
window.menuCreators =
{
    card: createCardMenu,
    lane: createLaneMenu,
    column: createColumnMenu
};

/**
 * init Kanban
 */
function initKanban($kanban)
{
    var id           = $kanban.data('id');
    var region       = regions[id];
    var displayCards = window.displayCards == 'undefined' ? 2 : window.displayCards;

    $kanban.kanban(
    {
        data:              region.groups,
        maxColHeight:      510,
        calcColHeight:     calcColHeight,
        fluidBoardWidth:   false,
        minColWidth:       285,
        maxColWidth:       285,
        cardHeight:        60,
        displayCards:      displayCards,
        createColumnText:  kanbanLang.createColumn,
        addItemText:       '',
        itemRender:        renderKanbanItem,
        onAction:          handleKanbanAction,
        onRenderKanban:    adjustAddBtnPosition,
        onRenderLaneName:  renderLaneName,
        onRenderHeaderCol: renderHeaderCol,
        onRenderCount:     renderCount,
        droppable:
        {
            target:       findDropColumns,
            finish:       handleFinishDrop,
            mouseButton: 'left'
        }
    });

    $kanban.on('click', '.action-cancel', hideKanbanAction);
    $kanban.on('scroll', function()
    {
        $.zui.ContextMenu.hide();
    });
}

/**
 * Init when page ready
 */
$(function()
{
    window.isMultiLanes = laneCount > 1;

    /* Init first kanban */
    $('.kanban').each(function()
    {
        initKanban($(this));
    });

    $('.icon-chevron-double-up,.icon-chevron-double-down').on('click', function()
    {
        $(this).toggleClass('icon-chevron-double-up icon-chevron-double-down');
        $(this).parents('.region').find('.kanban').toggle();
        hideKanbanAction();
        resetRegionHeight($(this).hasClass('icon-chevron-double-up') ? 'open' : 'close');
    });

    $('.region-header').on('click', '.action', hideKanbanAction);
    $('#TRAction').on('click', '.btn', hideKanbanAction);

    /* Hide action box when user click document */
    $(document).on('click', function(e)
    {
        $('.kanban').each(function()
        {
            var currentAction = $(this).kanban().attr('data-action-enabled');
            var canHideAction = (currentAction === 'headerMore' || currentAction === 'editLaneName')
                && !$(e.target).closest('.action,.action-box').length;
            if(canHideAction) hideKanbanAction();
        });
    });

    /* Init contextmenu */
    $('#kanban').on('click', '[data-contextmenu]', function(event)
    {
        var $trigger    = $(this);
        var menuType    = $trigger.data('contextmenu');
        var menuCreator = window.menuCreators[menuType];
        if(!menuCreator) return;

        var options = $.extend({event: event, $trigger: $trigger}, $trigger.data());
        var items = menuCreator(options);
        if(!items || !items.length) return;

        $.zui.ContextMenu.show(items, items.$options || {event: event});
    });

    /* Adjust the add button position on window resize */
    $(window).on('resize', function(a)
    {
        adjustAddBtnPosition();
    });

    resetLaneHeight();

    /* Hide contextmenu when page scroll */
    $(window).on('scroll', function()
    {
        $.zui.ContextMenu.hide();
    });

    $(document).on('click', '#splitTable .btn-plus', function()
    {
        var tr = $(this).closest('tr');
        tr.after($('#childTpl').html().replace(/key/g, key));
        tr.next().find('input[name^=color]').colorPicker();
        key++;
        processMinusBtn();
        return false;
    });

    /* Remove a trade detail item. */
    $(document).on('click', '#splitTable .btn-close', function()
    {
        $(this).closest('tr').remove();
        processMinusBtn();
        return false;
    });

    /* Mofidy dafault color's border color. */
    $(document).on('mouseout', '.color0', function()
    {
        $('.color0 .cardcolor').css('border', '1px solid #b0b0b0');
    });

    /* Mofidy dafault color's border color. */
    $(document).on('mouseover', '.color0', function()
    {
        $('.color0 .cardcolor').css('border', '1px solid #fff');
    });

    /* Init sortable */
    var sortType = '';
    var $cards   = null;
    $('#kanban').sortable(
    {
        selector: '.region, .kanban-board, .kanban-lane, .kanban-item.sort',
        trigger: '.region.sort > .region-header, .kanban-board.sort > .kanban-header > .kanban-group-header, .kanban-lane.sort > .kanban-lane-name, .kanban-item.sort',
        container: function($ele)
        {
            return $ele.parent();
        },
        targetSelector: function($ele)
        {
            /* Sort regions. */
            if($ele.hasClass('region'))
            {
                sortType = 'region';
                return $ele.parent().children('.region');
            }

            /* Sort boards. */
            if($ele.hasClass('kanban-board'))
            {
                sortType = 'board';
                return $ele.parent().children('.kanban-board');
            }

            /* Sort lanes. */
            if($ele.hasClass('kanban-lane'))
            {
                sortType = 'lane';
                $cards   = $ele.find('.kanban-item');

                return $ele.parent().children('.kanban-lane');
            }

            /* Sort cards. */
            if($ele.hasClass('kanban-item'))
            {
                sortType = 'card';
                return $ele.parent().children('.kanban-item');
            }
        },
        start: function(e)
        {
            if(sortType == 'region')
            {
                showRegionIdList = '';
                $('.icon-chevron-double-up').each(function()
                {
                    showRegionIdList += $(this).attr('data-id') + ',';
                    $(this).attr('class', 'icon-chevron-double-down');
                });

                $('.region').find('.kanban').hide();
                hideKanbanAction();
            }
        },
        finish: function(e)
        {
            var url = '';
            var orders = [];
            e.list.each(function(index, data)
            {
                orders.push(data.item.data('id'));
            });

            if(sortType == 'region')
            {
                $('.region').each(function()
                {
                    if(showRegionIdList.includes($(this).attr('data-id')))
                    {
                        $(this).find('.icon-chevron-double-down').attr('class', 'icon-chevron-double-up');
                        $(this).find('.kanban').show();
                    }
                })

                url = createLink('kanban', 'sortRegion', 'regions=' + orders.join(','));
            }
            if(sortType == 'board')
            {
                var region = e.element.parent().data('id');
                url = createLink('kanban', 'sortGroup', 'region=' + region + '&groups=' + orders.join(','));
            }
            if(sortType == 'lane')
            {
                var region = e.element.parent().parent().data('id');
                url = createLink('kanban', 'sortLane', 'region=' + region + '&lanes=' + orders.join(','));
            }
            if(sortType == 'card')
            {
                var laneID   = e.element.closest('.kanban-lane').data('id');
                var columnID = e.element.closest('.kanban-col').data('id');
                url = createLink('kanban', 'sortCard', 'kanbanID=' + kanbanID + '&laneID=' + laneID + '&columnID=' + columnID + '&cards=' + orders.join(','));
            }
            if(!url) return true;

            $.getJSON(url, function(response)
            {
                if(response.result == 'fail' && response.message.length)
                {
                    bootbox.alert(response.message);
                    setTimeout(function(){return location.reload()}, 3000);
                }
            });
        },
        always: function(e)
        {
            if(sortType == 'lane') $cards.show();
        }
    });

    resetRegionHeight('open');
});

/**
 * Reset region height according to window height.
 *
 * @param  string fold
 * @access public
 * @return void
 */
function resetRegionHeight(fold)
{
    var regionCount = 0;
    if($.isEmptyObject(regions)) return false;
    for(var i in regions)
    {
        regionCount += 1;
        if(regionCount > 1) return false;
    }

    var regionID   = Object.keys(regions)[0];
    var region     = regions[regionID].groups;
    var groupCount = 0;

    if($.isEmptyObject(region)) return false;
    for(var j in region)
    {
        groupCount += 1;
        if(groupCount > 1) return false;
    }

    var group     = region[0];
    var laneCount = 0;

    if($.isEmptyObject(group.lanes)) return false;
    for(var h in group.lanes)
    {
        laneCount += 1;
        if(laneCount > 1) return false;
    }

    var regionHeaderHeight = $('.region-header').outerHeight();
    if(fold == 'open')
    {
        var windowHeight  = $(window).height();
        var headerHeight  = $('#mainHeader').outerHeight();
        var mainPadding   = $('#main').css('padding-top');
        var panelBorder   = $('.panel').css('border-top-width');
        var bodyPadding   = $('.panel-body').css('padding-top');
        var height        = windowHeight - (parseInt(mainPadding) * 2) - (parseInt(bodyPadding) * 2) - headerHeight - (parseInt(panelBorder) * 2);
        var regionPadding = $('.kanban').css('padding-bottom');
        var columnHeight  = $('.kanban-header').outerHeight();

        $('.region').css('height', height);
        $('.kanban-lane').css('height', height - regionHeaderHeight - parseInt(regionPadding) - columnHeight);
    }
    else
    {
        $('.region').css('height', regionHeaderHeight);
    }
}

/**
 * Set duplicate field.
 * 
 * @param  string $resolution 
 * @param  int    $storyID
 * @access public
 * @return void
 */
function setDuplicateAndChild(resolution, storyID)
{
    if(resolution == 'duplicate')
    {
        $('#childStoryBox' + storyID).hide();
        $('#duplicateStoryBox' + storyID).show();
    }
    else if(resolution == 'subdivided')
    {
        $('#duplicateStoryBox' + storyID).hide();
        $('#childStoryBox' + storyID).show();
    }
    else
    {
        $('#duplicateStoryBox' + storyID).hide();
        $('#childStoryBox' + storyID).hide();
    }
}

$(function()
{
    $firstTr = $('.table-form').find('tbody tr:first');
    $firstTr.find('td select').each(function()
    {
        $(this).find("option[value='ditto']").remove();
        $(this).trigger("chosen:updated");
    });
})

$(document).on('click', '.chosen-with-drop', function(){oldValue = $(this).prev('select').val();})

$(document).on('change', 'select', function()
{
    if($(this).val() == 'ditto')
    {
        var index  = $(this).closest('td').index();
        var row    = $(this).closest('tr').index();
        var $tbody = $(this).closest('tr').parent();

        if($(this).attr('name').indexOf('closedReasons') != -1)
        {
            index  = $(this).closest('tr').closest('td').index();
            row    = $(this).closest('tr').closest('td').parent().index();
            $tbody = $(this).closest('tr').closest('td').parent().parent();
        }

        var value = '';
        for(i = row - 1; i >= 0; i--)
        {
            value = $tbody.children('tr').eq(i).find('td').eq(index).find('select').val();
            if(value != 'ditto') break;
        }

        isModules = $(this).attr('name').indexOf('modules') != -1;
        isPlans   = $(this).attr('name').indexOf('plans')   != -1;

        if(isModules || isPlans)
        {

            var valueStr = ',' + $(this).find('option').map(function(){return $(this).val();}).get().join(',') + ',';
            if(valueStr.indexOf(',' + value + ',') != -1)
            {
                $(this).val(value);
            }
            else
            {
                alert(dittoNotice);
                $(this).val(oldValue);
            }
        }
        else
        {
            $(this).val(value);
        }

        $(this).trigger("chosen:updated");
        $(this).trigger("change");
    }
})

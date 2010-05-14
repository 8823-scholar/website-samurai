{**
 * _pager.tpl
 *}
<div class='pager'>
    {if $Pager->hasPrev()}
        {Html->a href=$Pager->appendQuery("page=`$Pager->prev`") value="前の`$Pager->per_page`件"}
    {else}
        前の{$Pager->per_page}件
    {/if}
    |
    {if $Pager->hasNext()}
        {Html->a href=$Pager->appendQuery("page=`$Pager->next`") value="次の`$Pager->per_page`件"}
    {else}
        次の{$Pager->per_page}件
    {/if}
    &nbsp;
    [
    {foreach from=$Pager->sliding(5) item='page'}
        {if $page == $Pager->getNow()}
            {$page}
        {else}
            {Html->a href=$Pager->appendQuery("page=`$page`") value=$page}
        {/if}
    {/foreach}
    ]
</div>

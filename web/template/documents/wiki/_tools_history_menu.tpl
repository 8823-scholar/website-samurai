{**
 * documents - wiki - _tools_history_menu.tpl
 *}
<div class='history column'>
    <ul class='menu'>
        {if $do != 'diff'}
            <li>{Html->a value='差分を表示'
                    href="/documents/wiki/tools/history?name=`$wiki->name_encoded`&locale=`$wiki->locale`&do=diff&rev=`$request.rev`"}</li>
        {/if}
        {if $do != 'diffnow'}
            <li>{Html->a value='現在との差分を表示'
                    href="/documents/wiki/tools/history?name=`$wiki->name_encoded`&locale=`$wiki->locale`&do=diffnow&rev=`$request.rev`"}</li>
        {/if}
        {if $do != 'source'}
            <li>{Html->a value='ソースを表示'
                    href="/documents/wiki/tools/history?name=`$wiki->name_encoded`&locale=`$wiki->locale`&do=source&rev=`$request.rev`"}</li>
        {/if}
        <li>{Html->a value='変更履歴一覧'
                href="/documents/wiki/tools/history?name=`$wiki->name_encoded`&locale=`$wiki->locale`"}</li>
        <ul class='histories'>
            {foreach from=$histories item='history'}
                {assign var='_name_encoded' value=$history.name|urlencode}
                {assign var='_date' value=$history.created_at|date_format:'%Y年%m月%d日 %H:%M:%S'}
                <li>
                    {if $request.rev == $history.revision}
                        <span>{$history.revision} ({$_date})</span>
                    {else}
                        {Html->a href="/documents/wiki/tools/history?name=`$_name_encoded`&locale=`$history.locale`&do=view&rev=`$history.revision`"
                            value="`$history.revision` (`$_date`)"}
                    {/if}
                </li>
            {/foreach}
        </ul>
    </ul>
</div>

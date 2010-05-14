{**
 * documents - wiki - tools_history.tpl
 *}
{assign_array var='html.title.' value='変更履歴'}
{assign_array var='html.title.' value=$wiki->name}
{assign_array var='html.title.' value='ドキュメント'}
{include file='_header.tpl' action='documents wiki tools'
    css='/css/layout/2column.standard.css, /css/action/documents/wiki.css'}
    <h1>ドキュメント</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/documents/`$locale`/FrontPage" value='ドキュメント'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/documents/`$locale`/`$wiki->name_encoded`" value=$wiki->title}<li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>変更履歴<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>{$wiki->title|escape:'html'}の変更履歴</H2>
        <div class='history column'>
            <ul class='menu'>
                <li>{Html->a value='変更履歴一覧'
                        href="/documents/wiki/tools/history?name=`$wiki->name_encoded`&locale=`$wiki->locale`"}</li>
                <ul class='histories'>
                    {foreach from=$histories item='history'}
                    {assign var='_name_encoded' value=$history.name|urlencode}
                    {assign var='_date' value=$history.created_at|date_format:'%Y年%m月%d日 %H:%I:%S'}
                    <li>
                        {Html->a href="/documents/wiki/tools/history?name=`$_name_encoded`&locale=`$history.locale`&do=view&rev=`$history.revision`"
                            value="`$history.revision` (`$_date`)"}
                        [
                            {Html->a href="/documents/wiki/tools/history?name=`$_name_encoded`&locale=`$history.locale`&do=diff&rev=`$history.revision`"
                                value='差分'} |
                            {if $history.revision != $wiki->revision}
                                {Html->a href="/documents/wiki/tools/history?name=`$_name_encoded`&locale=`$history.locale`&do=diffnow&rev=`$history.revision`"
                                    value='現在との差分'} |
                            {else}
                                現在との差分 |
                            {/if}
                            {Html->a href="/documents/wiki/tools/history?name=`$_name_encoded`&locale=`$history.locale`&do=source&rev=`$history.revision`"
                                value='ソース'}
                        ]
                    </li>
                {/foreach}
                </ul>
            </ul>
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

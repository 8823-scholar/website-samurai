{**
 * documents - wiki - _sidebar.tpl
 *}
<div id='sidebar'>
    {** コンテンツメニュー **}
    {Wickey->renderContentsMenu assign='contents_menu'}
    {if $contents_menu}
        <div class='menu-contents column'>
            <h5>コンテンツメニュー</h5>
            {$contents_menu}
        </div>
    {/if}


    {** WIKIメニュー **}
    {if $wiki && !$wiki->is_newpage}
        <div class='menu-contents menu-wiki column'>
            <h5>WIKIメニュー</h5>
            <ul>
                {if $User->logined}
                    <li>{Html->a href="/documents/wiki/tools/edit?name=`$wiki->name_encoded`&locale=`$locale`" value='編集'}</li>
                    <li>{Html->a href="/documents/wiki/tools/attach?name=`$wiki->name_encoded`&locale=`$locale`" value='ファイル添付'}</li>
                {/if}
                <li>{Html->a href="/documents/wiki/tools/history?name=`$wiki->name_encoded`&locale=`$locale`" value='変更履歴'}</li>
                {if $wiki->creator}
                    <li class='name'>作成者 : {$wiki->creator->name|escape}</li>
                    <li class='name date'>{$wiki->created_at|date_format:'%Y年%m月%d日 %H:%M:%S'}</li>
                {/if}
                {if $wiki->updater}
                    <li class='name'>最終更新者 : {$wiki->updater->name|escape}</li>
                    <li class='name date'>{$wiki->updated_at|date_format:'%Y年%m月%d日 %H:%M:%S'}</li>
                {/if}
            </ul>
        </div>
    {/if}

    {** 最近編集されたページ **}
    {Action->getNearEdits per=10 assign='near_edits'}
    {if $near_edits}
        <div class='menu-contents near-edits column'>
            <h5>最近編集されたページ</h5>
            <ul>
            {foreach from=$near_edits item='dates' key='date'}
                <li class='date'>{$date|date_format:'%Y年%m月%d日'}</li>
                <ul>
                {foreach from=$dates item='wiki'}
                    <li>{Html->a href="/documents/`$locale`/`$wiki.name_encoded`" value=$wiki.title}</li>
                {/foreach}
                </ul>
            {/foreach}
            </ul>
        </div>
    {/if}
</div>

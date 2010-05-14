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
            </ul>
        </div>
    {/if}
</div>

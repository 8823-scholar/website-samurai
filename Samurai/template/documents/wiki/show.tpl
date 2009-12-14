{**
 * documents - wiki - show.tpl
 *}
{assign_array var='html.title.' value=$wiki->name}
{assign_array var='html.title.' value='ドキュメント'}
{include file='_header.tpl' action='documents wiki'
    css='/css/layout/2column.standard.css, /css/action/documents/wiki.css'}
    <h1>ドキュメント</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/documents/`$locale`/FrontPage" value='ドキュメント'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>{$wiki->title|escape:'html'}<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>{$wiki->title|escape:'html'}</H2>
        <div class='show column'>
            {Wickey->render text=$wiki->content}
        </div>
    </div>

    <div id='sidebar'>
        {** コンテンツメニュー **}
        {Wickey->renderContentsMenu assign='contents_menu'}
        {if $contents_menu}
            <div class='menu-contents column'>
                <h4>コンテンツメニュー</h4>
                {$contents_menu}
            </div>
        {/if}


        {** WIKIメニュー **}
        <div class='menu-wiki column'>
            <h4>WIKIメニュー</h4>
            <ul>
                <li>{Html->a href="/documents/wiki/tools/edit?name=`$wiki->name_encoded`&locale=`$locale`" value='編集'}</li>
            </ul>
        </div>
    </div>

{include file='_footer.tpl'}

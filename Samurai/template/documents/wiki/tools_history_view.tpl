{**
 * documents - wiki - tools_history_view.tpl
 *}
{assign_array var='html.title.' value='変更履歴(閲覧)'}
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
        <li class='selected'>変更履歴(閲覧)<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>{$wiki->title|escape:'html'}の変更履歴(revision@{$request.rev})</H2>
        {include file='documents/wiki/_tools_history_menu.tpl' do=$request.do}

        {** 過去のWIKI描画 **}
        <h2>{$wiki1->title|escape:'html'}</h2>
        <div class='show column'>
            {Wickey->render text=$wiki1->content}
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

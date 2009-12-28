{**
 * documents - wiki - tools_comment_done.tpl
 *}
{assign_array var='html.title.' value='コメント(完了)'}
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
        <li class='selected'>コメント(完了)<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>コメントの投稿(完了)</h2>
        <div class='comment-done column'>
            <div class='message'>
                「{$wiki->title|escape:'html'}」へコメントを投稿しました。
            </div>
            <ul class='menu'>
                <li>{Html->a href="/documents/`$locale`/`$wiki->name_encoded`" value='戻る'}</li>
            </ul>
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

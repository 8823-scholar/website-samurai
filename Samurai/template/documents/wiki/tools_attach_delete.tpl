{**
 * documents - wiki - tools_attach_delete.tpl
 *}
{assign_array var='html.title.' value='添付ファイル(削除)'}
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
        <li>{Html->a href="/documents/wiki/tools/attach?name=`$wiki->name_encoded`&locale=`$wiki->locale`" value='添付ファイル'}<li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>削除<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>{$wiki->title|escape:'html'}の添付ファイル</h2>
        <div class='attache done column'>
            <h3>添付ファイル削除完了</h3>
            <p class='message'>
                添付ファイル「{$attach.original_name|escape:'html'}」の削除を完了しました。<br />
            </p>
            <ul class='menu'>
                <li>{Html->a href="/documents/wiki/tools/attach?name=`$wiki->name_encoded`&locale=`$wiki->locale`" value='戻る'}</li>
                <li>{Html->a href="/documents/`$wiki->locale`/`$wiki->name_encoded`" value="「`$wiki->title`」へいく"}</li>
                <li>{Html->a href="/documents/wiki/tools/edit?name=`$wiki->name_encoded`&locale=`$wiki->locale`" value="「`$wiki->title`」を編集する"}</li>
            </ul>
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

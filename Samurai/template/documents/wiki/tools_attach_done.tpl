{**
 * documents - wiki - tools_attach_done.tpl
 *}
{assign_array var='html.title.' value='添付ファイル(完了)'}
{assign_array var='html.title.' value=$wiki->name}
{assign_array var='html.title.' value='ドキュメント'}
{include file='_header.tpl' action='documents wiki tools'
    css='/css/layout/2column.standard.css, /css/action/documents/wiki.css'}
    <h1>ドキュメント</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/documents/`$locale`/FrontPage" value='ドキュメント'}</li>
        {if $wiki->is_newpage}
            <li class='delimiter'>&gt;</li>
            <li class='selected'>新規作成<li>
        {else}
            <li class='delimiter'>&gt;</li>
            <li>{Html->a href="/documents/`$locale`/`$wiki->name_encoded`" value=$wiki->title}<li>
            <li class='delimiter'>&gt;</li>
            <li class='selected'>編集<li>
        {/if}
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>{$wiki->title|escape:'html'}の添付ファイル</h2>
        <div class='attache done column'>
            <h3>ファイル添付完了</h3>
            <p class='message'>
                WIKI「{$wiki->title|escape:'html'}」へのファイル添付を完了しました。<br />
                このファイルをWIKIに貼り付けるには以下のタグをご使用ください。<br />
                <br />
                <span class='example'>&lt;attach name="{$attach.original_name|escape:'html'}" /&gt;</span>
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

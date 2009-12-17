{**
 * documents - wiki - tools_edit_preview.tpl
 *}
{assign_array var='html.title.' value='編集'}
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
            <li class='selected'>新規作成(確認)<li>
        {else}
            <li class='delimiter'>&gt;</li>
            <li>{Html->a href="/documents/`$locale`/`$wiki->name_encoded`" value=$wiki->title}<li>
            <li class='delimiter'>&gt;</li>
            <li class='selected'>編集(確認)<li>
        {/if}
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>{$request.title|escape:'html'}(プレビュー)</H2>
        <div class='edit preview column'>
            {Wickey->render text=$request.content}
        </div>


        <H2>{$wiki->title|default:$wiki->name|escape:'html'}の編集</H2>
        <div class='edit column'>
            {Html->form action='/documents/wiki/tools/edit/done'}
                {Html->hidden name='name' value=$wiki->name}
                {Html->hidden name='locale' value=$wiki->locale}
                {Html->hidden name='checksum' value=$request.checksum}
                {Html->hidden name='original' value=$request.original}
                {Html->hidden name=$token.name value=$token.value}
                <table class='form'>
                    <tr>
                        <th class='required'>タイトル</th>
                        <td class='input'>
                            {Html->text name='title' value=$request.title}
                        </td>
                    </tr>
                    <tr>
                        <th class='required'>内容</th>
                        <td class='input'>
                            {Html->textarea name='content' value=$request.content}<br />
                            <p class='example'>
                                {Html->a href="/documents/`$locale`/help%2Fformatrule" value='表記ルール' target='_blank'}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class='submit' colspan='2'>
                            {Html->submit value='キャンセル' dispatch='documents_wiki_show'}
                            {Html->submit value='プレビュー' dispatch='documents_wiki_tools_edit_preview'}
                            {Html->submit value='保存する'}
                        </td>
                    </tr>
                </table>
            {/Html->form}
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

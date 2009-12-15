{**
 * documents - wiki - tools_edit_merge.tpl
 *}
{assign_array var='html.title.' value='編集(マージ)'}
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
        <li class='selected'>編集<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>{$wiki->title|escape:'html'}の編集</H2>
        <div class='merge column'>
            <div class='error'>
                他の人が先にこのページを編集したようです。<br />
                {if $is_conflict}
                    編集箇所が衝突してマージできませんでした。お手数ですが衝突箇所をご確認ください。
                {else}
                    自動的に編集箇所をマージしました。マージ箇所をご確認ください。
                {/if}
            </div>

            <table class='diff'>
                <tr>
                    <th class='line'>orig</th>
                    <th class='line'>work</th>
                    <th></th>
                </tr>
                {$diff_html}
            </table>
        </div>


        <div class='edit column'>
            {Html->form action='/documents/wiki/tools/edit/preview'}
                {Html->hidden name='name' value=$wiki->name}
                {Html->hidden name='locale' value=$wiki->locale}
                {Html->hidden name='checksum' value=$checksum}
                {Html->hidden name='original' value=$wiki->content}
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
                            {Html->textarea name='content' value=$merged_content}<br />
                            <p class='example'>
                                {Html->a href="/documents/`$locale`/help%2Fformatrule" value='表記ルール' target='_blank'}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class='submit' colspan='2'>
                            {Html->submit value='キャンセル' dispatch='documents_wiki_show'}
                            {Html->submit value='プレビュー'}
                        </td>
                    </tr>
                </table>
            {/Html->form}
        </div>
    </div>

    <div id='sidebar'>
        {** WIKIメニュー **}
        <div class='menu-wiki column'>
            <h4>WIKIメニュー</h4>
            <ul>
                <li>{Html->a href="/documents/wiki/tools/edit?name=`$wiki->name_encoded`&locale=`$locale`" value='編集'}</li>
            </ul>
        </div>
    </div>

{include file='_footer.tpl'}

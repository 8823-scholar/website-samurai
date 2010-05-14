{**
 * documents - wiki - tools_attach.tpl
 *}
{assign_array var='html.title.' value='添付ファイル'}
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
        <li class='selected'>添付ファイル<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>{$wiki->title|escape:'html'}の添付ファイル</h2>
        <div class='attaches column'>
            <h3>添付ファイル一覧</h3>
            <ul class='list'>
            {foreach from=$attaches item='attach'}
                <li>
                    {Html->a value=$attach.original_name
                        href="/documents/wiki/tools/attach/view?name=`$wiki->name_encoded`&locale=`$wiki->locale`&attach=`$attach.name`"}
                    &nbsp;&nbsp;<span class='tag'>&lt;attach name="{$attach.original_name|escape:'html'}" /&gt;</span>
                    &nbsp;&nbsp;{Html->a image="/image/action/documents/wiki/icon.trash.mini.png" title='削除'
                                    href="/documents/wiki/tools/attach/delete?name=`$wiki->name_encoded`&locale=`$wiki->locale`&attach=`$attach.name`"}
                </li>
            {foreachelse}
                <li class='none'>アップロードされたファイルはまだありません。</li>
            {/foreach}
            </ul>
            {if $attaches}
                <p class='example'>
                    WIKIに貼り付けたい場合は、右側のタグをコピペしてあげてください。
                </p>
            {/if}
        </div>

        <div class='attach-upload'>
            <h3>ファイルアップロード</h3>
            {ErrorList->getMessages withkey=true assign='errors'}
            {Html->form action='/documents/wiki/tools/attach/done' file=true}
                {Html->hidden name='name' value=$wiki->name}
                {Html->hidden name='locale' value=$wiki->locale}
                {Html->hidden name=$token.name value=$token.value}
                <table class='form'>
                    <tr>
                        <th class='required'>ファイル</th>
                        <td class='input'>
                            {if $errors.attach} <div class='error'>{$errors.attach}</div> {/if}
                            {Html->file name='attach'}
                        </td>
                    </tr>
                    <tr>
                        <td class='submit' colspan='2'>
                            {Html->submit value='アップロード'}
                        </td>
                    </tr>
                </table>
            {/Html->form}
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

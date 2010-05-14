{**
 * documents - wiki - tools_comment_confirm.tpl
 *}
{assign_array var='html.title.' value='コメント(確認)'}
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
        <li class='selected'>コメント(確認)<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>{$wiki->title|escape:'html'}</h2>
        <div class='show column'>
            {$wiki->content|truncate:256:'...'}
        </div>

        <h2>コメントの投稿(確認)</h2>
        <div class='comment-confirm column'>
            {Html->form action='/documents/wiki/tools/comment/done#form-comment'}
                {Html->hidden name='name' value=$wiki->name}
                {Html->hidden name='locale' value=$wiki->locale}
                {Html->hidden name='cname' value=$request.cname}
                {Html->hidden name='comment' value=$request.comment}
                {Html->hidden name=$token.name value=$token.value}
                <table class='form'>
                    <tr>
                        <th class='required'>お名前</th>
                        <td class='input'>
                            {$request.cname|default:$User->name|escape:'html'}
                        </td>
                    </tr>
                    <tr>
                        <th class='required'>コメント</th>
                        <td class='input'>
                            {Wickey->render text=$request.comment}
                        </td>
                    </tr>
                    <tr>
                        <td class='submit' colspan='2'>
                            {Html->submit value='戻る' dispatch='documents_wiki_show'}
                            {Html->submit value='コメントを投稿する'}
                        </td>
                    </tr>
                </table>
            {/Html->form}
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

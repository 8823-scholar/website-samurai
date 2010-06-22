{**
 * documents - wiki - show.tpl
 *}
{assign_array var='html.title.' value=$wiki->title}
{assign_array var='html.title.' value='ドキュメント'}
{include file='_header.tpl' action='documents wiki'
    css='/css/layout/2column.standard.css, /css/action/documents/wiki.css'}
    <h1>ドキュメント</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/documents/`$locale`/FrontPage" value='ドキュメント'}</li>
        <li class='delimiter'>&gt;</li>
        {foreach from=$breads item='bread'}
            <li>{Html->a href="/documents/`$locale`/`$bread.path`" value=$bread.title}</li>
            <li class='delimiter'>&gt;</li>
        {/foreach}
        <li class='selected'>{$wiki->title|escape:'html'}<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>{$wiki->title|escape:'html'}</H2>
        <div class='show column'>
            {Wickey->render text=$wiki->content base="/documents/`$locale`/"}
        </div>

        <h2>コメント</h2>
        <div class='comment column'>
            <table class='list'>
            {foreach from=$comments item='comment' key='key' name='comments'}
                {if $key % 2 == 0}
                    {assign var='_class' value='even'}
                {else}
                    {assign var='_class' value='odd'}
                {/if}
                {if $smarty.foreach.comments.last}
                    {assign var='_class' value="`$_class` last"}
                {/if}
                <tr class='{$_class}'>
                    <td class='comment'>{Wickey->render text=$comment.comment}</td>
                </tr>
                <tr class='{$_class}'>
                    <td class='info'>
                        <span class='user'>by {$comment.name|escape:'html'}</span>
                        ,<span class='date'>at {$comment.created_at|date_format:'%Y年%m月%d日 %H:%M'}</span></td>
                </tr>
            {foreachelse}
                <tr>
                    <td class='none'>コメントはまだありません。</td>
                </tr>
            {/foreach}
            </table>

            {ErrorList->getMessages assign='errors'}
            {if $errors}
                <ul class='errors'>
                {foreach from=$errors item='error'}
                    <li>{$error|escape:'html'}</li>
                {/foreach}
                </ul>
            {/if}
            {Html->form action='/documents/wiki/tools/comment/confirm#form-comment'}
                {Html->hidden name='name' value=$wiki->name}
                {Html->hidden name='locale' value=$wiki->locale}
                <table class='form' id='form-comment'>
                    <tr>
                        <th class='required'>お名前</th>
                        <td class='input'>
                            {if $User->logined}
                                {$User->name|escape:'html'}
                            {else}
                                {Html->text name='cname' value=$request.cname|default:$cookie.name}
                            {/if}
                        </td>
                    </tr>
                    {if !$User->logined}
                        <tr>
                            <th class='required'>認証コード</th>
                            <td class='input'>
                                <img src='/etc/antispam?space=documents_wiki_comment' class='antispam' /><br />
                                {Html->text name='antispam'}
                            </td>
                        </tr>
                    {/if}
                    <tr>
                        <th class='required'>本文</th>
                        <td class='input'>
                            {Html->textarea name='comment' value=$request.comment}
                        </td>
                    </tr>
                    <tr>
                        <td class='submit' colspan='2'>
                            {Html->submit value='確認画面'}
                        </td>
                    </tr>
                </table>
            {/Html->form}
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

{**
 * community - forum - topic_reply_confirm.tpl
 *}
{assign_array var='html.title.' value='返信(確認)'}
{assign_array var='html.title.' value=$article->subject}
{assign_array var='html.title.' value=$forum->title}
{assign_array var='html.title.' value='フォーラム'}
{assign_array var='html.title.' value='コミュニティ'}
{include file='_header.tpl' action='community forum topic show reply'
    css='/css/layout/1column.standard.css, /css/action/community/forum.css'}
    <h1>フォーラム</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href='/community/index' value='コミュニティ'}<li>
        <li class='delimiter'>&gt;</li>
        <li>フォーラム<li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/community/forum/`$forum->id`" value=$forum->title}<li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/community/forum/`$forum->id`/topic/`$topic->id`" value=$article->subject}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>返信(確認)</li>
        <li class='clear'></li>
    </ul>

    <div id='main'>

        {** 詳細 **}
        <h2>{$forum->title|escape:'html'}</h2>
        <div class='description column'>
            {$forum->description|escape:'html'|nl2br}
        </div>

        {** 親記事 **}
        <div class='topic articles column'>
            <h3>親記事</h3>
            
            <table class='list'>
                <tr>
                    <th class='user'>投稿者</th><th class='contents'>内容</th>
                </tr>
                <tr class='even' id='article:{$article->id}'>
                    <td class='user'>
                        <span class='name'>{$article->name}</span><br />
                        <span class='role'>{$article->user_role}</span><br />
                        {if $article->mail && $article->mail_display}
                            <span class='mail'>{Html->mail to=$article->mail value=$article->mail}</span><br />
                        {/if}
                        <br />
                        <span class='date'>投稿日時：{$article->created_at|date_format:'%Y年%m月%d日 %H:%M'}</span><br />
                    </td>
                    <td class='contents'>
                        <div class='subject'>{$article->subject|escape:'html'}</div>
                        <div class='body'>
                            {$article->body|escape:'html'|nl2br}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {** 書き込み **}
        <div class='form-reply column'>
            <h3>以下の内容でよろしいでしょうか？</h3>
            {Html->form action='/community/forum/topic/reply/done'}
                {Html->hidden name='forum_id' value=$forum->id}
                {Html->hidden name='topic_id' value=$topic->id}
                {Html->hidden name=$token.name value=$token.value}
                {if $request.article_id}
                    {Html->hidden name='article_id' value=$article->id}
                {/if}
                <table class='form'>
                    {if !$User->logined}
                        <tr>
                            <th class='required'>名前</th>
                            <td class='input'>
                                {Html->hidden name='name' value=$request.name}
                                {$request.name|escape:'html'}
                            </td>
                        </tr>
                        <tr>
                            <th class='required'>メールアドレス</th>
                            <td class='input'>
                                {Html->hidden name='mail' value=$request.mail}
                                {Html->hidden name='mail_inform' value=$request.mail_inform|default:'0'}
                                {Html->hidden name='mail_display' value=$request.mail_display|default:'0'}
                                {$request.mail|escape:'html'}<br />
                                {if $request.mail}
                                    {if $request.mail_inform}
                                        返信があった時にメールで通知する
                                    {/if}
                                    {if $request.mail_inform && $request.mail_display} / {/if}
                                    {if $request.mail_display}
                                        メールアドレスを公開する
                                    {/if}
                                {/if}
                            </td>
                        </tr>
                    {/if}
                    <tr>
                        <th class='required'>件名</th>
                        <td class='input'>
                            {Html->hidden name='subject' value=$request.subject}
                            {$request.subject|escape:'html'}
                        </td>
                    </tr>
                    <tr>
                        <th class='required'>本文</th>
                        <td class='input'>
                            {Html->hidden name='body' value=$request.body}
                            {$request.body|escape:'html'|nl2br}
                        </td>
                    </tr>
                    {Html->hidden name='resolved' value=$request.resolved|default:'0'}
                    {if $request.resolved}
                        <tr>
                            <th>解決</th>
                            <td class='input'>
                                <span class='red'>解決にする</span>
                            </td>
                        </tr>
                    {/if}
                    <tr>
                        <td class='submit' colspan='2'>
                            {if $request.article_id}
                                {Html->submit value='戻る' dispatch='community_forum_topic_reply'}
                                {Html->submit value='返信する'}
                            {else}
                                {Html->submit value='戻る' dispatch='community_forum_topic_show'}
                                {Html->submit value='投稿する'}
                            {/if}
                        </td>
                    </tr>
                </table>
            {/Html->form}
        </div>

    </div>
{include file='_footer.tpl'}

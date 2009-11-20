{**
 * community - forum - topic_show.tpl
 *}
{assign_array var='html.title.' value=$topic->subject}
{assign_array var='html.title.' value=$forum->title}
{assign_array var='html.title.' value='フォーラム'}
{assign_array var='html.title.' value='コミュニティ'}
{include file='_header.tpl' action='community forum topic show'
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
        <li class='selected'>{$topic->subject|escape:'html'}</li>
        <li class='clear'></li>
    </ul>

    <div id='main'>

        {** 詳細 **}
        <h2>{$forum->title|escape:'html'}</h2>
        <div class='description column'>
            {$forum->description|escape:'html'|nl2br}
        </div>

        {** トピック一覧 **}
        <div class='topic articles column'>
            <h3>{$topic->subject|escape:'html'}</h3>
            
            <table class='list'>
                <tr>
                    <th class='user'>投稿者</th><th class='contents'>内容</th>
                </tr>
                {foreach from=$articles item='article' key='key'}
                    {if $key % 2}
                        {assign var='_class' value='odd'}
                    {else}
                        {assign var='_class' value='even'}
                    {/if}
                    <tr class='{$_class}' id='article:{$article.id}'>
                        <td class='user'>
                            {if $article.user_id}
                                <span class='name'>{Html->a href="/community/user/`$article.user_id`" value=$article.name}</span><br />
                            {else}
                                <span class='name'>{$article.name}</span><br />
                            {/if}
                            <span class='role'>{$article.user_role}</span><br />
                            {if $article.mail && $article.mail_display}
                                <span class='mail'>{Html->mail to=$article.mail value=$article.mail}</span><br />
                            {/if}
                            <br />
                            <span class='date'>投稿日時：{$article.created_at|date_format:'%Y年%m月%d日 %H:%I'}</span><br />
                        </td>
                        <td class='contents'>
                            <div class='subject'>
                                {Html->a href="/community/forum/`$article.forum_id`/topic/`$topic->id`#article:`$article.id`" value=$article.subject}
                            </div>
                            <ul class='menu'>
                                <li>
                                    {Html->a value='返信'
                                        href="/community/forum/topic/reply?forum_id=`$article.forum_id`&topic_id=`$topic->id`&article_id=`$article.id`"}
                                </li>
                                <li>/</li>
                                <li>
                                    {Html->a value='引用して返信'
                                        href="/community/forum/topic/reply?forum_id=`$article.forum_id`&topic_id=`$topic->id`&article_id=`$article.id`&quote=on"}
                                </li>
                            </ul>
                            <div class='body'>
                                {$article.body|escape:'html'|nl2br}
                            </div>
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>

        {** 書き込み **}
        <div class='form-reply column'>
            <h3>このトピックに書き込む</h3>
            {Html->form action='/community/forum/topic/reply/confirm'}
                {Html->hidden name='forum_id' value=$forum->id}
                {Html->hidden name='topic_id' value=$topic->id}
                <table class='form'>
                    {if !$User->logined}
                        <tr>
                            <th class='required'>名前</th>
                            <td class='input'>
                                {Html->text name='name' value=$request.name}
                            </td>
                        </tr>
                        <tr>
                            <th class='required'>メールアドレス</th>
                            <td class='input'>
                                {Html->text name='mail' value=$request.mail}<br />
                                {Html->checkbox name='mail_inform' value='1' label='返信があった時にメールで通知する' selected=$request.mail_inform} /
                                {Html->checkbox name='mail_display' value='1' label='メールアドレスを公開する' selected=$request.mail_display}
                            </td>
                        </tr>
                    {/if}
                    <tr>
                        <th class='required'>件名</th>
                        <td class='input'>
                            {Html->text name='subject' value=$request.subject|default:$subject}
                        </td>
                    </tr>
                    <tr>
                        <th class='required'>本文</th>
                        <td class='input'>
                            {Html->textarea name='body' value=$request.body}
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
{include file='_footer.tpl'}

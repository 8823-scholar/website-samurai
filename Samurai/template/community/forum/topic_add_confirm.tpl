{**
 * community - forum - topic_add_confirm.tpl
 *}
{assign_array var='html.title.' value='トピックの作成(確認)'}
{assign_array var='html.title.' value=$forum->title}
{assign_array var='html.title.' value='フォーラム'}
{assign_array var='html.title.' value='コミュニティ'}
{include file='_header.tpl' action='community forum topic show add'
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
        <li class='selected'>トピックの作成(確認)</li>
        <li class='clear'></li>
    </ul>

    <div id='main'>

        {** 詳細 **}
        <h2>{$forum->title|escape:'html'}</h2>
        <div class='description column'>
            {$forum->description|escape:'html'|nl2br}
        </div>

        {** トピックの作成 **}
        <div class='form-add column'>
            <h3>以下の内容でよろしいでしょうか？</h3>

            {Html->form action='/community/forum/topic/add/done'}
                {Html->hidden name='forum_id' value=$forum->id}
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
                    <tr>
                        <td class='submit' colspan='2'>
                            {Html->submit value='戻る' dispatch='community_forum_topic_add'}
                            {Html->submit value='作成する'}
                        </td>
                    </tr>
                </table>
            {/Html->form}
        </div>

    </div>
{include file='_footer.tpl'}

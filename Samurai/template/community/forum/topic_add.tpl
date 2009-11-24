{**
 * community - forum - topic_add.tpl
 *}
{assign_array var='html.title.' value='トピックの作成'}
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
        <li class='selected'>トピックの作成</li>
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
            <h3>トピックの作成</h3>

            {ErrorList->getMessages withkey=true assign='errors'}
            {Html->form action='/community/forum/topic/add/confirm'}
                {Html->hidden name='forum_id' value=$forum->id}
                <table class='form'>
                    {if !$User->logined}
                        <tr>
                            <th class='required'>名前</th>
                            <td class='input'>
                                {if $errors.name} <div class='error'>{$errors.name}</div> {/if}
                                {Html->text name='name' value=$request.name|default:$default.name}
                            </td>
                        </tr>
                        <tr>
                            <th class='required'>メールアドレス</th>
                            <td class='input'>
                                {if $errors.mail} <div class='error'>{$errors.mail}</div> {/if}
                                {Html->text name='mail' value=$request.mail|default:$default.mail}<br />
                                {Html->checkbox name='mail_inform' value='1' label='返信があった時にメールで通知する' selected=$request.mail_inform} /
                                {Html->checkbox name='mail_display' value='1' label='メールアドレスを公開する' selected=$request.mail_display}
                            </td>
                        </tr>
                    {/if}
                    <tr>
                        <th class='required'>件名</th>
                        <td class='input'>
                            {if $errors.subject} <div class='error'>{$errors.subject}</div> {/if}
                            {Html->text name='subject' value=$request.subject}
                        </td>
                    </tr>
                    <tr>
                        <th class='required'>本文</th>
                        <td class='input'>
                            {if $errors.body} <div class='error'>{$errors.body}</div> {/if}
                            {Html->textarea name='body' value=$request.body}
                        </td>
                    </tr>
                    {if !$User->logined}
                        <tr>
                            <th class='required'>認証</th>
                            <td class='input'>
                                {if $errors.antispam} <div class='error'>{$errors.antispam}</div> {/if}
                                <img src='/etc/antispam?space=forum_topic_add' class='antispam' /><br />
                                {Html->text name='antispam'}
                            </td>
                        </tr>
                    {/if}
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

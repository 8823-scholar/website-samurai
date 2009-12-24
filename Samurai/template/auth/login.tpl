{**
 * auth - login.tpl
 *}
{assign_array var='html.title.' value='ログイン'}
{include file='_header.tpl' action='auth'
    css='/css/layout/2column.standard.css, /css/action/auth.css'}
    <h1>ログイン</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>ログイン<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <div class='login column'>
            {if !$from_link}
                {ErrorList->getMessages withkey=true assign='errors'}
            {/if}
            {Html->form action='/auth/login'}
                {Html->hidden name='next' value=$request.next|default:'/'}
                <table class='form'>
                    <tr>
                        <th class='required'>ユーザー名</th>
                        <td class='input'>
                            {if $errors.name} <div class='error'>{$errors.name}</div> {/if}
                            {if $errors.authorize} <div class='error'>{$errors.authorize}</div> {/if}
                            {Html->text name='name' value=$request.name}
                        </td>
                    </tr>
                    <tr>
                        <th class='required'>パスワード</th>
                        <td class='input'>
                            {if $errors.pass} <div class='error'>{$errors.pass}</div> {/if}
                            {Html->password name='pass' value=$request.pass}
                        </td>
                    </tr>
                    <tr>
                        <td class='submit' colspan='2'>
                            {Html->checkbox name='hold' value='1' selected=$request.hold|default:'1' label='ログイン状態を維持する'}&nbsp;&nbsp;
                            {Html->submit value='ログイン'}
                        </td>
                    </tr>
                </table>
            {/Html->form}
        </div>
    </div>
    
    
    <div id='sidebar'>
        <div class='someone column'>
        </div>
    </div>
{include file='_footer.tpl'}

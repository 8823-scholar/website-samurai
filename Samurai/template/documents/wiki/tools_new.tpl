{**
 * documents - wiki - tools_new.tpl
 *}
{assign_array var='html.title.' value='新規ページ'}
{assign_array var='html.title.' value='ドキュメント'}
{include file='_header.tpl' action='documents wiki tools'
    css='/css/layout/2column.standard.css, /css/action/documents/wiki.css'}
    <h1>ドキュメント</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/documents/`$locale`/FrontPage" value='ドキュメント'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>新規作成<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>新規ページの作成</H2>
        <div class='new column'>
            {ErrorList->getMessages withkey=true assign='errors'}
            {Html->form action='/documents/wiki/tools/edit'}
                {Html->hidden name='locale' value=$locale}
                <table class='form'>
                    <tr>
                        <th class='required'>ページ名</th>
                        <td class='input'>
                            {if $errors.name} <div class='error'>{$errors.name}</div> {/if}
                            {Html->text name='name' value=$request.name|default:$wiki->name}
                            <p class='example'>
                                ページ名に使用できるのは英数字およびハイフン(-)、アンダースコア(_)、スラッシュ(/)のみです。
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class='submit' colspan='2'>
                            {Html->submit value='新規ページの作成'}
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

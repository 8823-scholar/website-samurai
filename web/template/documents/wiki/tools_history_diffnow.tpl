{**
 * documents - wiki - tools_history_diffnow.tpl
 *}
{assign_array var='html.title.' value='変更履歴(現在との差分)'}
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
        <li class='selected'>変更履歴(現在との差分)<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>{$wiki1->title|escape:'html'}の変更履歴(revision@{$request.rev})</H2>
        {include file='documents/wiki/_tools_history_menu.tpl' do=$request.do}

        <h2>現在との差分</h2>
        <div class='merge column'>
            <table class='diff'>
                <tr>
                    <th class='line'>orig</th><th class='line'>work</th><th></th>
                </tr>
                {$diff_html}
            </table>
        </div>
    </div>

    {include file='documents/wiki/_sidebar.tpl'}

{include file='_footer.tpl'}

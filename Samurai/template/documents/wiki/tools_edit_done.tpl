{**
 * documents - wiki - tools_edit_done.tpl
 *}
{assign_array var='html.title.' value='編集(完了)'}
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
        <li class='selected'>編集(完了)<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H2>{$request.title|escape:'html'}の編集</H2>
        <div class='edit done column'>
            <span class='wikiname'>{$request.title|escape:'html'}</span>の編集をおこないました。

            <ul class='actionos'>
                <li>{Html->a href="/documents/`$wiki->locale`/`$wiki->name_encoded`" value='戻る'}</li>
            </ul>
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

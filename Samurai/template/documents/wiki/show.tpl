{**
 * documents - wiki - show.tpl
 *}
{assign_array var='html.title.' value=$wiki->name}
{assign_array var='html.title.' value='ドキュメント'}
{include file='_header.tpl' action='documents wiki'
    css='/css/layout/1column.standard.css, /css/action/documents/wiki.css'}
    <h1>ドキュメント</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/documents/`$locale`/FrontPage" value='ドキュメント'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>{$wiki->title|escape:'html'}<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <H1>{$wiki->title|escape:'html'}</H1>
        <div class='show column'>
           {Wickey->render text=$wiki->content}
        </div>
    </div>
{include file='_footer.tpl'}

{**
 * community - forum - show.tpl
 *}
{assign_array var='html.title.' value='Q&A'}
{assign_array var='html.title.' value='フォーラム'}
{assign_array var='html.title.' value='コミュニティ'}
{include file='_header.tpl' action='community forum'
    css='/css/layout/1column.standard.css, /css/action/community/forum.css'}
    <h1>フォーラム - Q&amp;A</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href='/community/index' value='コミュニティ'}<li>
        <li class='delimiter'>&gt;</li>
        <li>フォーラム<li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>Q&amp;A<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>

        {** 詳細 **}
        <div class='detail column'>
        </div>

    </div>
{include file='_footer.tpl'}

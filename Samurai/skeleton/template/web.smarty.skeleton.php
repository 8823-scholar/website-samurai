{**
 * <?=join(' - ', $template_names)."\n"?>
 *}
{assign_array var='html.title.' value='タイトル'}
{include file='_header.tpl' action='index'
    css='/css/layout/2column.standard.css, /css/action/index.css'}
    <h1>タイトル</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>タイトル<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>

        <div class='someone column'>
        </div>

    </div>
    
    
    <div id='sidebar'>

        <div class='someone column'>
        </div>

    </div>
{include file='_footer.tpl'}

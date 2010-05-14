{**
 * community - forum - topic_add_done.tpl
 *}
{assign_array var='html.title.' value='トピックの作成(完了)'}
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
        <li class='selected'>トピックの作成(完了)</li>
        <li class='clear'></li>
    </ul>

    <div id='main'>

        {** 詳細 **}
        <h2>{$forum->title|escape:'html'}</h2>
        <div class='description column'>
            {$forum->description|escape:'html'|nl2br}
        </div>

        {** 完了 **}
        <div class='done column'>
            <h3>トピックの作成</h3>
            
            <p>
                トピックを作成しました。
            </p>

            <ul class='menu'>
                <li>{Html->a href="/community/forum/`$forum->id`/topic/`$topic->id`" value='作成したトピックへいく'}</li>
                <li>{Html->a href="/community/forum/`$forum->id`" value="フォーラム「`$forum->title`」へ戻る"}</li>
            </ul>
        </div>

    </div>
{include file='_footer.tpl'}

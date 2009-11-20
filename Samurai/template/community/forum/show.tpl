{**
 * community - forum - show.tpl
 *}
{assign_array var='html.title.' value=$forum->title}
{assign_array var='html.title.' value='フォーラム'}
{assign_array var='html.title.' value='コミュニティ'}
{include file='_header.tpl' action='community forum show'
    css='/css/layout/1column.standard.css, /css/action/community/forum.css'}
    <h1>フォーラム</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href='/community/index' value='コミュニティ'}<li>
        <li class='delimiter'>&gt;</li>
        <li>フォーラム<li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>{$forum->title|escape:'html'}<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>

        {** 詳細 **}
        <h2>{$forum->title|escape:'html'}</h2>
        <div class='description column'>
            {$forum->description|escape:'html'|nl2br}
        </div>

        {** トピック一覧 **}
        <div class='topics column'>
            <h3>トピック一覧</h3>
            
            <ul class='menu'>
                <li>{Html->a href='/community/forum/topic/add' value='トピックの作成'}</li>
            </ul>
            
            <table class='list'>
                <tr>
                    <th class='topic'>題名/トピック情報</th><th class='article'>投稿数</th><th class='last-replied'>最新の投稿</th>
                </tr>
                {foreach from=$topics item='topic'}
                    <tr>
                        <td class='topic'>
                            <span class='subject'>
                                {Html->a href="/community/forum/`$topic.forum_id`/topic/`$topic.id`" value=$topic.subject}
                            </span><br />
                            <span class='body'>{$topic.body|truncate:64|escape:'html'}</span>
                            <div class='by at text-right'>
                                {if $topic.user_id}
                                    by {Html->a href="/community/user/`$topic.user_id`" value=$topic.name}
                                {else}
                                    by {$topic.name|escape:'html'}
                                {/if}
                                ({$topic.created_at|date_format:'%Y年%m月%d日 %H:%I'})
                            </div>
                        </td>
                        <td class='articles'>
                            {$topic.reply_count}件の投稿
                        </td>
                        <td class='last-replied'>
                            {if $topic.last_article}
                                <em>最新の投稿</em>
                                <span class='by'>by {$topic.last_article.name}</span><br />
                                <span class='subject'>
                                    {Html->a href="/community/forum/`$topic.forum_id`/article/`$topic.last_article.id`" value=$topic.last_article.subject}
                                </span><br />
                                <span class='date'>{$topic.last_replied_at|date_format:'%Y年%m月%d日 %H:%I'}</span>
                            {/if}
                        </td>
                    </tr>
                {foreachelse}
                    nothing...
                {/foreach}
            </table>
        </div>

    </div>
{include file='_footer.tpl'}

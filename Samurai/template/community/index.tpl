{**
 * community - index.tpl
 *}
{assign_array var='html.title.' value='コミュニティ'}
{include file='_header.tpl' action='community'
    css='/css/layout/1column.standard.css, /css/action/community.css'}
    <h1>コミュニティ</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>コミュニティ<li>
        <li class='clear'></li>
    </ul>
    
    <div id='main'>
        {** 見出し **}
        <div class='introduction column'>
            <h2>コミュニティ サポート</h2>
            <p>
                ユーザーコミュニティです。<br />
                分からないことや質問点、Samurai Frameworkへの意見などは、是非フォーラムへお寄せください。
            </p>
        </div>

        {** フォーラム **}
        <div class='forum column'>
            <h3>フォーラム</h3>
            <p>
                Samurai Frameworkへの質問や意見、Q&amp;Aなどはこちらからどうぞ！<br />
                関係者からの迅速なレスポンスがあります。<br />
                または、親切な第三者の方が回答していただけるかもしれません。
            </p>

            <h4>フォーラム一覧</h4>
            <table class='list forums'>
                {*
                <tr>
                    <th class='forum'>フォーラム</th><th class='articles'>投稿数</th><th class='date'>最新の投稿</th>
                </tr>
                *}
                {foreach from=$forums item='forum'}
                    <tr>
                        <td class='forum'>
                            <div class='title'>{Html->a href="/community/forum/`$forum.id`" value=$forum.title}</div>
                            <div class='description'>{$forum.description|escape:'html'|nl2br}</div>
                        </td>
                        <td class='articles'>
                            {$forum.article_count}件の投稿<br />
                            {$forum.topic_count}件のトピック
                        </td>
                        <td class='last-posted'>
                            {if $forum.last_posted}
                                <em>最新の投稿</em>
                                <span class='by'>by {$forum.last_article.name|escape:'html'}</span><br />
                                <span class='subject'>{Html->a href="/community/forum/`$forum.id`/article/`$forum.last_article.id`" value=$forum.last_article.subject}</span><br />
                                <span class='date'>投稿日：{$forum.last_posted|date_format:'%Y年%m月%d日 %H:%I'}<br />
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </table>

            <h4>最新の書き込み</h4>
            <table class='list nearly'>
                <tr>
                    <th class='subject'>件名</th><th class='forum'>フォーラム</th><th class='date'>投稿時間</th>
                </tr>
                {section loop=10 name='forums'}
                    <tr> 
                        <td class='subject'>
                            {Html->a href="/community/forum/1/article/1" value='インストールできません。'}
                            <span class='user'>(by hayabusa)</span>
                        </td>
                        <td class='forum'>{Html->a href="/community/forum/1" value='Q&A'}</td>
                        <td class='date'>2009-11-15 11:55 </td>
                    </tr>
                {/section}
            </table>
        </div>
    </div>
{include file='_footer.tpl'}

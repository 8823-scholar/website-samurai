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
                            {if $forum.last_posted_at}
                                <em>最新の投稿</em>
                                <span class='by'>by {$forum.last_article.name|escape:'html'}</span><br />
                                <span class='subject'>
                                    {if $forum.last_article.root_id}
                                        {Html->a value=$forum.last_article.subject
                                            href="/community/forum/`$forum.id`/topic/`$forum.last_article.root_id`?page=`$forum.last_article.page`#article:`$forum.last_article.id`"}
                                    {else}
                                        {Html->a href="/community/forum/`$forum.id`/topic/`$forum.last_article.id`" value=$forum.last_article.subject}
                                    {/if}
                                </span><br />
                                <span class='date'>投稿日：{$forum.last_posted_at|date_format:'%Y年%m月%d日 %H:%M'}</span><br />
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>


        {** イベント **}
        <div class='event column'>
            <h3>イベント</h3>
            <p>
                Samurai Frameworkに関するイベントはコチラ！
            </p>

            <h4>最新のイベント</h4>
            <table class='list'>
                {foreach from=$events item='event'}
                    <tr>
                    </tr>
                {foreachelse}
                    <tr>
                        <td class='none' colspan='2'>まだありません。</td>
                    </tr>
                {/foreach}
            </table>
        </div>


        {** その他 **}
        <div class='other column'>
            <h3>その他</h3>

            <h4>メーリングリスト</h4>
            <ul>
                <li>
                    <a href='http://lists.sourceforge.jp/mailman/listinfo/samurai-user'>samurai-user@lists.sourceforge.jp</a>
                    <p>
                        ユーザー用メーリングリストです。<br />
                        ユーザー同士での助け合いや、コミュニティにご活用ください。
                    </p>
                </li>
                <li>
                    <a href='http://lists.sourceforge.jp/mailman/listinfo/samurai-dev'>samurai-dev@lists.sourceforge.jp</a>
                    <p>
                        開発者用メーリングリストです。<br />
                        開発に関する内容はコチラに投稿ください。
                    </p>
                </li>
            </ul>
        </div>
    </div>
{include file='_footer.tpl'}

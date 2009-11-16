{**
 * community - index.tpl
 *}
{assign_array var='html.title.' value='コミュニティ'}
{include file='_header.tpl' action='community'
    css='/css/layout/2column.standard.css, /css/action/community.css'}
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
                <tr>
                    <th class='forum'>フォーラム</th><th class='topics'>トピック</th><th class='articles'>投稿数</th><th class='date'>最終投稿</th>
                </tr>
                {section loop=4 name='formus'}
                    <tr>
                        <td class='forum'>
                            <div class='title'>{Html->a href="/community/forum/1" value='Q&A'}</div>
                            <div class='description'>わからないことはここへ書き込んでください。</div>
                        </td>
                        <td class='topics'>12</td>
                        <td class='articles'>12</td>
                        <td class='date'>2009-11-15 12:20</td>
                    </tr>
                {/section}
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
    
    
    <div id='sidebar'>

        <div class='someone column'>
        </div>

    </div>
{include file='_footer.tpl'}

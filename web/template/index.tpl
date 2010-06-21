{**
 * index.tpl
 *}
{include file='_header.tpl' action='index'
    css='/css/layout/2column.standard.css, /css/action/index.css'}
    {** TOPイメージ **}
    <div id='topimage'>
        <ul class='main'>
            <li class='download'>
                {Html->a href="/package/samurai/`$release->version`-`$release->stability`/files"
                            value="SamuraiFWをダウンロード<br /><span class='version'>Version `$release->version`-`$release->stability`</span>" escape=false}
            </li>
        </ul>
        <ul class='sub'>
            {*<li>{Html->a href="/development/wiki/changelog/`$release->version`" value='変更ログ'}</li>*}
            <li>{Html->a href='/documents/ja/install#quick' value='クイックインストール'}</li>
            <li>{Html->a href='/documents/ja/install#upgrade' value='アップグレード方法'}</li>
            {if $release_dev}
                <li>{Html->a href="/package/samurai/`$release_dev->version`-`$release_dev->stability`/files"
                        value="開発版ダウンロード(`$release_dev->version`-`$release_dev->stability`)"}</li>
            {/if}
            <li class='blank'></li>
            <li>{Html->a href='/about/samuraifw' value='Samurai Frameworkとは？'}</li>
            <li>{Html->a href='/community/index' value='ユーザーコミュニティ'}</li>
        </ul>
    </div>
    
    
    <div id='main'>
        {** ようこそ **}
        <div class='welcome column'>
            <h2>ようこそ！Samurai Frameworkプロジェクトへ！</h2>
            <h3>- 驚くほどストイックな国産フレームワークが登場 -</h3>
            <p>
                Samurai Frameworkは、PHPのためのフルスタック・ウェブアプリケーションフレームワークです。
                単純な仕組みでありながら柔軟性に富み、高いメンテナンス力を誇っています。<br />
                また、Ruby on Railsなどを代表とする他フレームワークも採用しているように、Samuraiでも
                <em>MVC</em>(モデル・ビュー・コントローラー) / <em>ORM</em>(O/Rマッピング) / <em>CoC</em>(Convention Over Configuration = 設定より規約)などの優れたアーキテクチャや手法を踏襲しています。
            </p>
        </div>

        {** ポイント **}
        <div class='points column'>
            <ul>
                <li><h3>Samurai Frameworkを使用して幸せになれる10のポイント</h3></li>
                <ul class='left'>
                    <li><em>MVC</em>(モデル・ビュー・コントローラー)に自然と分かれる構造で、見通しのよいプロジェクトに。</li>
                    <li><em>O/Rマッパー</em>「<em>ActiveGateway</em>」による直感的なデータ操作。</li>
                    <li><em>CoC</em>(Convention Over Configuration)設計によってサクサク開発＆がっつりカスタマイズの二面性の実現。</li>
                    <li><em>DIContainer</em>(Dependency Injection = 依存性注入)がコンポーネント間の依存関係を自動的に解決。</li>
                    <li>コアクラスさえもコンポーネントの一つに過ぎない徹底されたコンポーネント指向だから、コアクラスの差し替えも簡単。</li>
                </ul>
                <ul class='right'>
                    <li>強力なマッチング機能を持った<em>URLルーティング。</em></li>
                    <li>国際化(i18n)にも完全対応(準備中です&lt;&gt;)。</li>
                    <li>PHPSpecなどのテストツールとデフォルトで連動しているので、テストが楽しい！<em>積極的なリファクタリング</em>が可能です。</li>
                    <li>コードジェネレイターで開発速度が大幅にアップします。</li>
                    <li>携帯サイト対応もフレームワークでサポート！</li>
                    <li>充実したドキュメント＆サポート体制。オール日本語での対応が可能です（英語は頑張ります）。</li>
                </ul>
                <div class='clear'></div>
            </ul>
        </div>
    </div>
    
    
    <div id='sidebar'>
        {** 最近の投稿 **}
        <div class='nearly_posted column'>
            <h4>コミュニティへの最近の投稿</h4>
            <ul>
            {foreach from=$articles item='article'}
                <li>
                    <span class='date'>{$article.created_at|date_format:'%Y.%m.%d %H:%I'}</span><br />
                    {if !$article.root_id}
                        <span class='subject'>{Html->a href="/community/forum/`$article.forum_id`/topic/`$article.id`" value=$article.subject|truncate:64}</span>
                    {else} 
                        <span class='subject'>{Html->a href="/community/forum/`$article.forum_id`/topic/`$article.root_id`#article:`$article.id`"
                                                    value=$article.subject|truncate:64}</span>
                    {/if}
                </li>
            {foreachelse}
                <li class='none'>まだ書き込みはありません(´；ω；｀)ﾌﾞﾜｯ</li>
            {/foreach}
            </ul>
        </div>
    </div>
{include file='_footer.tpl' built_on_samurai=true}

{**
 * index.tpl
 *}
{include file='_header.tpl' action='index'
    css='/css/layout/2column.standard.css, /css/action/index.css'}
    {** TOPイメージ **}
    <div id='topimage'>
        <ul class='main'>
            <li class='download'>
                {Html->a href='/downloads/latest' value="SamuraiFWをダウンロード<br /><span class='version'>Version 2.0.0-stable</span>" escape=false}
            </li>
        </ul>
        <ul class='sub'>
            <li>{Html->a href='/trac/wiki/changelog/2.x.x' value='変更ログ'}</li>
            <li>{Html->a href='/documents/tutorial/upgrade' value='アップグレード方法'}</li>
            <li>{Html->a href='/documents/tutorial/install#quick' value='クイックインストール'}</li>
            <li>{Html->a href='/downloads/version/2.1.0-alpha' value='開発版ダウンロード(2.1.0-alpha)'}</li>
            <li class='blank'></li>
            <li>{Html->a href='/about/samurai' value='Samurai Frameworkとは？'}</li>
            <li>{Html->a href='/community/index' value='ユーザーコミュニティ'}</li>
        </ul>
    </div>
    
    
    <div id='main'>
        {** ようこそ **}
        <div class='welcome column'>
            <h2>ようこそ！Samurai Frameworkプロジェクトへ！</h2>
            <h3>- 驚くほどストイックな国産フレームワークが誕生 -</h3>
            <p>
                Samurai Frameworkは、PHPのためのフルスタック・ウェブアプリケーションフレームワークです。
                単純な仕組みでありながら柔軟性に富み、高いメンテナンス力を誇っています。<br />
                また、Ruby on Railsなどを代表とする他フレームワークも採用しているように、Samuraiでも
                <em>MVC</em>(モデル・ビュー・コントローラー) / <em>ORM</em>(O/Rマッピング) / <em>CoC</em>(Convention Over Configuration = 設定より規約)構造を踏襲しています。
            </p>
        </div>

        {** ポイント **}
        <div class='points column'>
            <ul>
                <li><h3>Samurai Frameworkを使用して幸せになれる10のポイント</h3></li>
                <ul class='left'>
                    <li>MVC(モデル・ビュー・コントローラー)に自然と分かれる構造で、見通しのよいプロジェクトに。</li>
                    <li>O/Rマッパー「ActiveGateway」による直感的なデータ操作。</li>
                    <li>CoC(Convention Over Configuration)設計によってサクサク開発＆がっつりカスタマイズの二面性の実現。</li>
                    <li>DIContainer(Dependency Injection = 依存性注入)がコンポーネント間の依存関係を自動的に解決。</li>
                    <li>コアクラスさえもコンポーネントの一つに過ぎない徹底されたコンポーネント指向だから、コアクラスの差し替えも簡単。</li>
                </ul>
                <ul class='right'>
                    <li>国際化(i18n)にも完全対応。</li>
                    <li>PHPSpecなどのテストツールとデフォルトで連動しているので、テストが楽しい！積極的なリファクタリングが可能です。</li>
                    <li>コードジェネレイターで開発速度が大幅にアップします。</li>
                    <li>携帯サイト対応もフレームワークが正式サポート！</li>
                    <li>充実したドキュメント＆サポート体制。オール日本語での対応が可能です（英語でももちろん可能です）。</li>
                </ul>
                <div class='clear'></div>
            </ul>
        </div>
    </div>
    
    
    <div id='sidebar'>
        
    </div>
{include file='_footer.tpl'}

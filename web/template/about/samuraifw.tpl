{**
 * about - samuraifw.tpl
 *}
{assign_array var='html.title.' value='概要'}
{include file='_header.tpl' action='about samuraifw'
    css='/css/layout/1column.standard.css, /css/action/about.css'}
    <h1>概要</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>概要<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>概要</h2>
        
        <div class='base column'>
            <h3>基本的な特徴</h3>
            <ul>
                <ul>
                    <li>PHPフレームワーク<em>Maple</em>の後継的フレームワーク</li>
                    <li><em>MVC</em>(Model, View, Controller)構造</li>
                    <li><em>CoC</em>(Convention Over Configuration)設計</li>
                    <li><em>O/Rマッパー</em>「Active Gateway」付属</li>
                    <li><em>DIContainer</em>によるオブジェクトの依存性注入と初期化処理の自動化</li>
                    <li>コアクラスもコンポーネントの一つにすぎないという、徹底されたコンポーネント指向</li>
                    <li>国際化(<em>i18n</em>)機能も充実(準備中)</li>
                    <li>携帯への対応もサポート</li>
                    <li>コードジェネレータによる完全自動化されたコード生成</li>
                    <li>PHPSpecなどのテストツールとデフォルトで連動</li>
                </ul>
            </ul>
        </div>

        <div class='addtional column'>
            <h3>付加的な価値</h3>
            <ul>
                <ul>
                    <li>開発者の熱意が<em>すごすぎる</em></li>
                    <li>国産だから、日本人にやさしい<em>日本語ベースの充実したサポート</em></li>
                    <li><em>開発議論は常にオープン</em>にするので、今後の見通しが立てやすい</li>
                </ul>
            </ul>
        </div>

        <h2>謝辞</h2>
        <div class='thank column'>
            <p>
                Samurai Frameworkは、PHPフレームワークMapleを強くリスペクトしています。<br />
                全体的な構造、DIContainerという要素または仕組み、ActiveGatewayという同名のO/Rマッパーなど、
                Mapleとの共通点は数えきれないほど存在しています。<br />
                これは、メインの開発者である木内智史之介(hayabusa)が元Mapleのコミッタであったという事実に由来しています。<br />
                <br />
                木内智史之介がMapleに出会わなければ、また、Mapleのコミッタとして開発に参加していなければ、Samurai Frameworkは誕生しなかったと思います。<br />
                Mapleへの心からの感謝の意と、尊敬の意をここに表します。<br />
            </p>
        </div>
    </div>
{include file='_footer.tpl'}

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
        <div class='column welcome'>
            <h2>ようこそ！Samurai Frameworkプロジェクトへ！</h2>
            <p>
                Samurai Frameworkは、PHPのためのフルスタック・ウェブアプリケーションフレームワークです。
                単純な仕組みでありながら柔軟性に富み、高いメンテナンス力を誇っています。<br />
                また、Ruby on Railsなどを代表とする他フレームワークも採用しているように、SamuraiでもMVC/ORM/CoC構造を踏襲しています。
            </p>
        </div>
    </div>
    
    
    <div id='sidebar'>
        
    </div>
{include file='_footer.tpl'}

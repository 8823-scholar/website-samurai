{**
 * about - us.tpl
 *}
{assign_array var='html.title.' value='Samurai Framework Project'}
{include file='_header.tpl' action='about us'
    css='/css/layout/1column.standard.css, /css/action/about.css'}
    <h1>Samurai Framework Project</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>Samurai Framework Projectとは<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>Samurai Framework Projectとは</h2>
        
        <div class='purpose column'>
            <h3>目的</h3>
            <p>
                Samurai Framework Projectは、Samurai Frameworkの開発、メンテナンス、およびユーザーサポートを行うために組織されました。<br />
                Samurai Frameworkの国内普及をおもな目的とし、日本を代表するオープンソースのプロジェクトとなるよう努力いたします。<br />
                また、国際的な競争力を持てることを長期的な目標とします。<br />
            </p>
        </div>

        <div class='member column'>
            <h3>メンバー</h3>
            <ul>
                <li>木内智史之介(hayabusa) <span class='mail'>&lt;{Html->mail to='scholar@hayabusa-lab.jp' value='scholar@hayabusa-lab.jp'}&gt;</span></li>
                <li>if真下 <span class='mail'>&lt;{Html->mail to='hisayuki.mashimo@befool.co.jp' value='hisayuki.mashimo@befool.co.jp'}&gt;</span></li>
                <li>海老壱 <span class='mail'>&lt;{Html->mail to='zato.ebi1@gmail.com' value='zato.ebi1@gmail.com'}&gt;</span></li>
                <li>ザザミン <span class='mail'>&lt;{Html->mail to='zazamin@zazamin.jp' value='zazamin@zazamin.jp'}&gt;</span></li>
            </ul>
            <p>
                私たちは、常に新しい仲間を募集しています。<br />
                興味が湧いた方は{Html->mail to='scholar@hayabusa-lab.jp' value='コチラ'}までご連絡ください！<br />
            </p>
        </div>
    </div>
{include file='_footer.tpl'}

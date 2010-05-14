{**
 * etc - donate
 *}
{assign_array var='html.title.' value='寄付'}
{include file='_header.tpl' action='index'
    css='/css/layout/2column.standard.css, /css/action/etc/donate.css'}
    <h1>寄付</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>寄付<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <div class='someone column'>
            <h2>寄付について</h2>
            <p>
                Samurai Framework Project では、常に寄付を募集しております。<br />
            </p>
            <h3>経費の内訳</h3>
            <ul>
                <li>サーバー維持費</li>
                <li>通信費</li>
            </ul>
            <br />
            <p>
                寄付していただいた金額の用途に関しては、常にこのWEBページ上で収支の報告をしていきます。<br />
                また、もしよろしければ、寄付していただいた方のお名前を、このページに表示させていただければと思います。<br />
            </p>
        </div>
    </div>
    
    
    <div id='sidebar'>
        <div class='someone column'>
        </div>
    </div>
{include file='_footer.tpl'}


{**
 * _footer.tpl
 *}
                <div class='clear'></div>
            </div>
            <div class='bottom'></div>
        </div>
        
        
        {** フッター **}
        <div id='footer'>
            {** Samuraiで作成されたサイト **}
            {if $built_on_samurai}
                <div class='built_on_samurai'>
                    <h5>SamuraiFWで構築されたサイト</h5>
                    <ul>
                        <li>{Html->a href='/' value='Samurai Framework ( this page is. )'}</li>
                        <li>{Html->a href='http://bokumachi.jp/machi/koenji' value='ぼくらの街 高円寺'}</li>
                        <li>{Html->a href='http://ithink-ican.jp/' value='I think I can !'}</li>
                    </ul>
                </div>
            {/if}

            {** コピーライト+α ***}
            <ul class='abouts'>
                <li>{Html->a href='/about/us' value='Samurai Framework Project'}</li>
                <li>&nbsp;|&nbsp;{Html->a href='/about/privacy' value='プライバシーポリシー'}</li>
            </ul>
            <div class='copyright'>
                Copyright &copy; 2009. {Html->a href='/about/us' value='Samurai Framework Project'}. All rights reserved.
            </div>
            
            <div class='clear'></div>
        </div>
        
    </div>

    {** Analytics **}
    {literal}
    <script type='text/javascript'>
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        try {
            var pageTracker = _gat._getTracker('UA-11073209-3');
            pageTracker._trackPageview();
        } catch(err) {}
    </script>
    {/literal}

    </body>
</html>

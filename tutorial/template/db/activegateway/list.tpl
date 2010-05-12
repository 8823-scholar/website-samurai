{**
 * validate
 *}
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
<html lang='ja-JP'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <link rel='stylesheet' type='text/css' href='/samurai/samurai.css' />
        <title>ActiveGateway - サンプル - チュートリアル - | Samurai Framework</title>
    </head>
    <body>
        <h1>Hello! Samurai!</h1>
        
        <h2>あなたのお名前を教えてください</h2>
        {ErrorList->getMessages assign='errors'}
        {if $errors}
            <ul class="errors">
            {foreach from=$errors item='error'}
                <li>{$error|escape}</li>
            {/foreach}
            </ul>
        {/if}
        
        <form action="" method="POST">
            <input type="hidden" name="action" value="db_activegateway_post" />
            私の名前は、<input type="text" name="name" />です。
            <input type="submit" value="送信する" />
        </form>

        <ul class='footstamps'>
        {foreach from=$footstamps item='stamp'}
            <li>{$stamp.name|escape} ({$stamp.created_at|date_format:'%Y/%m/%d %H:%M:%S'})</li>
        {foreachelse}
            <li>あしあとはまだありません。</li>
        {/foreach}
        </ul>
    </body>
</html>


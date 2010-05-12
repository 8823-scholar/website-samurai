{**
 * db - activegateway - post
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

        <h2>あなたの名前は以下のとおりですか？</h2>
        <p>
            ありがとう。あなたの名前は「{$request.name|escape}」ですね？<br />
            <a href="?action=db_activegateway_list">戻る</a>
        </p>
    </body>
</html>


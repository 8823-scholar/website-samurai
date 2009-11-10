{**
 * _header.tpl
 *}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" dir="ltr">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="/css/layout.css" />
        <title>Samurai Framework</title>
    </head>
    <body>
    <div id='samurai'>
        <H1>Samurai Framework is PHP Web Aplication Framework.</H1>
        
        {** ヘッダー **}
        <div id='header'>
            <ul class='menu left'>
                <li>{Html->A href='/' value='SamuraiFW' class='with-icon samurai'}</li>
                <li>{Html->A href='/about/samurai' value='概要'}</li>
                <li>{Html->A href='/downloads/index' value='ダウンロード'}</li>
                <li>{Html->A href='/documents/api' value='API'}</li>
                <li>{Html->A href='/documents/index' value='ドキュメント'}</li>
                <li>{Html->A href='/development/index' value='開発'}</li>
                <li>{Html->A href='/community/index' value='コミュニティ'}</li>
            </ul>
            
            <ul class='menu right'>
                <li>{Html->A href='/auth/login' value='ログイン'}</li>
                <li>{Html->A href='/etc/donate' value='寄付'}</li>
            </ul>
        </div>
        
        
        {** コンテンツ **}
        <div id='contents'>
            <div class='words'>
                世の人は 我をなんとも 言わば言え 我為すことは 我のみぞ知る <span class='name'>by 坂本竜馬</span>
            </div>

{**
 * _header.tpl
 *}
<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='ja' dir='ltr'>
    <head>
        <meta http-equiv='content-type' content='application/xhtml+xml; charset=UTF-8' />
        {foreach from=$html.metas item='meta'}
            <meta http-equiv='{$meta.key|escape:"html"}' content='{$meta.value|escape:"html"}' />
        {/foreach}
        
        {Html->load type='css' file='/css/reset.css'}
        {Html->load type='css' file='/css/base.css'}
        {Html->load type='css' file='/css/common.css'}
        {Html->load type='css' file=$css|default:'/css/layout/standard.css'}
        {Html->load type='css' file='/css/wickey.css'}
        
        {if $js}
            {Html->load type='javascript' file=$js}
        {/if}
        
        {assign_array var='html.title.' value='Samurai Framework'}
        {assign_array var='html.title.' value='PHP WEB Framework'}
        <title>{$html.title|@join:' | '|escape:'html'}</title>
    </head>
    <body>
    <div id='samurai'>
        {** ヘッダー **}
        <div id='header'>
            <ul class='menu left'>
                <li>{Html->a href='/' value='SamuraiFW' class='with-icon samurai'}</li>
                <li>{Html->a href='/about/samuraifw' value='概要'}</li>
                <li>{Html->a href='/package/releases' value='ダウンロード'}</li>
                <li>{Html->a href='/source/api/2.0/' value='API'}</li>
                <li>{Html->a href='/documents/ja/FrontPage' value='ドキュメント'}</li>
                <li>{Html->a href='/development/' value='開発'}</li>
                <li>{Html->a href='/community/index' value='コミュニティ'}</li>
            </ul>
            
            <ul class='menu right'>
                <li>{Html->a href='/etc/donate' value='寄付'}</li>
                {if $User->logined}
                    <li>{Html->a href='/auth/login' value='ログイン'}</li>
                {else}
                    <li>{Html->a href='/auth/logout' value='ログアウト'}</li>
                    <li>ようこそ！{$User->name|escape:'html'}さん</li>
                {/if}
            </ul>
            
            <div class='clear'></div>
        </div>
        
        
        {** コンテンツ **}
        <div id='contents' class='{$action|default:"someaction"}'>
            <div class='top haiku'>
                <span class='phrase'>世の人は 我をなんとも 言わば言え 我為すことは 我のみぞ知る</span>
                <span class='composed_by'>by 坂本竜馬</span>
                <div class='clear'></div>
            </div>
            <div class='middle'>

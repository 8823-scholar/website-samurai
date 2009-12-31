{**
 * package - download_page.tpl
 *}
{assign var='_download_url' value="/package/`$package->alias`/`$release->version`-`$release->stability`/file/`$file->filename`"}
{assign_array var='html.title.' value='ダウンロード'}
{assign_array var='html.title.' value="`$package->name` version:`$release->version`"}
{assign_array var='html.title.' value='パッケージ'}
{assign_array var='html.metas.0.key' value='refresh'}
{assign_array var='html.metas.0.value' value="1; url=`$_download_url`"}
{include file='_header.tpl' action='package download'
    css='/css/layout/1column.standard.css, /css/action/package.css'}
    <h1>ダウンロード</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href='/package/releases' value='ダウンロード'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/package/`$package->alias`/releases" value=$package->name}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/package/`$package->alias`/`$release->version`-`$release->stability`/files" value="`$release->version`-`$release->stability`"}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>ダウンロード({$file->filename|escape:'html'})<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>{$package->name|escape:'html'} version:{$release->version}</h2>

        <div class='adsense column'>
            <h3>ダウンロード</h3>
            <p>
                現在<span class='filename'>{$file->filename}</span>をダウンロードしています。<br />
                しばらくしてもダウンロード開始されない場合、{Html->a href=$_download_url value='コチラ'}からダウンロードしてください。
            </p>
            <div class='adsense-unit'>
            </div>
        </div>

    </div>
{include file='_footer.tpl'}

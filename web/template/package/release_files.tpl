{**
 * package - release_files.tpl
 *}
{assign_array var='html.title.' value='ファイル一覧'}
{assign_array var='html.title.' value="`$release->version`-`$release->stability`"}
{assign_array var='html.title.' value=$package->name}
{include file='_header.tpl' action='package releases'
    css='/css/layout/1column.standard.css, /css/action/package.css'}
    <h1>ファイル一覧</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href='/package/releases' value='ダウンロード'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href="/package/`$package->alias`/releases" value=$package->name}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>ファイル一覧({$release->version}-{$release->stability})<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>ファイル一覧</h2>
        <div class='packages column'>
            <table class='list'>
                <tr>
                    <th class='name'>{$package->name|escape:'html'}</th>
                    <th class='size'>サイズ</th>
                    <th class='downloaded_count'>ダウンロード数</th>
                </tr>
                <tr class='{$release->stability}'>
                    <td class='version stability'>
                        {$release->version}-{$release->stability}
                    </td>
                    <td class='datetime' colspan='2'>
                        {$release->datetime|date_format:'%Y年%m月%d日 %H:%M'}
                    </td>
                </tr>
                {foreach from=$files item='file'}
                    <tr>
                        <td class='filename'>
                            {Html->a href="/package/`$package->alias`/`$release->version`-`$release->stability`/file/`$file.filename`/download" value=$file.filename}
                        </td>
                        <td class='size'>{$file.size|bytes}</td>
                        <td class='downloaded_count'>{$file.downloaded_count}</td>
                    </tr>
                {/foreach}
            </table>
        </div>

    </div>
{include file='_footer.tpl'}

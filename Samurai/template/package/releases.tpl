{**
 * package - releases.tpl
 *}
{assign_array var='html.title.' value='最新のリリース'}
{include file='_header.tpl' action='package releases'
    css='/css/layout/1column.standard.css, /css/action/package.css'}
    <h1>最新のリリース</h1>
    <ul class='breads'>
        <li>{Html->a href='/' value='ホーム'}</li>
        <li class='delimiter'>&gt;</li>
        <li>{Html->a href='/package/releases' value='ダウンロード'}</li>
        <li class='delimiter'>&gt;</li>
        <li class='selected'>最新のリリース<li>
        <li class='clear'></li>
    </ul>

    <div id='main'>
        <h2>最新のリリース</h2>
        <div class='packages column'>
            <table class='list'>
            {foreach from=$packages item='package'}
                <tr>
                    <th class='name'>{$package.name|escape:'html'}</th>
                    <th class='size'>サイズ</th>
                    <th class='downloaded_count'>ダウンロード数</th>
                </tr>

                {** stable **}
                {if $package.stable}
                    <tr class='stable'>
                        <td class='version stability'>
                            {$package.stable.version}-{$package.stable.stability}
                        </td>
                        <td class='datetime' colspan='2'>
                            {$package.stable.datetime|date_format:'%Y年%m月%d日 %H:%I'}
                        </td>
                    </tr>
                    {foreach from=$package.stable.files item='file'}
                        <tr>
                            <td class='filename'>
                                {Html->a href="/package/`$package.alias`/`$package.stable.version`-`$package.stable.stability`/file/`$file.filename`/download"
                                            value=$file.filename}
                            </td>
                            <td class='size'>{$file.size|bytes}</td>
                            <td class='downloaded_count'>{$file.downloaded_count}</td>
                        </tr>
                    {/foreach}
                {/if}

                {** unstable **}
                {if $package.unstable}
                    <tr class='unstable'>
                        <td class='version stability'>
                            {$package.unstable.version}-{$package.unstable.stability}
                        </td>
                        <td class='datetime' colspan='2'>
                            {$package.unstable.datetime|date_format:'%Y年%m月%d日 %H:%I'}
                        </td>
                    </tr>
                    {foreach from=$package.unstable.files item='file'}
                        <tr>
                            <td class='filename'>
                                {Html->a href="/package/`$package.alias`/`$package.unstable.version`-`$package.unstable.stability`/file/`$file.filename`/download"
                                            value=$file.filename}
                            </td>
                            <td class='size'>{$file.size|bytes}</td>
                            <td class='downloaded_count'>{$file.downloaded_count}</td>
                        </tr>
                    {/foreach}
                {/if}

            {/foreach}
            </table>
        </div>

        {** レポジトリ **}
        <div class='repositries column'>
            <h3>レポジトリ</h3>
            <p>
                Samurai FrameworkはSubversionというバージョン管理システムを利用しています。<br />
                最新版は常にtrunkで開発され、リリースのタイミングでtagを切り、メージャーバージョンアップの様に大きな変更を必要とする場合branchesを切って対応を分離しています。<br />
                過去のSamurai、あるいは開発途中の最新のSamuraiの確認はこちらからどうぞ！<br />
                <br />
                <ul>
                    <li>[svn] {Html->a href='/source/svn/' value="`$smarty.const.BASE_URL`/source/svn"}</li>
                    <li>[svn:trunk] {Html->a href='/source/svn/trunk' value="`$smarty.const.BASE_URL`/source/svn/trunk"}</li>
                </ul>
            </p>
        </div>

    </div>
{include file='_footer.tpl'}

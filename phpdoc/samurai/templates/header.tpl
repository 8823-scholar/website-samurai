<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'> 
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='ja' dir='ltr'>
<head>
<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
<title>{$title} | Samurai Framework</title>
<link rel="stylesheet" type="text/css" href="{$subdir}media/style.css">
<link rel='stylesheet' type='text/css' href='/css/base.css'>
<link rel='stylesheet' type='text/css' href='/css/common.css'>
<link rel='stylesheet' type='text/css' href='/css/layout/phpdoc.css'>
<script type='text/javascript' src='/js/jquery/jquery-1.3.2.js'></script>
<script type='text/javascript' src='/js/samurai.js'></script>
<script type='text/javascript' src='/js/samurai/haiku.js'></script>
</head>
<body>
    <div id='samurai'>
        <div id='header'>
            <ul class='menu left'>
                <li><a href='/' class='with-icon samurai'>SamuraiFW</a></li>
                <li><a href='/about/samuraifw'>概要</a></li>
                <li><a href='/package/releases'>ダウンロード</a></li>
                <li><a href='/source/api/2.0/'>API</a></li>
                <li><a href='/documents/ja/FrontPage'>ドキュメント</a></li>
                <li><a href='/development/'>開発</a></li>
                <li><a href='/community/index'>コミュニティ</a></li>
            </ul>
            <ul class='menu right'>
                <li><a href='/etc/donate'>寄付</a></li>
            </ul>
            <div class='clear'></div>
        </div>

        <div id='contents' class='source spi'>
            <div class='top haiku'>
                <script type='text/javascript'>
                    var Haiku = new Samurai.Haiku();
                    Haiku.append2Header();
                </script>
                <span class='phrase' id='haiku-phrase'>&nbsp;</span>
                <span class='composed_by' id='haiku-composed_by'>&nbsp;</span>
                <div class='clear'></div>
            </div>

            <div class='middle'>
                <h1>API</h1>

                <ul class='breads'>
                    <li><a href='/'>ホーム</a></li>
                    <li class='delimiter'>&gt;</li>
                    <li>API<li>
                    <li class='delimiter'>&gt;</li>
                    <li><a href='/source/api/2.0/'>2.0</a><li>
                    {if $package}
                        <li class='delimiter'>&gt;</li>
                        <li class='selected'>{$package}</li>
                    {/if}
                    <li class='clear'></li>
                </ul>

                <div id='main'>

<table border="0" cellspacing="0" cellpadding="0" width="100%" class='top'>
  <tr>
    <td class="header_menu">
        {assign var="packagehaselements" value=false}
        {foreach from=$packageindex item=thispackage}
            {if in_array($package, $thispackage)}
                {assign var="packagehaselements" value=true}
            {/if}
        {/foreach}
        {if $packagehaselements}
  		  [ <a href="{$subdir}classtrees_{$package}.html" class="menu">class tree: {$package}</a> ]
		  [ <a href="{$subdir}elementindex_{$package}.html" class="menu">index: {$package}</a> ]
		{/if}
  	    [ <a href="{$subdir}elementindex.html" class="menu">all elements</a> ]
    </td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class='main'>
  <tr valign="top">
    <td width="200" class="menu">
{if count($ric) >= 1}
	<div id="ric">
		{section name=ric loop=$ric}
			<p><a href="{$subdir}{$ric[ric].file}">{$ric[ric].name}</a></p>
		{/section}
	</div>
{/if}
{if $hastodos}
	<div id="todolist">
			<p><a href="{$subdir}{$todolink}">Todo List</a></p>
	</div>
{/if}
      <b>Packages:</b><br />
      {section name=packagelist loop=$packageindex}
        <a href="{$subdir}{$packageindex[packagelist].link}">{$packageindex[packagelist].title}</a><br />
      {/section}
      <br /><br />
{if $tutorials}
		<b>Tutorials/Manuals:</b><br />
		{if $tutorials.pkg}
			<strong>Package-level:</strong>
			{section name=ext loop=$tutorials.pkg}
				{$tutorials.pkg[ext]}
			{/section}
		{/if}
		{if $tutorials.cls}
			<strong>Class-level:</strong>
			{section name=ext loop=$tutorials.cls}
				{$tutorials.cls[ext]}
			{/section}
		{/if}
		{if $tutorials.proc}
			<strong>Procedural-level:</strong>
			{section name=ext loop=$tutorials.proc}
				{$tutorials.proc[ext]}
			{/section}
		{/if}
{/if}
      {if !$noleftindex}{assign var="noleftindex" value=false}{/if}
      {if !$noleftindex}
      {if $compiledfileindex}
      <b>Files:</b><br />
      {eval var=$compiledfileindex}
      {/if}

      {if $compiledinterfaceindex}
      <b>Interfaces:</b><br />
      {eval var=$compiledinterfaceindex}
      {/if}

      {if $compiledclassindex}
      <b>Classes:</b><br />
      {eval var=$compiledclassindex}
      {/if}
      {/if}
    </td>
    <td class='content'>
      <table cellpadding="10" cellspacing="0" width="100%" border="0"><tr><td valign="top">

{if !$hasel}{assign var="hasel" value=false}{/if}
{if $hasel}
<h1>{$eltype|capitalize}: {$class_name}</h1>
Source Location: {$source_location}<br /><br />
{/if}

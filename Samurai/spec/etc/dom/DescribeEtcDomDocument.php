<?php
class DescribeEtcDomDocument extends PHPSpec_Context
{
    private
        $Document;
    private
        $_html_text = '';
    
    
    //メソッド一覧
    public function itメソッド一覧()
    {
        /*
        $Document->load($text);
        $Document->loadByFile($filepath);
        $Document->createElement($name);
        $Document->createTextNode($text);
        $Document->render();
        */
    }
    
    
    //specs
    public function it文書のロード()
    {
        $this->Document->load($this->_html_text);
    }
    
    
    public function itエレメント作成()
    {
        $node = $this->Document->createElement('div');
        $this->spec($node)->should->beAnInstanceOf('Etc_Dom_Element');
        $this->spec($node->tagName)->should->be('div');
    }
    
    
    public function itテキストノード作成()
    {
        $node = $this->Document->createTextNode('うんこうんこ<><><><>');
        $this->spec($node)->should->beAnInstanceOf('Etc_Dom_Text');
        $this->spec($node->nodeValue)->should->be('うんこうんこ<><><><>');
        $this->spec($node->getValue())->should->be('うんこうんこ&lt;&gt;&lt;&gt;&lt;&gt;&lt;&gt;');
    }
    
    
    
    
    
    /**
     * 初期化処理
     * @access     public
     */
    public function before()
    {
        $this->Document = new Etc_Dom_Document();
    }
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Dom_Document');
        $this->_html_text = join("\n", array(
            '<!DOCTYPE HTML PUBLIC \'-//W3C//DTD HTML 4.01//EN\' \'http://www.w3.org/TR/html4/strict.dtd\'>',
            '<html>',
            '   <head>',
            '       <meta http-equiv="content-type" content="text/html; charset=UTF-8" />',
            '       <title>DOMテキストのテスト</title>',
            '   </head>',
            '   <body>',
            '       <div id="main">',
            '           <p>段落1<a href="http://befool.co.jp">株式会社BEFOOL</a></p>',
            '       </div>',
            '       <div id="sidebar">',
            '           <ul>',
            '               <li>リスト1</li>',
            '               <li>リスト2</li>',
            '               <li>リスト3</li>',
            '           </ul>',
            '           あいうえお<br />',
            '           <span onClick="alert(\"aaaa\");">クリック&lt;unko&gt;してね</span>',
            '       </div>',
            '       <!--',
            '       コメントです',
            '       -->',
            '       <![CDATA[',
            '       CDATAです。<br />',
            '       うほほい >>>>><<<<<<いえーい',
            '       ]]>',
            '   </body>',
            '</html>',
        ));
    }
}

<?php
/**
 * ドキュメントノード
 * ルートは常にこれ
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
define('ETC_DOM_NODE_DOCUMENT', XML_DOCUMENT_NODE);
define('ETC_DOM_NODE_DOCUMENT_TYPE', XML_DOCUMENT_TYPE_NODE);
define('ETC_DOM_NODE_ELEMENT', XML_ELEMENT_NODE);
define('ETC_DOM_NODE_TEXT', XML_TEXT_NODE);
define('ETC_DOM_NODE_COMMENT', XML_COMMENT_NODE);
define('ETC_DOM_NODE_CDATA', XML_CDATA_SECTION_NODE);
Samurai_Loader::loadByClass('Etc_Dom_Node');
Samurai_Loader::loadByClass('Etc_Dom_Element');
Samurai_Loader::loadByClass('Etc_Dom_Comment');
Samurai_Loader::loadByClass('Etc_Dom_Text');
Samurai_Loader::loadByClass('Etc_Dom_Attribute');
Samurai_Loader::loadByClass('Etc_Dom_DocumentType');

class Etc_Dom_Document extends Etc_Dom_Node
{
    private
        $Parser;
    
    
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        parent::__construct();
        $this->nodeType = ETC_DOM_NODE_DOCUMENT;
        $this->Parser = new Etc_Dom_Parser();
    }


    /**
     * 文書のロード
     *
     * @access     public
     * @param      string  $text
     */
    public function load($text)
    {
        $this->clear();
        $this->Parser->setRoot($this);
        $this->Parser->parse($text);
    }


    /**
     * テキストファイルから文書をロードする
     * ファイルパスはfile_get_contentsの仕様に依存する(つまり、URLなども可能)。
     *
     * @access     public
     * @param      string  $file
     */
    public function loadByFile($file)
    {
        $text = file_get_contents($file);
        $this->load($text);
    }


    /**
     * DOMを出力
     *
     * @access     public
     * @return     string
     */
    public function render()
    {
        $text = '';
        foreach($this->childNodes as $child){
            if($child->nodeType === ETC_DOM_NODE_ELEMENT){
                $text .= $child->outerHTML();
            } else {
                $text .= $child->getValue();
            }
        }
        return $text;
    }





    /**
     * エレメントノードを作成
     *
     * @access     public
     * @param      string  $tagname
     * @param      array   $attributes
     * @return     object  Etc_Dom_Element
     */
    public function createElement($tagname, array $attributes=array())
    {
        $node = new Etc_Dom_Element($tagname, $attributes);
        return $node;
    }


    /**
     * テキストノードを作成
     *
     * @access     public
     * @param      string  $text
     * @return     object  Etc_Dom_Text
     */
    public function createTextNode($text)
    {
        $node = new Etc_Dom_Text($text);
        return $node;
    }





    /**
     * ノードのクリア
     *
     * @access     public
     */
    public function clear()
    {
        $this->childNodes->clear();
    }
}

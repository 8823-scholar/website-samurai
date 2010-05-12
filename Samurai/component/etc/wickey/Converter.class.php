<?php
/**
 * ノード変換クラスの抽象クラス
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
abstract class Etc_Wickey_Converter
{
    public
        $option;
    public
        $Device;
    
    
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * 変換トリガー
     *
     * @access     public
     */
    abstract public function convert(Etc_Dom_Node $node);





    /**
     * 属性をアペンドする
     *
     * @access     protected
     * @param      object  $node   Etc_Dom_Element
     * @param      string  $name
     * @param      string  $value
     */
    protected function _appendAttribute(Etc_Dom_Element $node, $name, $value)
    {
        if($node->hasAttribute($name)){
            $node->setAttribute($name, $node->getAttribute($name) . ' ' . $value);
        } else {
            $node->setAttribute($name, $value);
        }
    }


    /**
     * 前後のBRを取り除く
     * より直感的に記述するための調整役
     *
     * @access     private
     */
    protected function _trimBR($node)
    {
        //最初の改行を除去
        $firstChild = $node->firstChild;
        if($firstChild->nodeType == XML_ELEMENT_NODE && $firstChild->tagName == 'br'){
            $node->removeChild($firstChild);
        }
        //最後の改行を除去
        $lastChild = $node->lastChild;
        if($lastChild->nodeType == XML_TEXT_NODE && trim($lastChild->nodeValue) == ''){
            //改行の手前は必ずBR
            $node->removeChild($lastChild->previousSibling);
        }
    }


    /**
     * 直後のBRを取り除く
     *
     * @access     protected
     */
    protected function _removeNextBR(Etc_Dom_Node $node)
    {
        $next = $node->nextSibling;
        if($next && $next->nodeType == XML_ELEMENT_NODE && strtolower($next->tagName) == 'br'){
            $node->parentNode->removeChild($next);
        }
    }


    /**
     * 子要素が解釈されないように調整
     *
     * @access     protected
     * @param      object  $node
     */
    protected function _noChildConvert(Etc_Dom_Node $new_node, Etc_Dom_Node $node)
    {
        $root = $this->option->root;
        $new_node->setAttribute('no_child_convert', 1);
        $open = '{{{' . "\n";
        $close = "\n" . '}}}';
        if($node->previousSibling){
            if($node->previousSibling->nodeType !== XML_TEXT_NODE
                || !preg_match('/[\r\n]$/', $node->previousSibling->nodeValue)){
                $open = "\n" . $open;
            }
        }
        if($node->nextSibling){
            if($node->nextSibling->nodeType !== XML_TEXT_NODE
                || !preg_match('/^[\r\n]/', $node->nextSibling->nodeValue)){
                $close = $close .= "\n";
            }
        }
        $node->parentNode->insertBefore($root->createTextNode($open), $node);
        if($node->nextSibling){
            $node->parentNode->insertBefore($root->createTextNode($close), $node->nextSibling);
        } else {
            $node->parentNode->appendChild($root->createTextNode($close));
        }
    }





    /**
     * オプションをセット
     *
     * @access     public
     * @param      object  $option
     */
    public function setOption($option)
    {
        $this->option = new stdClass();
        $this->option->mini = false;
        $this->option->truncate = false;
        if($option){
            foreach($option as $_key => $_val) $this->option->$_key = $_val;
        }
    }
}

<?php
/**
 * TIPノードのコンバーター
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Converter_Tip extends Etc_Wickey_Converter
{
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
     * @implements
     * @access     public
     */
    public function convert(DOMNode $node)
    {
        $this->_trimBR($node);
        if($this->option->truncate){
            return $root->createTextNode($node->getAttribute('title'));
        }
        
        $root = $this->option->root;
        $new_node = $root->createElement('div');
        $new_node->setAttribute('class', 'tip');
        $A = $root->createElement('A');
        $A->appendChild($root->createTextNode($node->getAttribute('title')));
        if($this->Device->isMobile()){
            $this->_doMobile($new_node, $A, $node);
        } else {
            $this->_doPc();
        }
        
        //TIPコンテンツはwickeyに直接埋め込む
        $root->firstChild->appendChild($new_node);
        
        return $A;
    }
    
    
    /**
     * PC
     * @access     protected
     */
    protected function _doPc($new_node, $A, $node)
    {
        $root = $this->option->root;
        $id = uniqid('tip', true);
        $title = $node->getAttribute('title');
        $A->setAttribute('href', 'javascript:;');
        $A->setAttribute('onClick', "ICAN.Common.Wickey.Tip.open('".$id."', event);");
        $A->setAttribute('class', 'tip');
        $DIV = $root->createElement('DIV');
        $HEAD = $root->createElement('DIV');
        $BODY = $root->createElement('DIV');
        $FOOT = $root->createElement('DIV');
        $HEAD->setAttribute('class', 'hd');
        $BODY->setAttribute('class', 'bd');
        $FOOT->setAttribute('class', 'ft');
        $HEAD->appendChild($root->createTextNode('[TIP] '.$title));
        foreach($node->childNodes as $i => $child){
            /*
            if(!$i && $child->nodeType == XML_TEXT_NODE){
                $child->nodeValue = preg_replace("/^(\r\n|\r|\n)+?/", '', $child->nodeValue);
            }
            */
            $BODY->appendChild($child->cloneNode(true));
        }
        $FOOT->appendChild($root->createTextNode(' '));
        $DIV->setAttribute('id', $id);
        $DIV->setAttribute('style', 'display:none;');
        $DIV->setAttribute('class', 'content');
        $DIV->appendChild($HEAD);
        $DIV->appendChild($BODY);
        $DIV->appendChild($FOOT);
        $new_node->appendChild($DIV);
    }
    
    
    /**
     * モバイル
     * @access     protected
     */
    protected function _doMobile($new_node, $A, $node)
    {
        $root = $this->option->root;
        $id = uniqid('tip', true);
        $title = $node->getAttribute('title');
        $A->setAttribute('href', '#foot_'.$id);
        $A->setAttribute('id', 'head_'.$id);
        $A->setAttribute('name', 'head_'.$id);
        $A->setAttribute('class', 'tip');
        $DIV = $root->createElement('DIV');
        $HEAD = $root->createElement('DIV');
        $BODY = $root->createElement('DIV');
        $FOOT = $root->createElement('DIV');
        $HEAD->setAttribute('class', 'hd');
        $HEAD->appendChild($A_HEAD = $root->createElement('A'));
        $A_HEAD->setAttribute('href', '#head_'.$id);
        $A_HEAD->setAttribute('id', 'foot_'.$id);
        $A_HEAD->setAttribute('name', 'foot_'.$id);
        $A_HEAD->appendChild($root->createTextNode('▲'));
        $HEAD->appendChild($root->createTextNode('[TIP] '.$title));
        $BODY->setAttribute('class', 'bd');
        $FOOT->setAttribute('class', 'ft');
        $DIV->appendChild($root->createElement('HR'));
        foreach($node->childNodes as $i => $child){
            /*
            if(!$i && $child->nodeType == XML_TEXT_NODE){
                $child->nodeValue = preg_replace("/^(\r\n|\r|\n)+?/", '', $child->nodeValue);
            }
            */
            $BODY->appendChild($child->cloneNode(true));
        }
        $FOOT->appendChild($root->createTextNode(' '));
        $DIV->setAttribute('id', $id);
        $DIV->setAttribute('class', 'content');
        $DIV->appendChild($HEAD);
        $DIV->appendChild($BODY);
        $DIV->appendChild($FOOT);
        $new_node->appendChild($DIV);
    }
}

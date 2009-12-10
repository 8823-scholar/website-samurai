<?php
/**
 * DOMの最も基本的な要素となるクラス
 *
 * ほとんどのDOMクラスはこれを継承している
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Dom_Node
{
    public
        $nodeType = 0,
        $nodeValue = '',
        $parentNode,
        $childNodes,
        $firstChild,
        $lastChild,
        $previousSibling,
        $nextSibling,
        $attributes = array();
    public
        /** @var        int     DOM階層の深さ */
        $depth = 0;


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        $this->childNodes = new Etc_Dom_NodeList();
    }


    /**
     * 子要素の追加
     *
     * @access     public
     * @param      object  $node   Etc_Dom_Node
     */
    public function appendChild(Etc_Dom_Node $node)
    {
        $node->parentNode = $this;
        $this->lastChild = $node;
        if(!$this->firstChild){
            $this->firstChild = $node;
        } else {
            $node->previousSibling = $this->childNodes->item($this->childNodes->length - 1);
            $node->previousSibling->nextSibling = $node;
        }
        $this->childNodes->addNode($node);
        return $node;
    }


    /**
     * 子要素を削除する
     *
     * @access     public
     * @param      object  $node   Etc_Dom_Node
     */
    public function removeChild(Etc_Dom_Node $node)
    {
        $this->childNodes->removeNode($node);
        $this->firstChild = $this->childNodes->item(0);
        $this->lastChild = $this->childNodes->item($this->childNodes->length - 1);
        if($node->previousSibling){
            $node->previousSibling->nextSibling = $node->nextSibling;
        }
        if($node->nextSibling){
            $node->nextSibling->previousSibling = $node->previousSibling;
        }
    }


    /**
     * 子要素を置換する
     *
     * @access     public
     * @param      object  $new_node   Etc_Dom_Node
     * @param      object  $old_node   Etc_Dom_Node
     * @return     object  Etc_Dom_Node
     */
    public function replaceChild(Etc_Dom_Node $new_node, Etc_Dom_Node $old_node)
    {
        $this->childNodes->replaceNode($new_node, $old_node);
        $this->firstChild = $this->childNodes->item(0);
        $this->lastChild = $this->childNodes->item($this->childNodes->length - 1);
        $new_node->parentNode = $this;
        if($old_node->previousSibling){
            $new_node->previousSibling = $old_node->previousSibling;
            $new_node->previousSibling->nextSibling = $new_node;
        }
        if($old_node->nextSibling){
            $new_node->nextSibling = $old_node->nextSibling;
            $new_node->nextSibling->previousSibling = $new_node;
        }
    }


    /**
     * ノードを指定のノードの手前に挿入する
     *
     * @access     public
     * @param      object  $new_node   Etc_Dom_Node
     * @param      object  $ref_node   Etc_Dom_Node
     */
    public function insertBefore(Etc_Dom_Node $new_node, Etc_Dom_Node $ref_node)
    {
        $this->childNodes->insertBefore($new_node, $ref_node);
        $this->firstChild = $this->childNodes->item(0);
        $this->lastChild = $this->childNodes->item($this->childNodes->length - 1);
        $new_node->parentNode = $this;
        if($ref_node->previousSibling){
            $new_node->previousSibling = $ref_node->previousSibling;
            $new_node->previousSibling->nextSibling = $new_node;
            $new_node->nextSibling = $ref_node;
            $ref_node->previousSibling = $new_node;
        }
    }



    /**
     * ノードのクローン
     *
     * @access     public
     * @param      boolean $deep
     * @return     object  Etc_Dom_Node
     */
    public function cloneNode($deep=false)
    {
        $node = clone $this;
        $node->parentNode = NULL;
        $node->firstChild = NULL;
        $node->lastChild = NULL;
        $node->previousSibling = NULL;
        $node->nextSibling = NULL;
        $node->attributes = array();
        if($deep){
            $childNodes = $node->childNodes;
            $node->childNodes = new Etc_Dom_NodeList();
            foreach($childNodes as $child){
                $new_child = $child->cloneNode($deep);
                $node->appendChild($new_child);
            }
        } else {
            $node->childNodes = new Etc_Dom_NodeList();
        }
        //属性のクローン
        foreach($this->attributes as $_key => $attr){
            $node->setAttributeNode(clone $attr);
        }
        return $node;
    }





    /**
     * 子ノードを保持しているかどうか
     *
     * @access     public
     * @return     boolean
     */
    public function hasChildNodes()
    {
        return $this->childNodes->length > 0;
    }


    /**
     * 属性を保持しているかどうか
     *
     * @access     public
     * @return     boolean
     */
    public function hasAttributes()
    {
        return count($this->attributes) > 0;
    }


    /**
     * 同じノードかどうか判断
     *
     * @access     public
     * @param      object  $node   Etc_Dom_Node
     */
    public function isSameNode($node)
    {
        return is_object($node) && $node === $this;
    }


    /**
     * nodeValueを返却
     *
     * @access     public
     * @param      string
     */
    public function getValue()
    {
        return $this->nodeValue;
    }
}

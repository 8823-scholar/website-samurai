<?php
/**
 * エレメントノード
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Dom_Element extends Etc_Dom_Node
{
    public
        $tagName;
    public
        $single = false;
    
    
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct($name, $attributes=array())
    {
        parent::__construct();
        $this->nodeType = ETC_DOM_NODE_ELEMENT;
        $this->tagName = $name;
        foreach($attributes as $_key => $_val){
            $attr = new Etc_Dom_Attribute();
            $attr->name = $_key;
            $attr->value = $_val;
            $this->setAttributeNode($attr);
        }
    }


    /**
     * 属性を取得
     *
     * @access     public
     * @param      string  $name
     * @return     string
     */
    public function getAttribute($name)
    {
        return $this->hasAttribute($name) ? $this->attributes[$name]->value : NULL ;
    }


    /**
     * 属性のセット
     *
     * @access     public
     * @param      string  $name
     * @param      string  $value
     * @return     object  Etc_Dom_Attribute
     */
    public function setAttribute($name, $value=NULL)
    {
        if($this->hasAttribute($name)){
            $attr = $this->attributes[$name];
            $attr->value = $value;
            return $attr;
        } else {
            $attr = new Etc_Dom_Attribute($name, $value);
            return $this->setAttributeNode($attr);
        }
    }

    /**
     * 属性ノードのセット
     * @access     public
     * @param      object  $attribute   Etc_Dom_Attribute
     * @return     object  Etc_Dom_Attribute
     */
    public function setAttributeNode(Etc_Dom_Attribute $attribute)
    {
        $this->attributes[$attribute->name] = $attribute;
        $attribute->ownerElement = $this;
        return $attribute;
    }


    /**
     * 指定の属性が保持されているかどうか
     *
     * @access     public
     * @param      string  $name
     * @return     boolean
     */
    public function hasAttribute($name)
    {
        return isset($this->attributes[$name]);
    }


    /**
     * 属性を削除する
     *
     * @access     public
     * @param      string  $name
     * @return     boolean
     */
    public function removeAttribute($name)
    {
        if(isset($this->attributes[$name])){
            unset($this->attributes[$name]);
        }
        return true;
    }





    /**
     * 内部のHTMLを取得する またはセットする
     *
     * @access     public
     * @return     string
     */
    public function innerHTML()
    {
        $html = '';
        foreach($this->childNodes as $child){
            if($child->nodeType === ETC_DOM_NODE_ELEMENT){
                $html .= $child->outerHTML();
            } else {
                $html .= $child->getValue();
            }
        }
        return $html;
    }


    /**
     * 自身も含めたHTMLを取得する  こちらは取得だけ
     *
     * @access     public
     * @return     string
     */
    public function outerHTML()
    {
        $html = '<' . $this->tagName;
        foreach($this->attributes as $attr){
            if($attr->value === NULL){
                $html .= sprintf(' %s', $attr->name);
            } else {
                $html .= sprintf(' %s=%s%s%s', $attr->name, $attr->getQuote(), $attr->value, $attr->getQuote());
            }
        }
        if($this->single && !$this->childNodes->length){
            $html .= ' />';
        } else {
            $html .= '>';
            $html .= $this->innerHTML();
            $html .= '</' . $this->tagName . '>';
        }
        return $html;
    }


    /**
     * 内部のテキストを取得
     *
     * @access     public
     * @return     string
     */
    public function innerText()
    {
        return strip_tags($this->innerHTML());
    }
}

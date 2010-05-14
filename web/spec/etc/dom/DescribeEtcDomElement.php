<?php
class DescribeEtcDomElement extends PHPSpec_Context
{
    private
        $Node;
    
    
    //メソッド一覧
    public function itメソッド一覧()
    {
        /*
        //inherit
        $Node->nodeType
        $Node->nodeValue
        $Node->parentNode
        $Node->childNodes
        $Node->firstChild
        $Node->lastChild
        $Node->previousSibling
        $Node->nextSibling
        $Node->attributes
        $Node->appendChild($node);
        $Node->hasChildNodes();
        $Node->hasAttributes();
        $Node->cloneNode($deep);
        $Node->removeChild($old_node);
        $Node->replaceChild($new_node, $old_node);
        //original
        $Node->tagName
        $Node->innerHTML();
        $Node->outerHTML();
        $Node->setAttribute($name, $value);
        $Node->setAttributeNode($attribute);
        */
    }
    
    
    //specs
    public function itプロパティチェック()
    {
        $this->spec($this->Node->nodeType)->should->be(ETC_DOM_NODE_ELEMENT);
    }
    
    public function it作成()
    {
        $ele = new Etc_Dom_Element('div');
        $this->spec($ele->tagName)->should->be('div');
    }
    
    public function it子要素の追加()
    {
        $span1 = $this->Node->appendChild(new Etc_Dom_Element('span', array('style'=>'color:#FFFFFF;')));
        $span2 = $this->Node->appendChild(new Etc_Dom_Element('span', array('style'=>'color:#000000;')));
        $span1->appendChild(new Etc_Dom_Text('白い文字です'));
        $span2->appendChild(new Etc_Dom_Text('黒い文字です'));
        $this->spec($this->Node->childNodes->length)->should->be(2);
        $this->spec($span1->childNodes->length)->should->be(1);
        $this->spec($span2->childNodes->length)->should->be(1);
    }
    
    public function itInnerHtml()
    {
        $span1 = $this->Node->appendChild(new Etc_Dom_Element('span', array('style'=>'color:#FFFFFF;')));
        $span2 = $this->Node->appendChild(new Etc_Dom_Element('span', array('style'=>'color:#000000;')));
        $text1 = $this->Node->appendChild(new Etc_Dom_Text('テキストですよ'));
        $span1->appendChild(new Etc_Dom_Text('白い文字です'));
        $span2->appendChild(new Etc_Dom_Text('黒い文字です'));
        $this->spec($this->Node->innerHTML())->should->be(
            '<span style="color:#FFFFFF;">白い文字です</span><span style="color:#000000;">黒い文字です</span>テキストですよ'
        );
    }
    
    public function itOuterHtml()
    {
        $span = $this->Node->appendChild(new Etc_Dom_Element('span', array('style'=>'color:#FFFFFF;')));
        $span->appendChild(new Etc_Dom_Text('テキストですよ'));
        $this->spec($this->Node->outerHTML())->should->be(
            '<div><span style="color:#FFFFFF;">テキストですよ</span></div>'
        );
    }
    
    
    public function it属性のセット()
    {
        $attr = $this->Node->setAttribute('style', 'color:#CCCCCC;');
        $this->spec($attr)->should->beAnInstanceOf('Etc_Dom_Attribute');
        $this->spec($attr->name)->should->be('style');
        $this->spec($attr->value)->should->be('color:#CCCCCC;');
        $this->spec($attr->ownerElement)->should->be($this->Node);
    }
    
    public function it属性ノードのセット()
    {
        $attr = new Etc_Dom_Attribute('width', '300px');
        $attr2 = $this->Node->setAttributeNode($attr);
        $this->spec($attr2)->should->be($attr);
        $this->spec($attr2->name)->should->be('width');
        $this->spec($attr2->value)->should->be('300px');
    }
    
    
    
    
    
    /**
     * 初期化処理
     *
     * @access     public
     */
    public function before()
    {
        $this->Node = new Etc_Dom_Element('div');
    }
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Dom_Document');
    }
}

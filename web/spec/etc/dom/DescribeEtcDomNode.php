<?php
class DescribeEtcDomNode extends PHPSpec_Context
{
    private
        $Node;
    
    
    //メソッド一覧
    public function itメソッド一覧()
    {
        /*
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
        $Node->insertBefore($new_node, $ref_node);
        $Node->hasChildNodes();
        $Node->hasAttributes();
        $Node->cloneNode($deep);
        $Node->removeChild($node);
        $Node->replaceChild($new_node, $old_node);
        */
    }
    
    
    //specs
    public function itParentNodeはきちんとセットされるか()
    {
        $node = new Etc_Dom_Element('div');
        $span = $node->appendChild(new Etc_Dom_Element('span'));
        $this->spec($span->parentNode)->should->be($node);
    }
    
    public function itFirstChildはきちんとセットされるのか()
    {
        $node = new Etc_Dom_Element('div');
        $span1 = $node->appendChild(new Etc_Dom_Element('span'));
        $span2 = $node->appendChild(new Etc_Dom_Element('span'));
        $this->spec($node->firstChild)->should->be($span1);
    }
    
    public function itLastChildはきちんとセットされるか()
    {
        $node = new Etc_Dom_Element('div');
        $span1 = $node->appendChild(new Etc_Dom_Element('span'));
        $span2 = $node->appendChild(new Etc_Dom_Element('span'));
        $this->spec($node->lastChild)->should->be($span2);
    }
    
    public function itPreviousSiblingはきちんとセットされるか()
    {
        $node = new Etc_Dom_Element('div');
        $span1 = $node->appendChild(new Etc_Dom_Element('span'));
        $span2 = $node->appendChild(new Etc_Dom_Element('span'));
        $this->spec($span1->previousSibling)->should->beNull();
        $this->spec($span2->previousSibling)->should->be($span1);
    }
    
    public function itNextSiblingはきちんとセットされるか()
    {
        $node = new Etc_Dom_Element('div');
        $span1 = $node->appendChild(new Etc_Dom_Element('span'));
        $span2 = $node->appendChild(new Etc_Dom_Element('span'));
        $this->spec($span1->nextSibling)->should->be($span2);
        $this->spec($span2->nextSibling)->should->beNull();
    }
    
    public function itRemoveされた後も問題なく入れ替わるか()
    {
        $node = new Etc_Dom_Element('div');
        $span1 = $node->appendChild(new Etc_Dom_Element('span1'));
        $span2 = $node->appendChild(new Etc_Dom_Element('span2'));
        $span3 = $node->appendChild(new Etc_Dom_Element('span3'));
        $span4 = $node->appendChild(new Etc_Dom_Element('span4'));
        $span5 = $node->appendChild(new Etc_Dom_Element('span5'));
        $node->removeChild($span1);
        $this->spec($node->firstChild)->should->be($span2);
        $this->spec($span2->previousSibling)->should->beNull();
        $node->removeChild($span5);
        $this->spec($node->lastChild)->should->be($span4);
        $this->spec($span4->nextSibling)->should->beNull();
    }
    
    public function itReplaceされた後も問題なく入れ替わるか()
    {
        $node = new Etc_Dom_Element('div');
        $span1 = $node->appendChild(new Etc_Dom_Element('span'));
        $span2 = $node->appendChild(new Etc_Dom_Element('span'));
        $span3 = $node->appendChild(new Etc_Dom_Element('span'));
        $span4 = new Etc_Dom_Element('span');
        $node->replaceChild($span4, $span1);
        $this->spec($node->firstChild)->should->be($span4);
        $this->spec($span2->previousSibling)->should->be($span4);
        $span5 = new Etc_Dom_Element('span');
        $node->replaceChild($span5, $span3);
        $this->spec($node->lastChild)->should->be($span5);
        $this->spec($span2->nextSibling)->should->be($span5);
    }
    
    public function itInsertBeforeされた後も問題なく入れ替わるか()
    {
        $node = new Etc_Dom_Element('div');
        $span1 = $node->appendChild(new Etc_Dom_Element('span'));
        $span2 = $node->appendChild(new Etc_Dom_Element('span'));
        $span3 = $node->appendChild(new Etc_Dom_Element('span'));
        $span4 = new Etc_Dom_Element('span');
        $node->insertBefore($span4, $span3);
        $this->spec($span2->nextSibling)->should->be($span4);
        $this->spec($span3->previousSibling)->should->be($span4);
        $this->spec($span4->nextSibling)->should->be($span3);
        $this->spec($span4->previousSibling)->should->be($span2);
    }
    
    
    public function it子要素を保持しているかのチェック()
    {
        $node = new Etc_Dom_Element('div');
        $this->spec($node->hasChildNodes())->should->beFalse();
        $node->appendChild(new Etc_Dom_Element('span'));
        $this->spec($node->hasChildNodes())->should->beTrue();
    }
    
    public function it属性を保持しているかのチェック()
    {
        $node = new Etc_Dom_Element('div');
        $this->spec($node->hasAttributes())->should->beFalse();
        $node->attributes[] = new Etc_Dom_Attribute();
        $this->spec($node->hasAttributes())->should->beTrue();
    }
    
    public function itノードのクローン()
    {
        $node = new Etc_Dom_Element('div');
        $node->setAttribute('height', '200px');
        $span1 = $node->appendChild(new Etc_Dom_Element('span'));
        $span2 = $node->appendChild(new Etc_Dom_Element('span'));
        $span3 = $node->appendChild(new Etc_Dom_Element('span'));
        
        $node_cloned = $node->cloneNode();
        $this->spec($node_cloned->tagName)->should->be($node->tagName);
        $this->spec($node_cloned->hasChildNodes())->should->beFalse();
        $this->spec($node_cloned->hasAttributes())->should->beTrue();
        
        $node_cloned = $node->cloneNode(true);
        $this->spec($node_cloned->tagName)->should->be($node->tagName);
        $this->spec($node_cloned->hasChildNodes())->should->beTrue();
        $this->spec($node_cloned->hasAttributes())->should->beTrue();
    }
    
    
    
    
    
    
    /**
     * 初期化処理
     *
     * @access     public
     */
    public function before()
    {
        //$this->Node = new Etc_Dom_Element();
    }
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Dom_Document');
    }
}

<?php
class DescribeEtcDomNodeList extends PHPSpec_Context
{
    private
        $NodeList;
    
    
    //メソッド一覧
    public function itメソッド一覧()
    {
        /*
        $NodeList->length
        $NodeList->addNode($node);
        $NodeList->removeNode($node);
        $NodeList->item($index);
        $NodeList->clear();
        //また、NodeListはforeachで直接回せる
        */
    }
    
    
    //specs
    public function itノードの追加()
    {
        $node = new Etc_Dom_Node();
        $node2 = $this->NodeList->addNode($node);
        $this->spec($node2)->should->beAnInstanceOf('Etc_Dom_Node');
        $this->spec($node2)->should->be($node);
        $this->spec($this->NodeList->length)->should->be(1);
    }
    
    public function itノードの削除()
    {
        $node = $this->NodeList->addNode(new Etc_Dom_Node());
        $this->spec($this->NodeList->length)->should->be(1);
        $this->NodeList->removeNode($node);
        $this->spec($this->NodeList->length)->should->be(0);
    }
    
    public function itノードを取得()
    {
        $node = $this->NodeList->addNode(new Etc_Dom_Node());
        $node2 = $this->NodeList->item(0);
        $this->spec($node2)->should->be($node);
    }
    
    public function itForeachで回せます()
    {
        $this->NodeList->addNode(new Etc_Dom_Node());
        $this->NodeList->addNode(new Etc_Dom_Node());
        $this->NodeList->addNode(new Etc_Dom_Node());
        foreach($this->NodeList as $node){
            $this->spec($node)->should->beAnInstanceOf('Etc_Dom_Node');
        }
    }
    
    
    
    
    
    /**
     * 初期化処理
     * @access     public
     */
    public function before()
    {
        $this->NodeList->clear();
    }
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Dom_Node');
        Samurai_Loader::loadByClass('Etc_Dom_NodeList');
        $this->NodeList = new Etc_Dom_NodeList();
    }
}

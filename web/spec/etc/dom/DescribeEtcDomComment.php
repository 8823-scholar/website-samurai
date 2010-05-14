<?php
class DescribeEtcDomComment extends PHPSpec_Context
{
    private
        $Node;
    
    
    //メソッド一覧
    public function itメソッド一覧()
    {
        /*
        $Node->nodeType
        $Node->nodeValue
        $Node->appendData($data);
        $Node->deleteData($offset, $length);
        $Node->insertData($offset, $data);
        $Node->replaceData($offset, $length, $data);
        $Node->getValue();
        */
    }
    
    
    //specs
    public function itプロパティチェック()
    {
        $this->spec($this->Node->nodeType)->should->be(ETC_DOM_NODE_COMMENT);
    }
    
    public function itデータの追加()
    {
        $this->Node->appendData('appended');
        $this->spec($this->Node->nodeValue)->should->be('appended');
        $this->Node->appendData('...');
        $this->spec($this->Node->nodeValue)->should->be('appended...');
    }
    
    public function itデータの削除()
    {
        $this->Node->appendData('appended');
        $this->Node->deleteData(2, 3);
        $this->spec($this->Node->nodeValue)->should->be('apded');
    }
    
    public function itデータの挿入()
    {
        $this->Node->appendData('appended');
        $this->Node->insertData(2, 'unko');
        $this->spec($this->Node->nodeValue)->should->be('apunkopended');
    }
    
    public function itデータの置き換え()
    {
        $this->Node->appendData('appended');
        $this->Node->replaceData(2, 3, 'unko');
        $this->spec($this->Node->nodeValue)->should->be('apunkoded');
    }
    
    public function itデータの取得()
    {
        $this->Node->appendData('appended');
        $this->spec($this->Node->getValue())->should->be('<!--appended-->');
    }
    
    
    
    
    
    /**
     * 初期化処理
     * @access     public
     */
    public function before()
    {
        $this->Node = new Etc_Dom_Comment();
    }
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Dom_Document');
    }
}

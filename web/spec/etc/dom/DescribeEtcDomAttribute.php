<?php
class DescribeEtcDomAttribute extends PHPSpec_Context
{
    private
        $Attribute;
    
    
    //メソッド一覧
    public function itメソッド一覧()
    {
        /*
        $Node->name
        $Node->value
        $Node->ownerElement
        $Node->appendData($data);
        */
    }
    
    
    //specs
    public function itデータの追加()
    {
        $this->Attribute->appendData('color:#FFFFFF;');
        $this->spec($this->Attribute->value)->should->be('color:#FFFFFF;');
        $this->Attribute->appendData('background:#666666;');
        $this->spec($this->Attribute->value)->should->be('color:#FFFFFF;background:#666666;');
    }
    
    
    
    
    /**
     * 初期化処理
     * @access     public
     */
    public function before()
    {
        $this->Attribute = new Etc_Dom_Attribute();
    }
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Dom_Attribute');
    }
}

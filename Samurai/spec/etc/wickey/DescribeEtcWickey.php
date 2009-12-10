<?php
class DescribeEtcWickey extends PHPSpec_Context
{
    private
        $Wickey;
    
    
    public function it補完()
    {
        $text = '*うんこ' . "\n" . '<modifier>' . "\n" . '*aaaa</modifier>';
        $text = $this->Wickey->supplement($text);
        $this->spec($text)->should->match('/^\*[a-z0-9]+\*/');
    }
    
    
    
    
    
    /**
     * 初期化処理
     * @access     public
     */
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Wickey');
        $this->Wickey = new Etc_Wickey();
    }
}

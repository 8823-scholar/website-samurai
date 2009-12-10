<?php
/**
 * CDATAノード
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Dom_Cdata extends Etc_Dom_Text
{
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct($value='')
    {
        parent::__construct();
        $this->nodeType = ETC_DOM_NODE_CDATA;
        $this->appendData($value);
    }
    
    
    /**
     * valueを取得する
     *
     * @access     public
     * @return     string
     */
    public function getValue()
    {
        return '<![CDATA[' . $this->nodeValue . ']]>';
    }
}

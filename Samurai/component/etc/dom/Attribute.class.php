<?php
/**
 * 属性クラス
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Dom_Attribute
{
    public
        $name = '',
        $value,
        $ownerElement;
    private
        $_quote = '"';
    
    
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct($name='', $value=NULL)
    {
        $this->name = $name;
        $this->value = $value;
    }
    
    
    /**
     * データを追加する
     *
     * @access     public
     * @param      string  $data
     */
    public function appendData($data)
    {
        $this->value .= $data;
    }
    
    
    /**
     * quoteをセットする
     *
     * @access     public
     * @param      string  $quote
     */
    public function getQuote()
    {
        return $this->_quote;
    }
    public function setQuote($quote)
    {
        $this->_quote = $quote;
    }
}

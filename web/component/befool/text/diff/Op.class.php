<?
/**
 * Befool_Text_Diff_Op
 * 
 * diff時に使用される変更状態を表す抽象クラス
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
abstract class Befool_Text_Diff_Op
{
    public
        $original = array(),
        $final = array();
    
    
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }
    
    
    abstract public function reverse();
    
    
    public function countOriginal()
    {
        return $this->original ? count($this->original) : 0 ;
    }
    
    
    public function countFinal()
    {
        return $this->final ? count($this->final) : 0 ;
    }
}

<?
/**
 * Befool_Text_Diff_Op_Add
 * 
 * 追加を表すクラス
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff_Op_Add extends Befool_Text_Diff_Op
{
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct($lines)
    {
        $this->final = $lines;
    }
    
    
    public function reverse()
    {
        return new Befool_Text_Diff_Op_Delete($this->final);
    }
}

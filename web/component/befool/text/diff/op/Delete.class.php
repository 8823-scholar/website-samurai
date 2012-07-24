<?
/**
 * Befool_Text_Diff_Op_Delete
 * 
 * 削除を表すクラス
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff_Op_Delete extends Befool_Text_Diff_Op
{
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct($lines)
    {
        $this->original = $lines;
    }
    
    
    public function reverse()
    {
        return new Befool_Text_Diff_Op_Add($this->original);
    }
}

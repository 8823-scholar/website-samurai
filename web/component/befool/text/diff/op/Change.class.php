<?
/**
 * Befool_Text_Diff_Op_Change
 * 
 * 変更を表すクラス
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff_Op_Change extends Befool_Text_Diff_Op
{
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct($original, $final)
    {
        $this->original = $original;
        $this->final = $final;
    }
    
    
    public function reverse()
    {
        return new Befool_Text_Diff_Op_Change($this->final, $this->original);
    }
}

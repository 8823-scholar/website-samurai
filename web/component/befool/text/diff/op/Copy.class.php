<?
/**
 * Befool_Text_Diff_Op_Copy
 * 
 * コピーを表すクラス
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff_Op_Copy extends Befool_Text_Diff_Op
{
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct($original, $final=false)
    {
        if(!is_array($final)) $final = $original;
        $this->original = $original;
        $this->final = $final;
    }
    
    
    public function reverse()
    {
        return new Befool_Text_Diff_Op_Copy($this->final, $this->original);
    }
}

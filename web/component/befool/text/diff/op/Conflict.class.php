<?
/**
 * Befool_Text_Diff_Op_Conflict
 * 
 * 衝突を表すクラス
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff_Op_Conflict extends Befool_Text_Diff_Op
{
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct($original, $final1, $final2)
    {
        $this->original = $original;
        $this->final = array($final1, $final2);
    }
    
    
    public function reverse()
    {
        return new Befool_Text_Diff_Op_Conflict($this->original, array($this->final[1], $this->final[0]));
    }
}

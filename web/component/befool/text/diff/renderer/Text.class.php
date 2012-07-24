<?
/**
 * Befool_Text_Diff_Renderer_Text
 * 
 * マージできる箇所は極力マージし、そして衝突の箇所だけ分かりやすく表示する
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff_Renderer_Text extends Befool_Text_Diff_Renderer
{
    public
        $leading_context_lines = 10000,
        $trailing_context_lines = 10000;
    
    
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }
    
    
    /**
     * event:startDiff
     * @access     protected
     * @return     string
     */
    protected function _onStartDiff()
    {
        return '';
    }
    
    
    /**
     * event:endDiff
     * @access     protected
     * @return     string
     */
    protected function _onEndDiff()
    {
        return '';
    }
    
    
    /**
     * event:startBlock
     * @access     protected
     * @return     string
     */
    protected function _onStartBlock()
    {
        return '';
    }
    
    
    /**
     * event:endBlock
     * @access     protected
     * @return     string
     */
    protected function _onEndBlock()
    {
        return '';
    }
    
    
    /**
     * event:beforeBlock
     * @access     protected
     * @return     string
     */
    protected function _onBeforeBlock($o_begin, $o_length, $f_begin, $f_length)
    {
        return '';
    }
    
    
    
    /**
     * event:context
     * @access     protected
     * @param      array   $lines
     * @return     string
     */
    protected function _onContext(array $lines)
    {
        return $this->_lines($lines, '');
    }
    
    /**
     * event:added
     * @access     protected
     * @param      array   $lines
     * @return     string
     */
    protected function _onAdded(array $lines)
    {
        return $this->_lines($lines, '');
    }
    
    /**
     * event:deleted
     * @access     protected
     * @param      array   $lines
     * @return     string
     */
    protected function _onDeleted(array $lines)
    {
        return '';
    }
    
    /**
     * event:changed
     * @access     protected
     * @param      array   $original
     * @param      array   $final
     * @return     string
     */
    protected function _onChanged($original, $final)
    {
        return $this->_onAdded($final);
    }
    
    /**
     * event:conflicted
     * @access     protected
     * @param      array   $original
     * @param      array   $final
     * @return     string
     */
    protected function _onConflicted($original, $final)
    {
        $return = array();
        $return[] = '<<<<<<< .other' . "\n";
        $return[] = $this->_lines($final[0], '');
        $return[] = '=======' . "\n";
        $return[] = $this->_lines($final[1], '');
        $return[] = '>>>>>>> .mine' . "\n";
        return join('', $return);
    }
}

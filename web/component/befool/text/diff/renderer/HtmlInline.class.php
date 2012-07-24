<?
/**
 * Befool_Text_Diff_Renderer_HtmlInline
 * 
 * HTMLで1ライン上に並べて比較できるようにするレンダラー
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff_Renderer_HtmlInline extends Befool_Text_Diff_Renderer
{
    public
        $leading_context_lines = 2,
        $trailing_context_lines = 2;
    private
        $_o_line = 1,
        $_f_line = 1;
    
    
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        parent::__construct();
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
        if($o_length && !$f_length){
            $f_begin--;
        } elseif(!$o_length){
            $o_begin--;
        }
        
        $this->_o_line = $o_begin;
        $this->_f_line = $f_begin;
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
        $html = array();
        foreach($lines as $i => $line){
            $html[] = sprintf('<TR><TD class="line">%d</TD><TD class="line">%d</TD><TD class="context">%s</TD>',
                                $this->_o_line, $this->_f_line, htmlspecialchars($line));
            $this->_o_line++;
            $this->_f_line++;
        }
        return join("\n", $html);
    }
    
    /**
     * event:added
     * @access     protected
     * @param      array   $lines
     * @return     string
     */
    protected function _onAdded(array $lines)
    {
        $html = array();
        foreach($lines as $i => $line){
            $html[] = sprintf('<TR><TD class="line"></TD><TD class="line">%d</TD><TD class="added">%s</TD>',
                                $this->_f_line, htmlspecialchars($line));
            $this->_f_line++;
        }
        return join("\n", $html);
    }
    
    /**
     * event:deleted
     * @access     protected
     * @param      array   $lines
     * @return     string
     */
    protected function _onDeleted(array $lines)
    {
        $html = array();
        foreach($lines as $i => $line){
            $html[] = sprintf('<TR><TD class="line">%d</TD><TD class="line"></TD><TD class="deleted">%s</TD>',
                                $this->_o_line, htmlspecialchars($line));
            $this->_o_line++;
        }
        return join("\n", $html);
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
        return $this->_onDeleted($original) . "\n" . $this->_onAdded($final);
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
        $html = array();
        $html[] = $this->_onDeleted($original);
        foreach($final[0] as $i => $line){
            $line_num = $this->_f_line + $i;
            $html[] = sprintf('<TR><TD class="line"></TD><TD class="line">%d</TD><TD class="conflict">%s</TD>',
                                $line_num, htmlspecialchars($line));
        }
        foreach($final[1] as $i => $line){
            $line_num = $this->_f_line + $i;
            $html[] = sprintf('<TR><TD class="line"></TD><TD class="line">%d</TD><TD class="conflict">%s</TD>',
                                $line_num, htmlspecialchars($line));
        }
        $this->_f_line = $line_num + 1;
        return join("\n", $html);
    }
}

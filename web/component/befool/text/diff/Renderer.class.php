<?
/**
 * Befool_Text_Diff_Renderer
 * 
 * 最も一般的なdiff結果の表示
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff_Renderer
{
    public
        $leading_context_lines = 0,
        $trailing_context_lines = 0;
    
    
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }
    
    
    /**
     * 描画メソッド
     * @access     public
     * @param      array   $diffs
     * @return     string
     */
    public function render(array $diffs)
    {
        $oi = 1;
        $fi = 1;
        $blocks = false;
        $context = array();
        $nlead = $this->leading_context_lines;
        $ntrail = $this->trailing_context_lines;
        
        //開始
        $outputs = array($this->_onStartDiff());
        foreach($diffs as $i => $diff){
            if($diff instanceof Befool_Text_Diff_Op_Copy){
                if(is_array($blocks)){
                    $keep = $i == count($diffs) - 1 ? $ntrail : $nlead + $ntrail;
                    if($diff->countOriginal() <= $keep){
                        $blocks[] = $diff;
                    } else {
                        if($ntrail){
                            $context = array_slice($diff->original, 0, $ntrail);
                            $blocks[] = new Befool_Text_Diff_Op_Copy($context);
                        }
                        $outputs[] = $this->_block($o0, $ntrail + $oi - $o0,  $f0, $ntrail + $fi - $f0,  $blocks);
                        $blocks = false;
                    }
                }
                $context = $diff->original;
            } else {
                if(!is_array($blocks)){
                    $context = array_slice($context, count($context) - $nlead);
                    $o0 = $oi - count($context);
                    $f0 = $fi - count($context);
                    $blocks = array();
                    if($context){
                        $blocks[] = new Befool_Text_Diff_Op_Copy($context);
                    }
                }
                $blocks[] = $diff;
            }
            if($diff->original){
                $oi += count($diff->original);
            }
            if($diff instanceof Befool_Text_Diff_Op_Conflict){
                if($diff->final[0]){
                    $fi += count($diff->final[0]);
                }
            } else {
                if($diff->final){
                    $fi += count($diff->final);
                }
            }
        }
        if(is_array($blocks)){
            $outputs[] = $this->_block($o0, $oi - $o0,  $f0, $fi - $f0,  $blocks);
        }
        $outputs[] = $this->_onEndDiff();
        return join('', $outputs);
    }
    
    
    /**
     * ブロック描画
     * @access     protected
     * @param      int     $o_begin
     * @param      int     $o_length
     * @param      int     $f_begin
     * @param      int     $f_length
     * @param      array   $diffs
     */
    protected function _block($o_begin, $o_length, $f_begin, $f_length, array $diffs)
    {
        $outputs = array();
        $outputs[] = $this->_onBeforeBlock($o_begin, $o_length, $f_begin, $f_length);
        $outputs[] = $this->_onStartBlock();
        foreach($diffs as $diff){
            switch(true){
                case $diff instanceof Befool_Text_Diff_Op_Copy:
                    $outputs[] = $this->_onContext($diff->original);
                    break;
                    
                case $diff instanceof Befool_Text_Diff_Op_Add:
                    $outputs[] = $this->_onAdded($diff->final);
                    break;
                    
                case $diff instanceof Befool_Text_Diff_Op_Delete:
                    $outputs[] = $this->_onDeleted($diff->original);
                    break;
                    
                case $diff instanceof Befool_Text_Diff_Op_Change:
                    $outputs[] = $this->_onChanged($diff->original, $diff->final);
                    break;
                    
                case $diff instanceof Befool_Text_Diff_Op_Conflict:
                    $outputs[] = $this->_onConflicted($diff->original, $diff->final);
                    break;
            }
        }
        $outputs[] = $this->_onEndBlock();
        return join('', $outputs);
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
        if($o_length > 1){
            $o_begin .= ',' . ($o_begin + $o_length - 1);
        }
        if($f_length > 1){
            $f_begin .= ',' . ($f_begin + $f_length - 1);
        }
        if($o_length && !$f_length){
            $f_begin--;
        } elseif(!$o_length){
            $o_begin--;
        }
        return $o_begin . ($o_length ? ($f_length ? 'c' : 'd') : 'a') . $f_begin . "\n";
    }
    
    
    
    /**
     * event:context
     * @access     protected
     * @param      array   $lines
     * @return     string
     */
    protected function _onContext(array $lines)
    {
        return $this->_lines($lines, '  ');
    }
    
    /**
     * event:added
     * @access     protected
     * @param      array   $lines
     * @return     string
     */
    protected function _onAdded(array $lines)
    {
        return $this->_lines($lines, '> ');
    }
    
    /**
     * event:deleted
     * @access     protected
     * @param      array   $lines
     * @return     string
     */
    protected function _onDeleted(array $lines)
    {
        return $this->_lines($lines, '< ');
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
        return $this->_onDeleted($original) . "---\n" . $this->_onAdded($final);
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
        $return[] = $this->_lines($final[0], '  ');
        $return[] = '=======' . "\n";
        $return[] = $this->_lines($final[1], '  ');
        $return[] = '>>>>>>> .mine' . "\n";
        return join('', $return);
    }
    
    
    /**
     * ラインを描写
     * @access     protected
     * @param      array   $lines
     * @param      string  $prefix
     */
    protected function _lines(array $lines, $prefix=' ')
    {
        $return = array();
        foreach($lines as $line){
            $return[] = $prefix . $line;
        }
        return join("\n", $return) . "\n";
    }
}

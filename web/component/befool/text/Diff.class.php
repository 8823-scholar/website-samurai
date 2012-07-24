<?
/**
 * Befool_Text_Diff
 * 
 * diffコマンドのようなことを実現するクラス
 * 
 * @package    Befool
 * @subpackage Text.Diff
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Befool_Text_Diff
{
    private
        $_o_changed = array(),
        $_f_changed = array(),
        $_o_v = array(),
        $_f_v = array(),
        $_o_ind = array(),
        $_f_ind = array(),
        $_lcs = 0,
        $_seq = array(),
        $_in_seq = array();
    
    
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }
    
    
    /**
     * diff
     * @access     public
     * @param      string  $original
     * @param      string  $final
     * @return     array
     */
    public function diff($original, $final)
    {
        //準備
        $this->clear();
        if($original === NULL){
            $original = '';
            $o_lines  = explode("\n", $original);
            $o_count  = 0;
        } else {
            $original = str_replace(array("\r\n", "\r"), "\n", $original);
            $o_lines  = explode("\n", $original);
            $o_count  = count($o_lines);
        }
        if($final === NULL){
            $final    = '';
            $f_lines  = explode("\n", $final);
            $f_count  = 0;
        } else {
            $final    = str_replace(array("\r\n", "\r"), "\n", $final);
            $f_lines  = explode("\n", $final);
            $f_count  = count($f_lines);
        }
        $o_hash   = array();
        $f_hash   = array();
        
        // 初めの変化のない行をスキップ
        for($skip = 0; $skip < $f_count; $skip++){
            if(!isset($o_lines[$skip]) || !isset($f_lines[$skip])) break;
            if($o_lines[$skip] !== $f_lines[$skip]) break;
            $this->_o_changed[$skip] = false;
            $this->_f_changed[$skip] = false;
        }
        
        // 終わりの変化のない行をスキップ
        $_oi = $o_count;
        $_fi = $f_count;
        for($skip_post = 0; --$_oi > $skip && --$_fi > $skip; $skip_post++){
            if(!isset($o_lines[$_oi]) || !isset($f_lines[$_fi])) break;
            if($o_lines[$_oi] !== $f_lines[$_fi]) break;
            $this->_o_changed[$_oi] = false;
            $this->_f_changed[$_fi] = false;
        }
        
        // お互い同士で存在しない行はお互いに無視
        for($_oi = $skip; $_oi < $o_count - $skip_post; $_oi++){
            $o_hash[$o_lines[$_oi]] = true;
        }
        for($_fi = $skip; $_fi < $f_count - $skip_post; $_fi++){
            $line = $f_lines[$_fi];
            if($this->_f_changed[$_fi] = empty($o_hash[$line])) continue;
            $f_hash[$line] = true;
            $this->_f_v[] = $line;
            $this->_f_ind[] = $_fi;
        }
        for($_oi = $skip; $_oi < $o_count - $skip_post; $_oi++){
            $line = $o_lines[$_oi];
            if($this->_o_changed[$_oi] = empty($f_hash[$line])) continue;
            $this->_o_v[] = $line;
            $this->_o_ind[] = $_oi;
        }
        
        
        // Find the LCS.
        $this->_compareseq(0, count($this->_o_v), 0, count($this->_f_v));
        
        // Merge edits when possible.
        $this->_shiftBoundaries($o_lines, $this->_o_changed, $this->_f_changed);
        $this->_shiftBoundaries($f_lines, $this->_f_changed, $this->_o_changed);
        
        // Compute the edit operations.
        $diffs = array();
        $_oi = 0;
        $_fi = 0;
        while($_oi < $o_count || $_fi < $f_count){
            assert($_fi < $f_count || $this->_o_changed[$_oi]);
            assert($_oi < $o_count || $this->_f_changed[$_fi]);
            
            // Skip matching "snake".
            $copy = array();
            while($_oi < $o_count && $_fi < $f_count
                    && !$this->_o_changed[$_oi] && !$this->_f_changed[$_fi]){
                $copy[] = $o_lines[$_oi++];
                $_fi++;
            }
            if($copy){
                $diffs[] = new Befool_Text_Diff_Op_Copy($copy);
            }
            
            // Find deletes & adds.
            $delete = array();
            while($_oi < $o_count && $this->_o_changed[$_oi]){
                $delete[] = $o_lines[$_oi++];
            }
            $add = array();
            while($_fi < $f_count && $this->_f_changed[$_fi]){
                $add[] = $f_lines[$_fi++];
            }
            
            if($delete && $add){
                $diffs[] = new Befool_Text_Diff_Op_Change($delete, $add);
            } elseif($delete){
                $diffs[] = new Befool_Text_Diff_Op_Delete($delete);
            } elseif($add){
                $diffs[] = new Befool_Text_Diff_Op_Add($add);
            }
        }
        return $diffs;
    }
    
    
    /**
     * 何をやっているんだろう？
     * @access     private
     * @param      int     $o_offset
     * @param      int     $o_limit
     * @param      int     $f_offset
     * @param      int     $f_limit
     */
    private function _compareseq($o_offset, $o_limit, $f_offset, $f_limit)
    {
        while($o_offset < $o_limit && $f_offset < $f_limit
                && $this->_o_v[$o_offset] == $this->_f_v[$f_offset]){
            $o_offset++;
            $f_offset++;
        }
        while($o_limit > $o_offset && $f_limit > $f_offset
                && $this->_o_v[$o_limit - 1] == $this->_f_v[$f_limit - 1]){
            $o_limit--;
            $f_limit--;
        }
        
        if($o_offset == $o_limit || $f_offset == $f_limit){
            $lcs = 0;
        } else {
            $nchunks = min(7, $o_limit - $o_offset, $f_limit - $f_offset) + 1;
            list($lcs, $seps) = $this->_diag($o_offset, $o_limit, $f_offset, $f_limit, $nchunks);
        }
        
        if($lcs == 0){
            while($f_offset < $f_limit){
                $this->_f_changed[$this->_f_ind[$f_offset++]] = true;
            }
            while($o_offset < $o_limit){
                $this->_o_changed[$this->_o_ind[$o_offset++]] = true;
            }
        } else {
            reset($seps);
            $pt1 = $seps[0];
            while($pt2 = next($seps)){
                $this->_compareseq($pt1[0], $pt2[0], $pt1[1], $pt2[1]);
                $pt1 = $pt2;
            }
        }
    }
    
    
    /**
     * 難解すぎる…
     * @access     private
     * @param      int     $o_offset
     * @param      int     $o_limit
     * @param      int     $f_offset
     * @param      int     $f_limit
     * @param      int     $nchunks
     */
    private function _diag($o_offset, $o_limit, $f_offset, $f_limit, $nchunks)
    {
        $flip = false;
        if($o_limit - $o_offset > $f_limit - $f_offset){
            $flip = true;
            list($o_offset, $o_limit, $f_offset, $f_limit) = array($f_offset, $f_limit, $o_offset, $o_limit);
        }
        
        $f_matches = array();
        if($flip){
            for($i = $f_limit - 1; $i >= $f_offset; $i--){
                $f_matches[$this->_o_v[$i]][] = $i;
            }
        } else {
            for($i = $f_limit - 1; $i >= $f_offset; $i--){
                $f_matches[$this->_f_v[$i]][] = $i;
            }
        }
        
        $this->_lcs = 0;
        $this->_seq[0]= $f_offset - 1;
        $this->_in_seq = array();
        $f_mids = array();
        $f_mids[0] = array();
        $numer = $o_limit - $o_offset + $nchunks - 1;
        $o = $o_offset;
        
        for($chunk = 0; $chunk < $nchunks; $chunk++){
            if($chunk > 0){
                for($i = 0; $i <= $this->_lcs; $i++){
                    $f_mids[$i][$chunk - 1] = $this->_seq[$i];
                }
            }
            $o1 = $o_offset + (int)(($numer + ($o_limit - $o_offset) * $chunk) / $nchunks);
            for(; $o < $o1; $o++){
                $line = $flip ? $this->_f_v[$o] : $this->_o_v[$o];
                if(empty($f_matches[$line])){
                    continue;
                }
                $matches = $f_matches[$line];
                reset($matches);
                while(list(, $f) = each($matches)){
                    if(empty($this->_in_seq[$f])){
                        $k = $this->_lcsPos($f);
                        assert($k > 0);
                        $f_mids[$k] = $f_mids[$k - 1];
                        break;
                    }
                }
                while(list(, $f) = each($matches)){
                    if($f > $this->_seq[$k - 1]){
                        assert($f <= $this->_seq[$k]);
                        $this->_in_seq[$this->_seq[$k]] = false;
                        $this->_seq[$k] = $f;
                        $this->_in_seq[$f] = true;
                    } elseif(empty($this->_in_seq[$f])){
                        $k = $this->_lcsPos($f);
                        assert($k > 0);
                        $f_mids[$k] = $f_mids[$k - 1];
                    }
                }
            }
        }
        
        $seps = array();
        $seps[] = $flip ? array($f_offset, $o_offset) : array($o_offset, $f_offset);
        $f_mid  = $f_mids[$this->_lcs];
        for($n = 0; $n < $nchunks - 1; $n++){
            $o1 = $o_offset + (int)(($numer + ($o_limit - $o_offset) * $n) / $nchunks);
            $f1 = $f_mid[$n] + 1;
            $seps[] = $flip ? array($f1, $o1) : array($o1, $f1);
        }
        $seps[] = $flip ? array($f_limit, $o_limit) : array($o_limit, $f_limit);
        return array($this->_lcs, $seps);
    }
    
    
    /**
     * まったくついて行けない…
     * @access     private
     * @param      int     $f_pos
     * @return     int
     */
    private function _lcsPos($f_pos)
    {
        $end = $this->_lcs;
        if($end == 0 || $f_pos > $this->_seq[$end]){
            $this->_seq[++$this->_lcs] = $f_pos;
            $this->_in_seq[$f_pos] = true;
            return $this->_lcs;
        }
        
        $beg = 1;
        while($beg < $end){
            $mid = (int)(($beg + $end) / 2);
            if($f_pos > $this->_seq[$mid]){
                $beg = $mid + 1;
            } else {
                $end = $mid;
            }
        }
        
        assert($f_pos != $this->_seq[$end]);
        $this->_in_seq[$this->_seq[$end]] = false;
        $this->_seq[$end] = $f_pos;
        $this->_in_seq[$f_pos] = true;
        return $end;
    }
    
    
    /**
     * もう何も言えません。
     * @access     private
     * @param      array   $lines
     * @param      array   $o_changed
     * @param      array   $f_changed
     */
    private function _shiftBoundaries($lines, &$o_changed, $f_changed)
    {
        $i = 0;
        $j = 0;
        $o_len = count($lines);
        $f_len = count($f_changed);
        if($o_len != count($o_changed)) return;
        //assert('count($lines) == count($o_changed)');
        
        while (1) {
            while($j < $f_len && $f_changed[$j]){
                $j++;
            }
            while($i < $o_len && !$o_changed[$i]){
                assert('$j < $f_len && !$f_changed[$j]');
                $i++;
                $j++;
                while($j < $f_len && $f_changed[$j]){
                    $j++;
                }
            }
            if($i == $o_len){
                break;
            }
            
            $start = $i;
            while(++$i < $o_len && $o_changed[$i]){
                continue;
            }
            
            do {
                $runlength = $i - $start;
                while($start > 0 && $lines[$start - 1] == $lines[$i - 1]){
                    $o_changed[--$start] = true;
                    $o_changed[--$i] = false;
                    while($start > 0 && $o_changed[$start - 1]){
                        $start--;
                    }
                    assert('$j > 0');
                    while($f_changed[--$j]){
                        continue;
                    }
                    assert('$j >= 0 && !$f_changed[$j]');
                }
                $corresponding = $j < $f_len ? $i : $o_len;
                
                while($i < $o_len && $lines[$start] == $lines[$i]){
                    $o_changed[$start++] = false;
                    $o_changed[$i++] = true;
                    while($i < $o_len && $o_changed[$i]){
                        $i++;
                    }
                    assert('$j < $f_len && ! $f_changed[$j]');
                    $j++;
                    if($j < $f_len && $f_changed[$j]){
                        $corresponding = $i;
                        while($j < $f_len && $f_changed[$j]){
                            $j++;
                        }
                    }
                }
            } while($runlength != $i - $start);
            
            while($corresponding < $i){
                $o_changed[--$start] = true;
                $o_changed[--$i] = false;
                assert('$j > 0');
                while($f_changed[--$j]){
                    continue;
                }
                assert('$j >= 0 && !$f_changed[$j]');
            }
        }
    }
    
    
    
    
    
    /**
     * 二つのdiffをマージする
     * 前提として、オリジナルは二つとも同じものと比較している必要がある
     * @access     public
     * @param      array   $diff1
     * @param      array   $diff2
     * @return     array
     */
    public function merge(array $diff1, array $diff2)
    {
        $diff = array();
        $o_lines = array();
        $o_count = 0;
        $f1_count = 0;
        $f2_count = 0;
        $o_i = 0;
        $f1_i = 0;
        $f2_i = 0;
        $j1 = 0;
        $j2 = 0;
        foreach($diff1 as $_key => $_diff){
            $o_lines = array_merge($o_lines, $_diff->original);
            $o_count += $_diff->countOriginal();
            $f1_count += $_diff->countFinal();
            $diff1[$_key] = clone $_diff;
        }
        foreach($diff2 as $_key => $_diff){
            $f2_count += $_diff->countFinal();
            $diff2[$_key] = clone $_diff;
        }
        //マージ
        $k1 = 0;
        $k2 = 0;
        $_limiter = 0;
        while(isset($diff1[$j1]) || isset($diff2[$j2])){
            $_diff1 = isset($diff1[$j1]) ? $diff1[$j1] : NULL;
            $_diff2 = isset($diff2[$j2]) ? $diff2[$j2] : NULL;
            switch(true){
                //コピー:コピー
                case $_diff1 instanceof Befool_Text_Diff_Op_Copy && $_diff2 instanceof Befool_Text_Diff_Op_Copy:
                    $length = $_diff1->countOriginal() > $_diff2->countOriginal() ? $_diff2->countOriginal() : $_diff1->countOriginal();
                    $original = array_splice($_diff1->original, 0, $length);
                    array_splice($_diff1->final, 0, $length);
                    array_splice($_diff2->original, 0, $length);
                    array_splice($_diff2->final, 0, $length);
                    $_diff = new Befool_Text_Diff_Op_Copy($original);
                    $diff[] = $_diff;
                    if(!$_diff1->countOriginal()) $j1++;
                    if(!$_diff2->countOriginal()) $j2++;
                    break;
                //コピー:追加
                case $_diff1 instanceof Befool_Text_Diff_Op_Copy && $_diff2 instanceof Befool_Text_Diff_Op_Add:
                    $lines = $_diff2->final;
                    $diff[] = new Befool_Text_Diff_Op_Add($lines);
                    $j2++;
                    break;
                //コピー:変更
                case $_diff1 instanceof Befool_Text_Diff_Op_Copy && $_diff2 instanceof Befool_Text_Diff_Op_Change:
                //変更:コピー
                case $_diff1 instanceof Befool_Text_Diff_Op_Change && $_diff2 instanceof Befool_Text_Diff_Op_Copy:
                    $min = $_diff1->countOriginal() > $_diff2->countOriginal() ? 2 : 1;
                    if($min == 1){
                        $length = $_diff1->countOriginal();
                        $original = array_splice($_diff1->original, 0, $length);
                        $final    = array_splice($_diff1->final, 0, $_diff->countFinal());
                        array_splice($_diff2->original, 0, $length);
                        array_splice($_diff2->final, 0, $length);
                        $_diff = new Befool_Text_Diff_Op_Change($original, $final);
                        $diff[] = $_diff;
                    } else {
                        $length = $_diff2->countOriginal();
                        $original = array_splice($_diff2->original, 0, $length);
                        $final    = array_splice($_diff2->final, 0, $_diff->countFinal());
                        array_splice($_diff1->original, 0, $length);
                        array_splice($_diff1->final, 0, $length);
                        $_diff = new Befool_Text_Diff_Op_Change($original, $final);
                        $diff[] = $_diff;
                    }
                    if(!$_diff1->countOriginal()) $j1++;
                    if(!$_diff2->countOriginal()) $j2++;
                    break;
                //変更:変更
                case $_diff1 instanceof Befool_Text_Diff_Op_Change && $_diff2 instanceof Befool_Text_Diff_Op_Change:
                    $length = 1;
                    $original = array_splice($_diff1->original, 0, $length);
                    $final1   = array_splice($_diff1->final, 0, $length);
                    $final2   = array_splice($_diff2->final, 0, $length);
                    array_splice($_diff2->original, 0, $length);
                    //お互いの変更が同一の場合
                    if($final1[0] == $final2[0]){
                        $diff[] = new Befool_Text_Diff_Op_Change($original, $final1);
                    //お互いに違う変更を加えている場合
                    } else {
                        $diff[] = new Befool_Text_Diff_Op_Conflict($original, $final1, $final2);
                    }
                    if(!$_diff1->countOriginal() && $_diff1->countFinal()){
                        $diff1[$j1] = new Befool_Text_Diff_Op_Add($_diff1->final);
                    } elseif($_diff1->countOriginal() && !$_diff1->countFinal()){
                        $diff1[$j1] = new Befool_Text_Diff_Op_Delete($_diff1->original);
                    } elseif(!$_diff1->countOriginal() && !$_diff1->countFinal()){
                        $j1++;
                    }
                    if(!$_diff2->countOriginal() && $_diff2->countFinal()){
                        $diff2[$j2] = new Befool_Text_Diff_Op_Add($_diff2->final);
                    } elseif($_diff2->countOriginal() && !$_diff2->countFinal()){
                        $diff2[$j2] = new Befool_Text_Diff_Op_Delete($_diff2->original);
                    } elseif(!$_diff2->countOriginal() && !$_diff2->countFinal()){
                        $j2++;
                    }
                    break;
                //削除:コピー
                case $_diff1 instanceof Befool_Text_Diff_Op_Delete && $_diff2 instanceof Befool_Text_Diff_Op_Copy:
                    $length = $_diff1->countOriginal();
                    $lines = array_splice($_diff1->original, 0, $length);
                    array_splice($_diff2->original, 0, $length);
                    array_splice($_diff2->final, 0, $length);
                    $diff[] = new Befool_Text_Diff_Op_Delete($lines);
                    $j1++;
                    if(!$_diff2->countOriginal()) $j2++;
                    break;
                //削除:削除
                case $_diff1 instanceof Befool_Text_Diff_Op_Delete && $_diff2 instanceof Befool_Text_Diff_Op_Delete:
                    $length = $_diff1->countOriginal() > $_diff2->countOriginal() ? $_diff2->countOriginal() : $_diff1->countOriginal();
                    $lines = array_splice($_diff1->original, 0, $length);
                    array_splice($_diff2->original, 0, $length);
                    $diff[] = new Befool_Text_Diff_Op_Delete($lines);
                    if(!$_diff1->countOriginal()) $j1++;
                    if(!$_diff2->countOriginal()) $j2++;
                    break;
                //追加:コピー
                case $_diff1 instanceof Befool_Text_Diff_Op_Add && $_diff2 instanceof Befool_Text_Diff_Op_Copy:
                    $lines = $_diff1->final;
                    $diff[] = new Befool_Text_Diff_Op_Add($lines);
                    $j1++;
                    break;
                //追加:追加
                case $_diff1 instanceof Befool_Text_Diff_Op_Add && $_diff2 instanceof Befool_Text_Diff_Op_Add:
                    $lines = $_diff1->final;
                    $lines2 = $_diff2->final;
                    foreach($lines2 as $_key => $line){
                        if(!isset($lines[$_key]) || $lines[$_key] != $line){
                            $lines[] = $line;
                        }
                    }
                    $diff[] = new Befool_Text_Diff_Op_Add($lines);
                    $j1++;
                    $j2++;
                    break;
                //追加:NULL
                case $_diff1 instanceof Befool_Text_Diff_Op_Add && !$_diff2:
                    $length = $_diff1->countFinal();
                    $lines = array_splice($_diff1->final, 0, $length);
                    $diff[] = new Befool_Text_Diff_Op_Add($lines);
                    $j1++;
                    break;
                //NULL:追加
                case !$_diff1 && $_diff2 instanceof Befool_Text_Diff_Op_Add:
                    $length = $_diff2->countFinal();
                    $lines = array_splice($_diff2->final, 0, $length);
                    $diff[] = new Befool_Text_Diff_Op_Add($lines);
                    $j2++;
                    break;
                default:
                    var_dump($_diff1, $_diff2);
                    exit;
                    break;
            }
            $_limiter++;
            if($_limiter > 100){
                var_dump($_diff1, $_diff2);
                exit;
            }
        }
        return $diff;
    }
    
    
    
    
    
    /**
     * 初期化
     * @access     public
     */
    public function clear()
    {
        $this->_o_changed = array();
        $this->_f_changed = array();
        $this->_o_v = array();
        $this->_f_v = array();
        $this->_o_ind = array();
        $this->_f_ind = array();
        $this->_lcs = 0;
        $this->_seq = array();
        $this->_in_seq = array();
    }
    
    
    /**
     * 衝突しているかどうか
     * @param      array   $diffs
     * @return     boolean
     */
    public function isConflict(array $diffs)
    {
        foreach($diffs as $diff){
            if($diff instanceof Befool_Text_Diff_Op_Conflict){
                return true;
            }
        }
        return false;
    }
}

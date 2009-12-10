<?php
/**
 * スタンダードなWIKI表記を解釈するパーサー
 *
 * DOMベースではなく、簡易記述で実現可能な表記への対応。
 * DOMでコンバートされた後にこちらが動作するので、注意が必要。
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Parser
{
    public
        $Device;
    private
        $_h_start = 3;
    
    
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * wiki表記をパースし、かつ解釈する
     *
     * @access     public
     * @param      string  $text   対象テキスト
     * @return     string
     */
    public function parseAndRender($text)
    {
        $blocks = $this->parse($text);
        $html   = $this->render($blocks);
        return $html;
    }


    /**
     * パースする
     *
     * @access     public
     * @param      string  $text   対象テキスト
     * @return     array   パースされてブロックに分割されたブロック群
     */
    public function parse($text)
    {
        $blocks = array();
        if(!is_array($text)){
            $text = str_replace(array("\r\n", "\r"), "\n", $text);
            $text = explode("\n", $text);
        }
        
        //メインループ
        $last_el = '';
        while($text){
            $line = array_shift($text);
            $option = new stdClass();
            
            $el = $this->_checkBlock($line, $option);
            switch($el){
                case 'h':
                    $this->_removeBeforeEob($blocks);
                    $level = $this->_checkLevel($line);
                    $blocks[] = $this->_addBlock($el, $line, $level);
                    $this->_removeNextEob($text);
                    break;
                case 'ul':
                case 'ol':
                    $level = $this->_checkLevel($line);
                    if($el == $last_el){
                        $this->_addBlockToLast($blocks, $el, $line, $level);
                    } else {
                        $blocks[] = $this->_addBlock($el, $line, $level);
                    }
                    break;
                case 'hr':
                    $blocks[] = $this->_addBlock($el, $line);
                    break;
                case 'noneparse':
                    $line = $this->_cutTo($text, '}}}');
                    $blocks[] = $this->_addBlock($el, $line);
                    break;
                case 'else':
                    if($el == $last_el){
                        $this->_addBlockToLast($blocks, 'p', $line);
                    } else {
                        $blocks[] = $this->_addBlock('p', $line);
                    }
                    break;
                case 'eob':
                    $blocks[] = $this->_addBlock($el, $line);
                    break;
            }
            
            $last_el = $el;
        }
        
        return $blocks;
    }


    /**
     * ブロックの種類を取得する
     *
     * @access     private
     * @param      string  $line
     * @param      object  $option
     * @return     string
     */
    private function _checkBlock($line, $option)
    {
        if($line == '') return 'eob';
        switch(true){
            case $line[0] == '*':
                return 'h';
                break;
            case $line[0] == '-' && strpos($line, '----') === 0:
                return 'hr';
                break;
            case $line[0] == '-':
                return 'ul';
                break;
            case $line[0] == '+':
                return 'ol';
                break;
            case $line[0] == '{' && strpos($line, '{{{') === 0:
                return 'noneparse';
                break;
            case rtrim($line) == '':
            //case rtrim(strtoupper($line)) == '<BR />':
                return 'eob';
                break;
            default:
                return 'else';
                break;
        }
    }


    /**
     * 階層の深さを調べる
     *
     * @access     private
     * @param      string  $line
     */
    private function _checkLevel(&$line)
    {
        if($line[0] == $line[1]){
            if($line[0] == $line[2]){
                $line = trim(substr($line, 3));
                return 3;
            }
            $line = trim(substr($line, 2));
            return 2;
        }
        $line = trim(substr($line, 1));
        return 1;
    }


    /**
     * ブロックを追加する
     *
     * @access     private
     * @param      string  $el
     * @param      string  $line
     * @param      int     $level
     * @return     object  ブロック
     */
    private function _addBlock($el, $line, $level=0, $option=NULL)
    {
        $block = new stdClass();
        $content = new stdClass();
        $block->element = $el;
        $block->contents = array($content);
        $content->line = $line;
        $content->level = $level;
        $content->option = $option;
        return $block;
    }


    /**
     * ブロックを最後の要素に追加する
     *
     * @access     private
     * @param      array   $blocks
     * @param      string  $el
     * @param      string  $line
     * @param      int     $level
     */
    private function _addBlockToLast(&$blocks, $el, $line, $level=0, $option=NULL)
    {
        $block = array_pop($blocks);
        $content = new stdClass();
        $content->line = $line;
        $content->level = $level;
        $content->option = $option;
        $block->contents[] = $content;
        array_push($blocks, $block);
    }


    /**
     * 指定の文字列までを取り込む
     *
     * @access     private
     * @param      array   $text
     * @param      string  $eob
     * @param      boolean $onlyline
     * @return     string
     */
    private function _cutTo(&$text, $eob, $onlyline=true)
    {
        $cutted = '';
        while($line = array_shift($text)){
            if($onlyline && preg_match('/^' . preg_quote($eob, '/') . '$/', $line)){
                break;
            } elseif(!$onlyline && strpos($line, $eob) !== false){
                list($pre, $post) = explode($eob, $line, 2);
                $cutted .= $line;
                array_unshift($text, $post);
                break;
            } else {
                $cutted .= $line . "\n";
            }
        }
        return $cutted;
    }





    /**
     * パースされたブロック群から、HTMLを生成する
     *
     * @access     public
     * @param      array   $blocks
     * @return     string
     */
    public function render($blocks)
    {
        $html = '';
        foreach($blocks as $block){
            $html .= $this->_renderBlock($block)."\n";
        }
        return $html;
    }


    /**
     * ブロック要素を解釈する
     *
     * @access     private
     * @param      object  $block
     * @return     string
     */
    private function _renderBlock($block)
    {
        $html = '';
        switch($block->element){
            case 'h':
                $level = $block->contents[0]->level + $this->_h_start -1;
                $line  = preg_replace('|<br />$|i', '', $block->contents[0]->line);
                if(preg_match('/^([a-z0-9]+)\*(.*)/', $line, $matches)){
                    $id = $matches[1];
                    $line = $matches[2];
                } else {
                    $id = uniqid();
                }
                $html = sprintf('<h%d id="%s"><a href="#%s">%s</a></h%d>', $level, $id, $id, $line, $level);
                break;
            case 'ul':
                $now_level = 0;
                foreach($block->contents as $content){
                    $html .= $this->_renderList($block->element, $content->line, $content->level, $now_level);
                }
                $html .= $this->_renderList($block->element, '', 0, $now_level);
                break;
            case 'ol':
                $now_level = 0;
                foreach($block->contents as $content){
                    $html .= $this->_renderList($block->element, $content->line, $content->level, $now_level);
                }
                $html .= $this->_renderList($block->element, '', 0, $now_level);
                break;
            case 'p':
                foreach($block->contents as $_key => $content){
                    $html .= $content->line . "\n";
                }
                $html = '<p>' . $html . '</p>';
                break;
            case 'hr':
                $html = '<hr />';
                break;
            case 'noneparse':
                $html = $block->contents[0]->line;
                break;
            case 'eob':
                $html = '';
                break;
        }
        return $html;
    }


    /**
     * リストを解釈する
     *
     * @access     private
     * @param      string  $el
     * @param      string  $line
     * @return     int     $level
     * @param      int     $now_level
     * @return     string
     */
    private function _renderList($el, $line, $level, &$now_level=0)
    {
        $html = '';
        if($level == $now_level){
            
        } elseif($level > $now_level){
            for($i = $now_level; $i < $level; $i++){
                $html .= sprintf('<%s>', strtolower($el)) . "\n";
            }
        } elseif($level < $now_level){
            for($i = $now_level; $i > $level; $i--){
                $html .= sprintf('</%s>', strtolower($el)) . "\n";
            }
        }
        
        $now_level = $level;
        
        if($line != ''){
            $line = preg_replace('|<br />$|i', '', $line);
            $html .= sprintf('<li>%s</li>', $line) . "\n";
        }
        
        return $html;
    }





    /**
     * 直後のeobを取り除く
     *
     * @access     private
     * @param      array   $text
     */
    private function _removeNextEob(&$text)
    {
        $line = array_shift($text);
        if(is_string($line) && strtoupper($line) !== '<br />'){
            array_unshift($text, $line);
        }
    }


    /**
     * 直前ののeobを取り除く
     *
     * @access     private
     * @param      array   $text
     */
    private function _removeBeforeEob(&$blocks)
    {
        if($blocks){
            $block = array_pop($blocks);
            if($block->element != 'eob'){
                array_push($blocks, $block);
            }
        }
    }





    /**
     * 見出しにIDを振ったりなど
     * ユーザー入力の補完を行う
     *
     * @access     public
     * @param      string  $text
     * @return     string
     */
    public function supplement($text)
    {
        $text = str_replace(array("\r\n", "\r"), "\n", $text);
        $text = explode("\n", $text);
        $blocks = array();
        
        //メインループ
        $last_el = '';
        while($text){
            $line = array_shift($text);
            $option = new stdClass();
            
            $el = $this->_checkBlock($line, $option);
            switch($el){
                case 'h':
                    if(!preg_match('/^\*+[a-z0-9]+\*/', $line)){
                        $line = mb_ereg_replace('^(\*+)(.*)', sprintf('\\1%s*\\2', uniqid()), $line);
                    }
                    $blocks[] = $line;
                    break;
                default:
                    $blocks[] = $line;
                    break;
            }
            
            $last_el = $el;
        }
        
        return join("\n", $blocks);
    }
}

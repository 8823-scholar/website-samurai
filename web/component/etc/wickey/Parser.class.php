<?php
/**
 * スタンダードなWIKI表記を解釈するパーサー
 *
 * DOMベースではなく、一般的なWIKI表記実現する。
 * DOMでコンバートするまえにこちらに通される。
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Parser
{
    /**
     * Deviceコンポーネント
     *
     * @access   public
     * @var      object   Etc_Device
     */
    public $Device;

    /**
     * hがスタートするレベル
     *
     * @access   private
     * @var      int
     */
    private $_h_start = 3;

    /**
     * セクションの集合
     * (セクションとはHによって区切られるブロックのさらにブロックである)
     *
     * @access   private
     * @var      array
     */
    private $_sections = array();

    /**
     * ブロックの集合
     *
     * @access   private
     * @var      array
     */
    private $_blocks = array();

    /**
     * 見出し(h)のリスト
     *
     * @access   private
     * @var      array
     */
    private $_headings = array();


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
        $this->parse($text);
        $html = $this->render();
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
        $this->_sections = array();
        $this->_blocks = array();
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
                    $level = $this->_checkLevel($line);
                    $this->_addBlock($el, $line, $level);
                    break;
                case 'ul':
                case 'ol':
                    $level = $this->_checkLevel($line);
                    if($el == $last_el){
                        $this->_addBlockToLast($el, $line, $level);
                    } else {
                        $this->_addBlock($el, $line, $level);
                    }
                    break;
                case 'table':
                    if($el == $last_el){
                        $this->_addBlockToLast($el, $line);
                    } else {
                        $this->_addBlock($el, $line);
                    }
                    break;
                case 'code':
                    $line = $this->_cutTo($text, '||&lt;');
                    $this->_addBlock($el, $line, 0, $option);
                    break;
                case 'quote':
                    $level = $this->_checkLevel($line, 4);
                    if($el == $last_el){
                        $this->_addBlockToLast($el, $line, $level);
                    } else {
                        $this->_addBlock($el, $line, $level);
                    }
                    break;
                case 'hr':
                    $this->_addBlock($el, $line);
                    break;
                case 'noneparse':
                    $line = $this->_cutTo($text, '}}}');
                    $this->_addBlock($el, $line);
                    break;
                case 'else':
                    if($el == $last_el){
                        $this->_addBlockToLast('p', $line);
                    } else {
                        $this->_addBlock('p', $line);
                    }
                    break;
                case 'eob':
                    $this->_addBlock($el, $line);
                    break;
            }
            
            $last_el = $el;
        }

        $this->_revolveSection(true);
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
            case $line[0] == '|' && preg_match('/^\|.*?\|$/', $line):
                return 'table';
                break;
            case $line[0] == '&' && preg_match('/^&gt;\|(.+)?\|/', $line, $matches):
                $option->type = isset($matches[1]) ? $matches[1] : NULL ;
                return 'code';
                break;
            case $line[0] == '&' && strpos($line, '&gt;') === 0:
                return 'quote';
                break;
            case $line[0] == '{' && strpos($line, '{{{') === 0:
                return 'noneparse';
                break;
            case rtrim($line) == '':
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
     * @param      int     $length   チェックする文字列の長さ
     * @return     int
     */
    private function _checkLevel(&$line, $length = 1)
    {
        $char = substr($line, 0, $length);
        for($i = 0; $i < 3; $i++){
            if($char != substr($line, $length * $i, $length)){
                break;
            }
        }
        $line = trim(substr($line, $length * $i));
        return $i;
    }


    /**
     * ブロックをセクションに格納し、ブロック自体は空にする
     *
     * @access     private
     * @param      boolean   $force
     */
    private function _revolveSection($force = false)
    {
        if($force || $this->_blocks){
            $this->_sections[] = $this->_blocks;
            $this->_blocks = array();
        }
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
        if($el == 'h' && $level == 1){
            $this->_revolveSection();
        }
        $block = new stdClass();
        $content = new stdClass();
        $block->element = $el;
        $block->contents = array($content);
        $content->line = $line;
        $content->level = $level;
        $content->option = $option;
        $this->_blocks[] = $block;
    }


    /**
     * ブロックを最後の要素に追加する
     *
     * @access     private
     * @param      string  $el
     * @param      string  $line
     * @param      int     $level
     */
    private function _addBlockToLast($el, $line, $level=0, $option=NULL)
    {
        $block = array_pop($this->_blocks);
        $content = new stdClass();
        $content->line = $line;
        $content->level = $level;
        $content->option = $option;
        $block->contents[] = $content;
        array_push($this->_blocks, $block);
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
        while(($line = array_shift($text)) || $line !== NULL){
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
    public function render()
    {
        $html = array();
        foreach($this->_sections as $section){
            $html[] = '<div class="section">';
            foreach($section as $block){
                $html[] = $this->_renderBlock($block);
            }
            $html[] = '</div>';
        }
        //echo nl2br(htmlspecialchars(join("\n", $html)));
        return join("\n", $html);
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
                $line  = $block->contents[0]->line;
                if(preg_match('/^([a-z0-9:_\-]+)\*(.*)/', $line, $matches)){
                    $id = $matches[1];
                    $line = $matches[2];
                } else {
                    $id = uniqid();
                }
                $html = sprintf('<h%d id="%s"><a href="#%s">%s</a></h%d>', $level, $id, $id, $line, $level);
                $this->_headings[] = array('id' => $id, 'level' => $level, 'value' => $line);
                break;
            case 'ul':
            case 'ol':
                $now_level = 0;
                foreach($block->contents as $content){
                    $html .= $this->_renderList($block->element, $content->line, $content->level, $now_level);
                }
                $html .= $this->_renderList($block->element, '', 0, $now_level);
                break;
            case 'table':
                $html .= '<table>';
                foreach($block->contents as $content){
                    $html .= $this->_renderTable($content->line);
                }
                $html .= '</table>';
                break;
            case 'code':
                $content = $block->contents[0];
                if($type = $content->option->type){
                    $html .= '<modifier code="' . $type . '">' . $content->line . '</modifier>';
                } else {
                    $html .= '<modifier code>' . $content->line . '</modifier>';
                }
                break;
            case 'quote':
                $now_level = 0;
                foreach($block->contents as $content){
                    $html .= $this->_renderQuote($content->line, $content->level, $now_level);
                }
                $html .= $this->_renderQuote('', 0, $now_level);
                break;
            case 'p':
                foreach($block->contents as $_key => $content){
                    $html .= $content->line . "<br />\n";
                }
                $html = '<div class="paragraph">' . $html . '</div>';
                break;
            case 'hr':
                $html = '<hr />';
                break;
            case 'noneparse':
                $html = '<noparse>' . nl2br($block->contents[0]->line) . '</noparse>';
                break;
            case 'eob':
                $html = '';
                break;
        }
        return $html;
    }


    /**
     * リストを描画する
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
            $html .= sprintf('<li>%s</li>', $line) . "\n";
        }
        
        return $html;
    }

    /**
     * テーブルを描画する
     *
     * @access     private
     * @param      string   $line
     * @return     string
     */
    private function _renderTable($line)
    {
        $html = '<tr>';
        $cols = explode('|', $line);
        array_pop($cols);
        array_shift($cols);
        foreach($cols as $col){
            $styles = array();
            while(preg_match('/^([a-z]+)(\((.+?)\))?:/i', $col, $matches)){
                $col = substr($col, strlen($matches[0]));
                switch(strtolower($matches[1])){
                    case 'width':
                        if(isset($matches[3])) $styles[] = 'width:' . $matches[3];
                        break;
                    case 'color':
                        if(isset($matches[3])) $styles[] = 'color:' . $matches[3];
                        break;
                    case 'bgcolor':
                        if(isset($matches[3])) $styles[] = 'background-color:' . $matches[3];
                        break;
                    case 'left':
                    case 'center':
                    case 'right':
                        $styles[] = 'text-align:' . strtolower($matches[1]);
                        break;
                }
            }
            $style = $styles ? sprintf(' style="%s"', htmlspecialchars(join(';', $styles))) : '' ;
            if(preg_match('/^\*/', $col)){
                $html .= sprintf('<th%s>%s</th>', $style, substr($col, 1));
            } else {
                $html .= sprintf('<td%s>%s</td>', $style, $col);
            }
        }
        $html .= '</tr>';
        return $html;
    }

    /**
     * 引用を描画する
     *
     * @access     private
     * @param      string  $line
     * @return     int     $level
     * @param      int     $now_level
     * @return     string
     */
    private function _renderQuote($line, $level, &$now_level=0)
    {
        $html = '';
        if($level == $now_level){
            
        } elseif($level > $now_level){
            for($i = $now_level; $i < $level; $i++){
                $html .= '<blockquote>' . "\n";
            }
        } elseif($level < $now_level){
            for($i = $now_level; $i > $level; $i--){
                $html .= '</blockquote>' . "\n";
            }
        }
        
        $now_level = $level;
        $html .= $line . "<br />\n";
        return $html;
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
        $blocks = array();
        $text = str_replace(array("\r\n", "\r"), "\n", $text);
        $text = explode("\n", $text);
        
        //メインループ
        $last_el = '';
        while($text){
            $line = array_shift($text);
            $option = new stdClass();
            
            $el = $this->_checkBlock($line, $option);
            switch($el){
                case 'h':
                    if(!preg_match('/^\*+[a-z0-9:_\-]+\*/', $line)){
                        $line = mb_ereg_replace('^(\*+)(.*)', sprintf('\\1%s*\\2', uniqid()), $line);
                    }
                    $blocks[] = $line;
                    break;
                case 'noneparse':
                    $line = $this->_cutTo($text, '}}}');
                    $blocks[] = '{{{';
                    $blocks[] = $line . '}}}';
                    break;
                default:
                    $blocks[] = $line;
                    break;
            }
            
            $last_el = $el;
        }
        
        return join("\n", $blocks);
    }


    /**
     * パーサーを初期化する
     *
     * @access     public
     */
    public function clear()
    {
        $this->_headings = array();
    }


    /**
     * 見出しのリストを取得する
     *
     * @access     public
     * @return     array
     */
    public function getHeadings()
    {
        return $this->_headings;
    }
}

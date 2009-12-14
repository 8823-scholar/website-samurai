<?php
/**
 * WIKIインライン表記パーサー
 *
 * DOMベースではなく、簡易記述で実現可能な表記への対応。
 * リンクの解釈などはここで行われる
 *
 *  ・URLのリンク化
 *  ・メールアドレスのリンク化
 *  ・脚注
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Inliner
{
    /**
     * Deviceコンポーネント
     *
     * @access   public
     * @var      object
     */
    public $Device;

    /**
     * 脚注の控え
     *
     * @access   private
     * @var      array
     */
    private $_footnotes = array();

    /**
     * URLの正規表現
     *
     * @access   private
     * @var      string
     */
    private $_pattern_url = '[a-zA-Z0-9\+]+:\/\/[a-zA-Z0-9%&=\.\/\?\-]+';

    /**
     * メールアドレスの正規表現
     *
     * @access   private
     * @var      string
     */
    private $_pattern_mail = '[a-zA-Z0-9_\-\.]+@[a-zA-Z]([a-zA-Z0-9\-]+)?\.[a-zA-Z\.]+';


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * インライン文字列を解釈する
     *
     * @access     public
     * @param      string  $text
     * @param      object  $option
     * @return     string
     */
    public function render($text, $option = NULL)
    {
        //オートリンク
        if(!isset($option->in_a) || !$option->in_a){
            $pattern = '/(\[\[(?:(.+?)&gt;)?(.+?)(?::(?!\/\/)(.+?))?\]\]|(' . $this->_pattern_url . ')|(' . $this->_pattern_mail . '))/i';
            $text = preg_replace_callback($pattern, array($this, '_renderLinkCallback'), $text);
        }

        //脚注
        $pattern = '/(^|[^\(])?\(\(([^\(\)]+?)\)\)([^\)]|$)/';
        $text = preg_replace_callback($pattern, array($this, '_renderFootnoteCallBack'), $text);
        return $text;
    }


    /**
     * リンク文字列を解釈する
     *
     * <code>
     *     [[wikiname]]
     *     [[alias>wikiname]]
     *     [[alias>http://example.jp/]]
     *     [[alias>foo@example.jp]]
     *     http://example.jp/
     *     foo@example.jp
     * </code>
     *
     * @access     private
     * @param      array    $matches   HITした部分
     * @return     string
     */
    private function _renderLinkCallback(array $matches)
    {
        //hitした文字列がURLそのものの場合
        $string = isset($matches[1]) ? $matches[1] : '' ;
        $alias = isset($matches[2]) ? $matches[2] : '' ;
        $wikiname = isset($matches[3]) ? $matches[3] : '' ;
        
        //URLの場合
        if(preg_match('/^' . $this->_pattern_url . '$/', $string)
            || preg_match('/^' . $this->_pattern_url . '$/', $wikiname)){
            $href = $wikiname != '' ? $wikiname : $string;
            return sprintf('<a href="%s" target="_blank">%s</a>', $href, $alias != '' ? $alias : $string);
        //メールアドレスの場合
        } elseif(preg_match('/^' . $this->_pattern_mail . '$/', $string)
            || preg_match('/^' . $this->_pattern_mail . '$/', $wikiname)){
            $href = $wikiname != '' ? $wikiname : $string;
            return sprintf('<a href="mailto:%s">%s</a>', $href, $alias != '' ? $alias : $string);
        } else {
            $href = urlencode($wikiname);
            return sprintf('<a href="%s">%s</a>', $href, $alias != '' ? $alias : $wikiname);
        }
    }


    /**
     * 脚注を解釈する
     *
     * @access     private
     * @param      array    $matches   HITした部分
     * @return     string
     */
    private function _renderFootnoteCallBack(array $matches)
    {
        $index = count($this->_footnotes) + 1;
        $this->_footnotes[$index] = $matches[2];
        return sprintf('%s<a href="#footnote:%d" id="footnote:anchor:%d" class="footnote" title="%s">*%d</a>%s',
                            $matches[1], $index, $index, htmlspecialchars($matches[2]), $index, $matches[3]);
    }




    /**
     * ストックされた脚注を取得する
     *
     * @access     public
     * @return     array
     */
    public function getFootnotes()
    {
        return $this->_footnotes;
    }


    /**
     * インライナーを初期化する
     *
     * @access     public
     */
    public function clear()
    {
        $this->_footnotes = array();
    }
}

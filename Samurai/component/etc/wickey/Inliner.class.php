<?php
/**
 * WIKIインライン表記パーサー
 *
 * DOMベースではなく、簡易記述で実現可能な表記への対応。
 * リンクの解釈などはここで行われる
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Inliner
{
    public
        $Device,
        $Request;
    private
        $_pattern_url = '[a-zA-Z0-9\+]+:\/\/[a-zA-Z0-9%&=\.\/\?\-]+',
        $_pattern_mail = '[a-zA-Z0-9_\-\.]+@[a-zA-Z]([a-zA-Z0-9\-]+)?\.[a-zA-Z\.]+';
    
    
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
    public function render($text, $option)
    {
        if(!isset($option->in_a) || !$option->in_a){
            $text = $this->_renderLink($text);
        }
        return $text;
    }


    /**
     * リンクを解釈する
     *
     * @access     private
     * @param      string  $text
     * @return     string
     */
    private function _renderLink($text)
    {
        //[[pagename]]
        //[[machi:pagename]]
        //[[alias>pagename]]
        //[[alias>machi:pagename]]
        $pattern = '/(\[\[(?:(.+?)&gt;)?(.+?)(?::(?!\/\/)(.+?))?\]\]|(' . $this->_pattern_url . ')|(' . $this->_pattern_mail . '))/i';
        $text = preg_replace_callback($pattern, array($this, '_renderLinkCallback'), $text);
        return $text;
    }
    private function _renderLinkCallback($matches)
    {
        //hitした文字列がURLそのものの場合
        $text = isset($matches[1]) ? $matches[1] : '' ;
        $alias = isset($matches[2]) ? $matches[2] : '' ;
        $pagename = isset($matches[3]) ? $matches[3] : '' ;
        //URLの場合
        if(preg_match('/^' . $this->_pattern_url . '$/', $text)
            || preg_match('/^' . $this->_pattern_url . '$/', $pagename)){
            $href = $pagename != '' ? $pagename : $text;
            return sprintf('<a href="%s" target="_blank">%s</a>', $href, $alias != '' ? $alias : $text);
        //メールアドレスの場合
        } elseif(preg_match('/^' . $this->_pattern_mail . '$/', $text)
            || preg_match('/^' . $this->_pattern_mail . '$/', $pagename)){
            $href = $pagename != '' ? $pagename : $text;
            return sprintf('<a href="mailto:%s">%s</a>', $href, $alias != '' ? $alias : $text);
        } else {
            $href = BASE_URI . '/' . urlencode($pagename);
            return sprintf('<a href="%s">%s</a>', $href, $alias != '' ? $alias : $pagename);
        }
    }
}

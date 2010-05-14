<?php
/**
 * DOMのパーサー
 *
 * PHP標準のDOMクラス群では、余計な事をされたり、不便だったりで、
 * やきもきすることが多かったので、余計なことは一切やらないDOMクラスを作成しました。
 * DOMの基本的な事はサポートしています。
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Dom_Parser
{
    const
        ST_ROOT = 0,
        ST_TEXT = 1,
        ST_TAG_OPEN = 2,
        ST_TAG_NAME = 3,
        ST_TAG_CLOSE = 4,
        ST_TAG_SINGLE = 5,
        ST_TAG_ATTRIBUTES = 6,
        ST_CDATA = 7,
        ST_COMMENT = 8,
        ST_DOCTYPE = 9,
        ST_XMLDEC = 10,
        ST_PREPROC = 11,
        ST_ATTR_KEY = 12,
        ST_ATTR_EQ = 13,
        ST_ATTR_QUOTE = 14,
        ST_ATTR_VALUE = 15;
    private
        $_line = 0,
        $_root,
        $_current,
        $_stack = array(),
        $_bom_string = "\xef\xbb\xbf",
        $_document;
    
    
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * 文書のパース
     *
     * @access     public
     * @param      string  $text
     * @return     object  Etc_Dom_NodeList
     */
    public function parse($text)
    {
        //BOM除去
        if(substr($text, 0, 3) == $this->_bom_string){
            $text = substr($text, 3);
        }
        //改行の統一
        $text = str_replace(array("\r\n", "\r"), "\n", $text);
        //初期状態
        $this->_line = 1;
        $state = self::ST_ROOT;
        $char = '';
        $mark = 0;
        $length = mb_strlen($text);
        $quote = '';
        $tagname    = '';
        $attribute  = '';
        $attributes = array();
        //echo nl2br(htmlspecialchars($text));
        
        //解析ループ開始
        $this->_onDocumentStart();
        for($i = 0; $i < $length; $i++){
            $last_char = $char;
            $char = mb_substr($text, $i, 1);
            if($char == "\n") $this->_line++;
            
            switch($state){
                case self::ST_ROOT:
                    if($char == '<'){
                        if($mark != $i){
                            $this->_onTextData(mb_substr($text, $mark, $i - $mark));
                        }
                        $mark = $i;
                        $state = self::ST_TAG_OPEN;
                    } else {
                        $state = self::ST_TEXT;
                    }
                    break;
                    
                case self::ST_TEXT:
                    if($char == '<'){
                        if($mark != $i){
                            $this->_onTextData(mb_substr($text, $mark, $i - $mark));
                        }
                        $mark = $i;
                        $state = self::ST_TAG_OPEN;
                    }
                    break;
                    
                case self::ST_TAG_OPEN:
                    if($char == '/'){
                        $mark = $i + 1;
                        $state = self::ST_TAG_CLOSE;
                    }
                    elseif($char == '?' && mb_substr($text, $i, 4) == '?xml'){
                        $state = self::ST_XMLDEC;
                    }
                    elseif($char == '?'){
                        $state = self::ST_PREPROC;
                    }
                    elseif($char == '!' && mb_substr($text, $i, 3) == '!--'){
                        $state = self::ST_COMMENT;
                    }
                    elseif($char == '!' && mb_substr($text, $i, 8) == '![CDATA['){
                        $state = self::ST_CDATA;
                    }
                    elseif($char == '!' && mb_substr($text, $i, 8) == '!DOCTYPE'){
                        $state = self::ST_DOCTYPE;
                    }
                    elseif($this->isAlpha($char)){
                        $mark = $i;
                        $attributes = array();
                        $attribute = '';
                        $state = self::ST_TAG_NAME;
                    }
                    else {
                        $state = self::ST_TEXT;
                    }
                    break;
                    
                case self::ST_TAG_NAME:
                    if($this->isWhiteChar($char)){
                        $tagname = mb_substr($text, $mark, $i - $mark);
                        $state = self::ST_TAG_ATTRIBUTES;
                    }
                    elseif($char == '/'){
                        $tagname = mb_substr($text, $mark, $i - $mark);
                        $state = self::ST_TAG_SINGLE;
                    }
                    elseif($char == '>'){
                        $tagname = mb_substr($text, $mark, $i - $mark);
                        $mark = $i + 1;
                        $state = self::ST_TEXT;
                        $this->_onElementOpen($tagname, $attributes);
                    }
                    break;
                    
                case self::ST_TAG_CLOSE:
                    if($char == '>'){
                        $tagname = rtrim(mb_substr($text, $mark, $i - $mark));
                        $this->_onElementClose($tagname);
                        $mark = $i + 1;
                        $state = self::ST_TEXT;
                    }
                    break;
                    
                case self::ST_TAG_SINGLE:
                    $mark = $i + 1;
                    $state = self::ST_TEXT;
                    $this->_onElementOpen($tagname, $attributes);
                    $this->_current->single = true;
                    $this->_onElementClose($tagname);
                    break;
                    
                case self::ST_TAG_ATTRIBUTES:
                    if($char == '>'){
                        $mark = $i + 1;
                        $state = self::ST_TEXT;
                        $this->_onElementOpen($tagname, $attributes);
                    }
                    elseif($char == '/'){
                        $state = self::ST_TAG_SINGLE;
                    }
                    elseif($this->isWhiteChar($char)){
                        
                    }
                    else {
                        $mark = $i;
                        $state = self::ST_ATTR_KEY;
                    }
                    break;
                    
                case self::ST_ATTR_KEY:
                    if($this->isWhiteChar($char)){
                        $attribute = mb_substr($text, $mark, $i - $mark);
                        $state = self::ST_ATTR_EQ;
                    }
                    elseif($char == '='){
                        $attribute = mb_substr($text, $mark, $i - $mark);
                        $state = self::ST_ATTR_VALUE;
                    }
                    elseif($char == '/'){
                        $attribute = mb_substr($text, $mark, $i - $mark);
                        $attributes[$attribute] = true;
                        $state = self::ST_TAG_SINGLE;
                    }
                    elseif($char == '>'){
                        $attribute = mb_substr($text, $mark, $i - $mark);
                        $attributes[$attribute] = NULL;
                        $mark = $i + 1;
                        $state = self::ST_TEXT;
                        $this->_onElementOpen($tagname, $attributes);
                    }
                    break;
                    
                case self::ST_ATTR_EQ:
                    if($this->isWhiteChar($char)){
                        
                    }
                    elseif($char == '='){
                        $state = self::ST_ATTR_VALUE;
                    }
                    elseif($char == '/'){
                        $attributes[$attribute] = NULL;
                        $state = self::ST_TAG_SINGLE;
                    } else {
                        $mark = $i;
                        $attributes[$attribute] = NULL;
                        $state = self::ST_ATTR_KEY;
                    }
                    break;
                    
                case self::ST_ATTR_VALUE:
                    if($this->isWhiteChar($char)){
                        
                    }
                    elseif($char == '"' || $char == '\''){
                        $quote = $char;
                        $state = self::ST_ATTR_QUOTE;
                        $mark = $i + 1;
                    }
                    else {
                        //throw new Etc_Dom_Exception('ERR_EXPECT_VALUE_QUOTE');
                        $quote = ' ';
                        $state = self::ST_ATTR_QUOTE;
                        $mark = $i;
                    }
                    break;
                    
                case self::ST_ATTR_QUOTE:
                    if($char == $quote && $last_char != '\\'){
                        $attributes[$attribute] = mb_substr($text, $mark, $i - $mark);
                        $state = self::ST_TAG_ATTRIBUTES;
                    }
                    elseif($quote == ' ' && $this->isWhiteChar($char)){
                        $attributes[$attribute] = mb_substr($text, $mark, $i - $mark);
                        $state = self::ST_TAG_ATTRIBUTES;
                    }
                    break;
                    
                case self::ST_COMMENT:
                    if($char == '>' && mb_substr($text, $i - 2, 2) == '--'){
                        $this->_onComment(mb_substr($text, $mark, $i - $mark + 1));
                        $mark = $i + 1;
                        $state = self::ST_TEXT;
                    }
                    break;
                    
                case self::ST_PREPROC:
                    if($char == '?' && mb_substr($text, $i, 2) == '?>'){
                        $this->_onTextData(mb_substr($text, $mark, $i - $mark));
                        $mark = $i;
                        $state = self::ST_TEXT;
                    }
                    break;
                    
                case self::ST_CDATA:
                    if($char == '>' && mb_substr($text, $i - 2, 2) == ']]'){
                        $this->_onCdata(mb_substr($text, $mark, $i - $mark + 1));
                        $mark = $i + 1;
                        $state = self::ST_TEXT;
                    }
                    break;
                    
                case self::ST_DOCTYPE:
                    if($char == '>'){
                        $this->_onDocType(mb_substr($text, $mark, $i - $mark + 1));
                        $mark = $i + 1;
                        $state = self::ST_TEXT;
                    }
                    break;
            }
        }
        if($mark != $i){
            $this->_onTextData(mb_substr($text, $mark, $i - $mark));
        }
        $this->_onDocumentEnd();
        return $this->_root;
    }


    /**
     * ノードを追加する
     *
     * @access     protected
     * @param      object  $node   Etc_Dom_Node
     */
    protected function _pushNode(Etc_Dom_Node $node)
    {
        if($this->_current instanceof Etc_Dom_Node){
            $this->_current->appendChild($node);
        } elseif($this->_current instanceof Etc_Dom_NodeList){
            $this->_current->addNode($node);
        }
    }


    /**
     * ホワイトスペース判断
     *
     * @access     protected
     * @param      string  $char
     * @return     boolean
     */
    public function isWhiteChar($char)
    {
        return strpos(" \t\n\r\0", $char) !== false;
    }

    /**
     * 英字判断
     *
     * @access     public
     * @param      string  $char
     * @return     boolean
     */
    public function isAlpha($char)
    {
        return preg_match('/^[a-z]$/i', $char);
    }





    /**
     * イベント：パース開始
     *
     * @access     protected
     */
    protected function _onDocumentStart()
    {
        if(!$this->_root) $this->_root = new Etc_Dom_Document();
        $this->_current = $this->_root;
        $this->_stack = array();
    }

    /**
     * イベント：パース終了
     *
     * @access     protected
     */
    protected function _onDocumentEnd()
    {
        if(count($this->_stack) > 0){
            while(isset($this->_stack[0])){
                $current = $this->_stack[count($this->_stack)-1];
                $this->_onElementClose($current->tagName);
            }
        }
    }

    /**
     * イベント：DOCTYPE抽出
     *
     * @access     protected
     * @param      string  $doctype
     */
    protected function _onDocType($doctype)
    {
        $this->_pushNode(new Etc_Dom_DocumentType($doctype));
    }

    /**
     * イベント：エレメント開始
     *
     * @access     public
     * @param      string  $tagname
     * @param      array   $attributes
     */
    protected function _onElementOpen($tagname, array $attributes=array())
    {
        $node = new Etc_Dom_Element($tagname, $attributes);
        $this->_pushNode($node);
        array_push($this->_stack, $this->_current);
        $this->_current = $node;
    }

    /**
     * イベント：エレメント開始
     *
     * @access     public
     * @param      string  $tagname
     * @param      array   $attributes
     */
    protected function _onElementClose($tagname)
    {
        if(!$this->_current instanceof Etc_Dom_Element){
            throw new Etc_Dom_Exception('tag close missmatch#1. -> ' . $tagname);
        }
        if(strtolower($this->_current->tagName) !== strtolower($tagname)){
            throw new Etc_Dom_Exception('tag close missmatch#2. -> ' . $tagname . '(for ' . $this->_current->tagName . ')');
        }
        $this->_current = array_pop($this->_stack);
    }

    /**
     * イベント：テキスト
     *
     * @access     protected
     * @param      string  $text
     */
    protected function _onTextData($text)
    {
        $text = html_entity_decode($text, ENT_QUOTES, Samurai_Config::get('encoding.internal'));
        $this->_pushNode(new Etc_Dom_Text($text));
    }

    /**
     * イベント：コメント
     *
     * @access     protected
     * @param      string  $text
     */
    protected function _onComment($text)
    {
        $text = mb_substr($text, 4);
        $text = mb_substr($text, 0, -3);
        $this->_pushNode(new Etc_Dom_Comment($text));
    }

    /**
     * イベント：CDATA
     *
     * @access     protected
     * @param      string  $text
     */
    protected function _onCdata($text)
    {
        $text = mb_substr($text, 9);
        $text = mb_substr($text, 0, -3);
        $this->_pushNode(new Etc_Dom_Cdata($text));
    }





    /**
     * ルートをセットする
     *
     * @access     public
     * @param      object  Etc_Dom_Node
     */
    public function setRoot(Etc_Dom_Node $root)
    {
        $this->_root = $root;
    }
}

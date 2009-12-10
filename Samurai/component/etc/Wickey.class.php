<?php
/**
 * WIKIエンジン
 *
 * Wickeyと名付けられたWIKIエンジン。
 * 基本は独自タグベースのWIKI表記になりますが、スタンダードなWIKI表記もサポートしていきます。
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
Samurai_Loader::loadByClass('Etc_Dom_Document');
class Etc_Wickey
{
    /**
     * 見出しリスト
     * コンテンツメニューを生成するために、見出しの一覧を保管しておく
     *
     * @access   public
     * @var      array
     */
    public $headings = array();

    /**
     * コンバーターキャッシュ
     * (コンバーターは一つあれば十分なので)
     *
     * @access   protected
     * @var      array
     */
    protected $_converters = array();

    /**
     * 使用許可されたタグリスト
     *
     * @access   protected
     * @var      array
     */
    protected $_tags = array();

    /**
     * 標準WIKIパーサー
     *
     * @access   private
     * @var      object   Etc_Wickey_Parser
     */
    private $Parser;

    /**
     * インライン表記のパーサー
     *
     * @access   private
     * @var      object   Etc_Wickey_Inliner
     */
    private $Inliner;





    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        $this->addTag('modifier');
        $this->addTag('external');
        $this->addTag('emoji');
        $this->addTag('tip');
        $this->addTag('ignore');
        $this->Parser = new Etc_Wickey_Parser();
        $this->Inliner = new Etc_Wickey_Inliner();
        Samurai::getContainer()->injectDependency($this->Parser);
        Samurai::getContainer()->injectDependency($this->Inliner);
    }



    /**
     * 変換トリガー
     *
     * @access     public
     * @param      string  $text     対象テキスト
     * @param      object  $option   オプション
     * @return     string  変換されたテキスト
     */
    public function render($text, $option=NULL)
    {
        try {
            $dom = new Etc_Dom_Document();
            $option = (object)$option;
            $text = $this->_prepareText($text);
            $dom->load($text);
            $option->root = $dom;
            $this->_nodeTransform($dom, $option);
            $sections = $this->_divideSections($dom);
            $dom = $this->_sections2Dom($sections);
            if(isset($option->width) && $option->width){
                $dom->firstChild->setAttribute('style', 'width:' . $option->width . ';');
            }
            $div = $dom->appendChild($dom->createElement('div'));
            $div->setAttribute('style', 'clear:both;');
            $text = $dom->render();
        }
        catch(Exception $E) {
            throw $E;
        }
        
        if($option && isset($option->truncate)){
            $text = strip_tags($text);
            if($option->truncate < strlen($text)){
                $text = str_replace('&nbsp;', ' ', $text);
                $text = mb_strcut(strip_tags($text), 0, $option->truncate);
                $text .= '...';
            }
        }
        return $text;
    }


    /**
     * nodeを変換する
     * 子ノードを保持している場合、子ノードも再帰的に変換する
     *
     * @access     public
     * @param      object  $node
     * @param      object  $option
     */
    public function _nodeTransform($node, $option)
    {
        if($node->nodeType === XML_DOCUMENT_NODE){
            for($i = 0; $i < $node->childNodes->length; $i++){
                $child = $node->childNodes->item($i);
                $this->_nodeTransform($child, $option);
            }
        } elseif($node->nodeType === XML_ELEMENT_NODE){
            $new_node = $this->_nodeConvert($node, $option);
            if(!$node->isSameNode($new_node)){
                $node->parentNode->replaceChild($new_node, $node);
            }
            //子ノードも再帰的に
            if(strtoupper($new_node->tagName) == 'a') $option->in_a = true;
            if(!isset($new_node->no_child_convert) && $new_node->hasChildNodes()){
                for($i = 0; $i < $new_node->childNodes->length; $i++){
                    $child = $new_node->childNodes->item($i);
                    $this->_nodeTransform($child, $option);
                }
            }
            if(strtoupper($new_node->tagName) == 'a') $option->in_a = false;
        } elseif($node->nodeType === XML_TEXT_NODE){
            $new_value = $this->Inliner->render($node->getValue(), $option);
            if($new_value != $node->nodeValue){
                $dom = new Etc_Dom_Document();
                $dom->load($new_value);
                for($i = 0; $i < $dom->childNodes->length; $i++){
                    $new_node = $dom->childNodes->item($i);
                    $node->parentNode->insertBefore($new_node, $node);
                }
                $node->parentNode->removeChild($node);
            }
        }
    }


    /**
     * nodeを変換する
     *
     * @access     public
     * @param      object  $node
     * @param      object  $option
     * @return     object  変換したnode
     */
    private function _nodeConvert($node, $option)
    {
        try {
            $Converter = $this->_getNodeConverter($node->tagName, $option);
        }
        catch(Exception $E){
            $Converter = $this->_getNodeConverter('ignore', $option);
        }
        return $Converter->convert($node, $option);
    }
    
    
    /**
     * ノードコンバータを取得する
     *
     * @access     public
     * @param      string  $tag
     * @param      object  NodeConverter
     */
    private function _getNodeConverter($tag, $option)
    {
        $tag = strtolower($tag);
        if(!isset($this->_converters[$tag])){
            if(!isset($this->_tags[$tag])) throw new Etc_Wickey_Exception('This tag is not accepted. -> ' . $tag);
            $class = $this->_tags[$tag];
            if(!Samurai_Loader::loadByClass($class)) throw new Etc_Wickey_Exception('Wickey converter is not found. -> ' . $class);
            $this->_converters[$tag] = new $class;
            Samurai::getContainer()->injectDependency($this->_converters[$tag]);
        }
        $converter = $this->_converters[$tag];
        $converter->setOption($option);
        return $converter;
    }
    
    
    /**
     * コンバートされたDOMをセクションに分割する
     *
     * @access     private
     * @param      object  $dom   Etc_Dom_Document
     * @return     array
     */
    private function _divideSections(Etc_Dom_Document $dom)
    {
        $sections = array();
        $section  = new Etc_Dom_Element('div', array('class'=>'section'));
        $section->is_block = false;
        foreach($dom->childNodes as $_key => $child){
            if($child->nodeType == XML_ELEMENT_NODE
                && in_array(strtolower($child->tagName), array('div', 'pre', 'object', 'script', 'iframe', 'blockquote'))){
                
                if($section->childNodes->length > 0) $sections[] = $section;
                $section = new Etc_Dom_Element('div', array('class'=>'section'));
                $section->is_block = true;
                $section->appendChild($child);
                $sections[] = $section;
                $section = new Etc_Dom_Element('div', array('class'=>'section'));
                $section->is_block = false;
            } else {
                $section->appendChild($child);
                if($_key == $dom->childNodes->length - 1){
                    $sections[] = $section;
                }
            }
        }
        return $sections;
    }
    
    
    /**
     * セクションに分割されたもので新たにDOMを形成
     *
     * @access     private
     * @param      array   $sections
     * @return     object  Etc_Dom_Document
     */
    private function _sections2Dom(array $sections)
    {
        $dom = new Etc_Dom_Document();
        $wickey = $dom->appendChild($dom->createElement('div', array('class' => 'wickey')));
        $this->headings = array();
        foreach($sections as $section){
            if($section->is_block){
                $wickey->appendChild($section);
            } else {
                $inner_section = $section->innerHTML();
                $inner_section = $this->Parser->parseAndRender($inner_section);
                $dom2 = new Etc_Dom_Document();
                $dom2->load($inner_section);
                $section->childNodes->clear();
                foreach($dom2->childNodes as $child){
                    $section->appendChild($child);
                    if($child->nodeType == XML_ELEMENT_NODE && in_array($child->tagName, array('h3', 'h4', 'h5'))){
                        $this->headings[] = $child;
                    }
                }
                $wickey->appendChild($section);
            }
        }
        return $dom;
    }


    /**
     * 準備
     *
     * @access     private
     * @param      string  $text
     * @return     string  タグが補完されたテキスト
     */
    private function _prepareText($text)
    {
        //基本エスケープ
        $text = rtrim($text);
        $text = htmlspecialchars($text, ENT_NOQUOTES);
        //許容タグだけ復活
        foreach($this->_tags as $tag => $tmp){
            $text = preg_replace(array('/&lt;('.$tag.')(.*?)&gt;/i', '/&lt;\/('.$tag.')&gt;/i'), array('<\\1\\2>', '</\\1>'), $text);
        }
        //$text = nl2br($text);
        return $text;
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
        $dom = new Etc_Dom_Document();
        $dom->load($text);
        foreach($dom->childNodes as $child){
            if($child->nodeType == XML_TEXT_NODE){
                $child->nodeValue = $this->Parser->supplement($child->nodeValue);
            }
        }
        $text = $dom->render();
        return html_entity_decode($text);
    }
    
    
    
    
    
    /**
     * コンテンツメニューを描画する
     *
     * @access     public
     * @return     string
     */
    public function renderContentsMenu()
    {
        $html = '';
        $depth = 0;
        foreach($this->headings as $_key => $heading){
            $h_depth = (int)substr($heading->tagName, 1) - 2;
            if($depth == 0){
                $html .= '<ul class="wickey_contents_menu">';
            }
            elseif($h_depth > $depth){
                for($i = $depth; $i < $h_depth; $i++) $html .= '<UL>';
            }
            elseif($h_depth < $depth){
                for($i = $depth; $i > $h_depth; $i--) $html .= '</UL>';
            }
            $html .= sprintf('<li><a href="#%s">%s</a></li>', $heading->getAttribute('id'), $heading->innerText());
            $depth = $h_depth;
        }
        for($i = $depth; $i > 0; $i--) $html .= '</ul>';
        return $html;
    }
    
    
    
    
    
    /**
     * 許容タグを追加
     *
     * @access     public
     * @param      string  $tag     タグ名
     * @param      string  $class   コンバーターのクラス名
     */
    public function addTag($tag, $class='')
    {
        $tag = strtolower($tag);
        if($class == ''){
            $class = 'Etc_Wickey_Converter_' . ucfirst($tag);
        }
        $this->_tags[$tag] = $class;
    }
}

<?php
/**
 * MODIFIERノードのコンバーター
 *
 * おもに、見た目の装飾に用いられるWickeyタグです
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Converter_Modifier extends Etc_Wickey_Converter
{
    /**
     * GeShiハイライター
     *
     * @access   private
     * @var      object
     */
    private $geshi;


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 変換トリガー
     *
     * @implements
     * @access     public
     */
    public function convert(Etc_Dom_Node $node)
    {
        $root = $this->option->root;
        $new_node = $root->createElement('span');
        
        //属性毎の対応
        foreach($node->attributes as $attr){
            $method = '_do' . ucfirst(strtolower($attr->name));
            if(method_exists($this, $method)){
                $replacement = $this->$method($new_node, $attr, $node);
                if($replacement){
                    $new_node = $replacement;
                }
                if(isset($new_node->no_conbination)) break;
            }
        }
        
        //子供のアペンド
        if(!$node->hasAttribute('code')){
            foreach($node->childNodes as $child){
                $new_node->appendChild($child->cloneNode(true));
            }
        }
        return $new_node;
    }





    /**
     * 太字表示
     *
     * @access     protected
     */
    protected function _doBold(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $this->_appendAttribute($new_node, 'style', 'font-weight:bolder;');
    }

    /**
     * 斜体表示
     *
     * @access     protected
     */
    protected function _doItalic(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $this->_appendAttribute($new_node, 'style', 'font-style:italic;');
    }

    /**
     * 色つけ
     *
     * @access     protected
     */
    protected function _doColor(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $this->_appendAttribute($new_node, 'style', 'color:' . $attr->value . ';');
    }

    /**
     * 背景色つけ
     *
     * @access     protected
     */
    protected function _doBgcolor(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $this->_appendAttribute($new_node, 'style', 'background-color:' . $attr->value . ';');
    }

    /**
     * サイズ調整
     *
     * @access     protected
     */
    protected function _doSize(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $this->_appendAttribute($new_node, 'style', 'font-size:' . $attr->value . ';');
    }


    /**
     * リンク付与
     *
     * @access     protected
     */
    protected function _doHref(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $a = $this->option->root->createElement('a');
        foreach($new_node->attributes as $attr) $a->setAttributeNode($attr);
        $a->setAttribute('href', $attr->value);
        $a->setAttribute('target', $node->hasAttribute('target') ? $node->getAttribute('target') : '_blank');
        return $a;
    }


    /**
     * 取消線
     *
     * @access     protected
     */
    protected function _doDelete(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        if($new_node->hasAttribute('style') && preg_match('/text-decoration/', $new_node->getAttribute('style'))){
            $style = $new_node->getAttributeNode('style');
            $style->value = preg_replace('/text-decoration:(.*?);/', 'text-decoration:\\1 line-through;', $style->value);
        } else {
            $this->_appendAttribute($new_node, 'style', 'text-decoration:line-through;');
        }
    }
    /**
     * 下線
     *
     * @access     protected
     */
    protected function _doUnderline(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        if($new_node->hasAttribute('style') && preg_match('/text-decoration/', $new_node->getAttribute('style'))){
            $style = $new_node->getAttributeNode('style');
            $style->value = preg_replace('/text-decoration:(.*?);/', 'text-decoration:\\1 underline;', $style->value);
        } else {
            $this->_appendAttribute($new_node, 'style', 'text-decoration:underline;');
        }
    }
    /**
     * 上線
     *
     * @access     protected
     */
    protected function _doOverline(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        if($new_node->hasAttribute('style') && preg_match('/text-decoration/', $new_node->getAttribute('style'))){
            $style = $new_node->getAttributeNode('style');
            $style->value = preg_replace('/text-decoration:(.*?);/', 'text-decoration:\\1 overline;', $style->value);
        } else {
            $this->_appendAttribute($new_node, 'style', 'text-decoration:overline;');
        }
    }

    /**
     * 左寄せ
     *
     * @access     protected
     */
    protected function _doLeft(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $div = $this->option->root->createElement('div');
        foreach($new_node->attributes as $attr) $div->setAttributeNode($attr);
        $this->_appendAttribute($div, 'style', 'text-align:left;');
        return $div;
    }
    /**
     * 右寄せ
     *
     * @access     protected
     */
    protected function _doRight(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $div = $this->option->root->createElement('div');
        foreach($new_node->attributes as $attr) $div->setAttributeNode($attr);
        $this->_appendAttribute($div, 'style', 'text-align:right;');
        return $div;
    }
    /**
     * 中央寄せ
     *
     * @access     protected
     */
    protected function _doCenter(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $div = $this->option->root->createElement('div');
        foreach($new_node->attributes as $attr) $div->setAttributeNode($attr);
        $this->_appendAttribute($div, 'style', 'text-align:center;');
        return $div;
    }


    /**
     * 引用
     *
     * @access     protected
     */
    protected function _doBlockquote(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $new_node = $this->option->root->createElement('blockquote');
        //$this->_trimBR($node);
        //$this->_removeNextBR($node);
        return $new_node;
    }


    /**
     * code属性の解決
     * code属性は他の属性との同居はサポートしない
     *
     * @access     protected
     */
    protected function _doCode(Etc_Dom_Node $new_node, $attr, $node=NULL)
    {
        $root = $this->option->root;
        $new_node = $root->createElement('pre');
        $new_node->no_conbination = true;
        $new_node->no_child_convert = true;
        $this->_appendAttribute($new_node, 'class', 'code');
        $this->_appendAttribute($new_node, 'class', $attr->value);
        //ハイライト処理
        $source = html_entity_decode($node->innerHTML());
        $source = preg_replace('|<br />\n|i', "\n", $source);
        if($code = $attr->value){
            $geshi = $this->_getGeshi();
            $geshi->setSource($source);
            $geshi->setLanguage($code);
            $source = $geshi->parseCode();
            $dom = new Etc_Dom_Document();
            $dom->load($source);
            for($i = 0; $i < $dom->childNodes->length; $i++){
                $source = $dom->childNodes->item($i);
                $new_node->appendChild($source);
            }
        } else {
            $new_node->appendChild($root->createTextNode($source));
        }
        //後方の改行は無視
        //$this->_removeNextBR($node);
        return $new_node;
    }    


    /**
     * GeSHi(ハイライター)を取得する
     *
     * @access     private
     * @return     object
     */
    private function _getGeshi()
    {
        if(!$this->geshi){
            Samurai_Loader::load(Samurai_Config::get('directory.library') . '/geshi/class.geshi.php');
            Samurai_Loader::load(Samurai_Config::get('directory.library') . '/geshi/geshi/classes/class.geshirenderer.php');
            Samurai_Loader::load(Samurai_Config::get('directory.library') . '/geshi/geshi/classes/renderers/class.geshirendererhtml.php');
            Samurai_Loader::loadByClass('Etc_Wickey_Helper_GeshiRenderer');
            $this->geshi = new GeSHi('', '');
        }
        $this->geshi->setRenderer(new Etc_Wickey_Helper_GeshiRenderer());
        return $this->geshi;
    }
}

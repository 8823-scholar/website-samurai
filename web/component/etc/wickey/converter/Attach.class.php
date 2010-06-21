<?php
/**
 * attachタグ(添付ファイル)の解釈を行う
 *
 * <code>
 *      <attach name='example.jpg' />   //インラインで表示
 *      <attach name='example.jpg' linkonly=true />   //リンクのみで表示
 *      <attach name='example.jpg' width='200' />   //幅を指定して表示
 *      <attach name='example.flv' />   //動画も可能
 * </code>
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Converter_Attach extends Etc_Wickey_Converter
{
    public
        $Request;


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * @implements
     * @access     public
     */
    public function convert(Etc_Dom_Node $node)
    {
        if(!$node->hasAttribute('name')) return $node;
        $name = $node->getAttribute('name');
        $info = pathinfo($name);
        if(!isset($info['extension']) || !$info['extension']) return $node;

        switch($info['extension']){
            case 'png':
            case 'gif':
            case 'jpg':
            case 'jpeg':
                $new_node = $node->hasAttribute('linkonly') ? $this->_convert2Link($node) : $this->_convert2Img($node) ;
                break;
            default:
                $new_node = $node;
                break;
        }

        return $new_node;
    }


    /**
     * リンクへの変換を行う
     *
     * @access     private
     * @param      object   $node   Etc_Dom_Node
     * @return     object   Etc_Dom_Node
     */
    private function _convert2Link(Etc_Dom_Node $node)
    {
        $a = $this->option->root->createElement('a');
        $url = BASE_URI . '/documents/wiki/tools/attach/view?name=' . $this->Request->get('name');
        $url .= '&attach=' . bin2hex($node->getAttribute('name')) ;
        $a->setAttribute('href', $url);
        $a->appendChild($this->option->root->createTextNode($node->getAttribute('name')));
        return $a;
    }


    /**
     * imgタグへの変換を行う
     *
     * @access     private
     * @param      object   $node   Etc_Dom_Node
     * @return     object   Etc_Dom_Node
     */
    private function _convert2Img(Etc_Dom_Node $node)
    {
        $a = $this->option->root->createElement('a');
        $img = $this->option->root->createElement('img');
        $img->single = true;
        $url = BASE_URI . '/documents/wiki/tools/attach/view?name=' . $this->Request->get('name');
        $url .= '&attach=' . bin2hex($node->getAttribute('name')) ;
        $a->setAttribute('href', $url);
        $a->setAttribute('target', '_blank');
        $img->setAttribute('src', $url);
        if($node->hasAttribute('width')) $img->setAttribute('width', $node->getAttribute('width'));
        $a->appendChild($img);
        return $a;
    }
}

<?php
/**
 * H3タグの解釈を行う。
 * 主にはH3に付随するツール群の表示(hatena bookmarkなど)。
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Converter_H3 extends Etc_Wickey_Converter
{
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
        return $node;
        $root = $this->option->root;
        $new_node = $root->createElement('div', array('class' => 'h3-menu'));
        
        // hatena bookmark
        $url = BASE_URL . $_SERVER['REQUEST_URI'] . '%23' . $node->getAttribute('id');
        $a = $new_node->appendChild($root->createElement('a'));
        $a->setAttribute('href', 'http://b.hatena.ne.jp/entry/' . $url);
        $img = $a->appendChild($root->createElement('img'));
        $img->setAttribute('src', 'http://d.hatena.ne.jp/images/b_entry.gif');
        $img->setAttribute('alt', 'このエントリーを含むはてなブックマーク');
        $img->setAttribute('title', 'このエントリーを含むはてなブックマーク');

        // hatena bookmark users
        $a = $new_node->appendChild($root->createElement('a'));
        $a->setAttribute('href', 'http://b.hatena.ne.jp/entry/' . $url);
        $img = $a->appendChild($root->createElement('img'));
        $img->setAttribute('src', 'http://b.hatena.ne.jp/entry/image/' . $url);
        $img->setAttribute('alt', 'はてなブックマーク - ' . $node->innerText());
        $img->setAttribute('title', 'はてなブックマーク - ' . $node->innerText());

        if($node->nextSibling){
            $node->parentNode->insertBefore($new_node, $node->nextSibling);
        } else {
            $node->parentNode->appendChild($new_node);
        }
        return $node;
    }
}

<?php
/**
 * Noparseコンバーター
 *
 * 子要素も含めてすべて変換しないコンバーター
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Converter_Noparse extends Etc_Wickey_Converter
{
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
     * @implements
     * @access     public
     */
    public function convert(Etc_Dom_Node $node)
    {
        $node->tagName = 'div';
        $node->setAttribute('class', 'noparse');
        $node->no_child_convert = true;
        return $node;
    }
}

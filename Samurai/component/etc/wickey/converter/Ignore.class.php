<?php
/**
 * 変換処理は行われずに、ダイレクトに変換される
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Converter_Ignore extends Etc_Wickey_Converter
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
    }
}

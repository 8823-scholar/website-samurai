<?php
/**
 * DOCTYPEノード
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Dom_DocumentType extends Etc_Dom_Node
{
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct($value)
    {
        $this->nodeType = XML_DOCUMENT_TYPE_NODE;
        $this->nodeValue = $value;
    }
}

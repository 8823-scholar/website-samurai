<?php
/**
 * Wickeyの例外クラス
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Exception extends Exception
{
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}

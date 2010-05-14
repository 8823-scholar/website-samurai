<?
/**
 * Web_Exception
 * 
 * SamuraiWEB用例外クラス
 * 
 * @package    SamuraiWEB
 * @subpackage Exception
 * @copyright  Samurai Framework Project
 * @author     Satoshinosuke Kiuchi <scholar@hayabusa-lab.jp>
 */
class Web_Exception extends Exception
{
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}

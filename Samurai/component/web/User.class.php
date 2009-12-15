<?
/**
 * Web_User
 * 
 * ユーザーそのものを体現するクラス
 * 
 * @package    SamuraiWEB
 * @subpackage User
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Web_User
{
    /**
     * ユーザーID
     *
     * @access   public
     * @var      int
     */
    public $id = 0;

    /**
     * ログイン状態
     *
     * @access   public
     * @var      boolean
     */
    public $logined = false;


    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }
}

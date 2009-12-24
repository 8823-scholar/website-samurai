<?php
/**
 * ユーザーそのものを体現するクラス
 * 
 * @package    SamuraiWEB
 * @subpackage User
 * @copyright  2007-2009 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
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
     * ユーザー名
     *
     * @access   public
     * @var      string
     */
    public $name;

    /**
     * ロール
     *
     * @access   public
     * @var      string
     */
    public $role = 'normal';

    /**
     * ログイン状態
     *
     * @access   public
     * @var      boolean
     */
    public $logined = false;

    /**
     * ActiveGateway
     *
     * @access   public
     * @var      object   ActiveGateway
     */
    public $AG;


    /**
     * コンストラクタ
     *
     * @access     public
     * @param      int      $id
     */
    public function __construct($id = NULL)
    {
        $this->AG = Samurai::getContainer()->getComponent('AG');
        if($id){
            $this->load($id);
        }
    }




    /**
     * ユーザー情報をロード
     *
     * @access     public
     * @param      int      $id
     */
    public function load($id)
    {
        $user = $this->AG->find($id);
        if($user){
            $this->id = $id;
            $this->name = $user->name;
            $this->role = $user->role;
        }
    }
}

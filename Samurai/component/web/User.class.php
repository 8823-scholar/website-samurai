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
     * 最終ログイン時間
     *
     * @access   public
     * @var      int
     */
    public $logined_at = 0;

    /**
     * ActiveGateway
     *
     * @access   public
     * @var      object   ActiveGateway
     */
    public $AG;

    /**
     * テーブル名
     *
     * @access   private
     * @var      string
     */
    private $_table = 'user';

    /**
     * user実体(ActiveGatewayRecord)
     *
     * @access   private
     * @var      object
     */
    private $_base;


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
        $user = $this->AG->find($this->_table, $id);
        if($user){
            $this->id = $id;
            $this->name = $user->name;
            $this->role = $user->role;
            $this->logined_at = $user->logined_at;
            $this->_base = $user;
        }
    }


    /**
     * ユーザー情報の保存
     *
     * @access     public
     * @param      array    $attributes
     */
    public function save(array $attributes = array())
    {
        if(!$this->_base) return false;

        foreach($attributes as $_key => $_val){
            switch($_key){
                case 'name':
                case 'role':
                case 'logined_at':
                    $this->$_key = $_val;
                    break;
            }
        }
        $this->_base->name = $this->name;
        $this->_base->role = $this->role;
        $this->_base->logined_at = $this->logined_at;
        $this->AG->save($this->_base);
    }
}

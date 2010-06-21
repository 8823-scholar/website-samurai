<?php
/**
 * ユーザー管理クラス
 * 
 * @package    SamuraiWEB
 * @subpackage User
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Web_User_Manager extends Web_Model
{
    /**
     * テーブル名
     *
     * @access   protected
     * @var      string
     */
    protected $_table = 'user';


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * ユーザーの取得
     *
     * @access     public
     * @param      inti     $id
     * @return     object   Web_User
     */
    public function get($id)
    {
        if(!$id) return NULL;
        $user = new Web_User($id);
        return $user->id ? $user : NULL;
    }
}


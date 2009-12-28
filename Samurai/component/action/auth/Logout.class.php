<?php
/**
 * ログアウト
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Auth
 * @copyright  2007-2009 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Auth_Logout extends Web_Action
{
    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        return 'success';
    }
}

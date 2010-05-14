<?php
/**
 * ログイン
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Auth
 * @copyright  2007-2009 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Auth_Login extends Web_Action
{
    public
        $from_link = false;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        $next = $this->Request->get('next', '/');

        return array('success', 'next' => $next);
    }


    /**
     * 入力チェック失敗時のアクション
     *
     * @access     public
     */
    public function executeInvalidInput()
    {
        if($this->Request->getMethod() == 'GET'){
            $this->from_link = true;
        }
        return 'invalidInput';
    }
}

<?php
/**
 * SamuraiWEB用の認証クラス
 *
 * 具体的な認証は別の認証クラスで行う(author_dbなど)
 * こちらは、その認証結果を元に、Userクラスを生成し、DIContainerに格納するのが目的です
 * 
 * @package    SamuraiWEB
 * @subpackage Filter.Auth
 * @copyright  2007-2009 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Filter_Auth_Author_Web extends Filter_Auth_Author_Db
{
    /**
     * authorize
     *
     * @implements
     */
    public function authorize(array $params)
    {
        $session_info = $this->_getInfoFromSession($params['name']);
        $User = $this->_getUserFromSessionInfo($session_info ? $session_info : array());
        
        //ログイン時間の更新
        $this->_login($User);
        
        //DIContainerへの登録
        Samurai::getContainer()->registerComponent('User', $User);
        
        return true;
    }


    /**
     * ユーザーインスタンスの取得
     *
     * @access     private
     * @param      array    $session_info
     */
    private function _getUserFromSessionInfo(array $session_info)
    {
        $user_id = isset($session_info['user_id']) ? $session_info['user_id'] : 0 ;
        $User = new Web_User($user_id);
        return $User;
    }


    /**
     * ログイン時間を記録
     *
     * @access     private
     * @param      object  $User   Web_User
     */
    private function _login(Web_User $User)
    {
        if($User->id){
            $User->logined = true;
            $User->logined_at = time();
            $User->save();
        }
    }
}

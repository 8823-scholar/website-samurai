<?
/**
 * Action_Community_Forum_Topic_Add
 * 
 * コミュニティ / フォーラム / トピック / 追加
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community.Add
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Action_Community_Forum_Topic_Add extends Web_Action_Forum
{
    public
        $default = array();
    public
        $Cookie;


    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setForum();

        //フォームのデフォルト値をセット
        $this->_setDefault();

        return 'success';
    }


    /**
     * 返信フォームのデフォルト値をセットする
     * @access     private
     */
    private function _setDefault()
    {
        //cookieから情報をさぐる
        if(!$this->User->logined){
            $this->default['name'] = $this->Cookie->get('name');
            $this->default['mail'] = $this->Cookie->get('mail');
        }
    }
}

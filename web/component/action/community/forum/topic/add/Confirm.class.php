<?
/**
 * Action_Community_Forum_Topic_Add_Confirm
 * 
 * トピックへの書き込みアクション / 確認
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community.Forum
 * @copyright  Samurai Framework Project
 * @author     Satoshinosuke Kiuchi <scholar@hayabusa-lab.jp>
 */
class Action_Community_Forum_Topic_Add_Confirm extends Web_Action_Forum
{
    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setForum();

        return 'success';
    }
}

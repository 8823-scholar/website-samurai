<?
/**
 * Action_Community_Forum_Topic_Reply
 * 
 * トピックへの書き込みアクション
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community.Forum
 * @copyright  Samurai Framework Project
 * @author     Satoshinosuke Kiuchi <scholar@hayabusa-lab.jp>
 */
class Action_Community_Forum_Topic_Reply extends Web_Action_Forum
{
    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setForum();
        $this->_setTopic();

        

        return 'success';
    }
}

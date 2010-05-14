<?
/**
 * Action_Community_Index
 * 
 * コミュニティ / TOPページ
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Action_Community_Index extends Web_Action
{
    public
        $forums = array();
    public
        $ForumManager;


    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        $this->_setForums();

        return 'success';
    }




    /**
     * フォーラムの一覧をセットする
     * @access     private
     */
    private function _setForums()
    {
        $condition = $this->ForumManager->getCondition();
        $condition->order->sort = 'ASC';
        $forums = $this->ForumManager->gets($condition);
        foreach($forums as $forum){
            if(!$forum->last_posted_id) continue;
            $forum->last_article = $this->ForumManager->getArticle($forum->id, $forum->last_posted_id);
            $forum->last_article->page = 1;
        }
        $this->forums = $forums->toArray();
    }
}

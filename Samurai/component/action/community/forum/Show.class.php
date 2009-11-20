<?
/**
 * Action_Community_Forum_Show
 * 
 * コミュニティ / フォーラム / 詳細
 * 
 * @package    SamuraiWEB
 * @subpackage Action.
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Action_Community_Forum_Show extends Web_Action_Forum
{
    public
        $forum,
        $topics = array();
    public
        $Pager,
        $ForumManager;


    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        $this->forum = $this->ForumManager->get($this->Request->get('forum_id'));
        if(!$this->forum) throw new Web_Exception('No such forum.');

        //トピックの取得
        $condition = $this->ForumManager->getCondition();
        $condition->setLimit(10);
        $condition->setOffset($this->Request->get('page', 1));
        $topics = $this->ForumManager->getArticles($this->forum->id, $condition);
        $this->topics = $topics->toArray();

        return 'success';
    }
}

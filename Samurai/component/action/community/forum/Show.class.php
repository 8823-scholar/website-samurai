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
        $topics = array();
    public
        $Pager;


    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setForum();

        //トピックの取得
        $condition = $this->ForumManager->getCondition();
        $condition->setLimit(10);
        $condition->setOffset($this->Request->get('page', 1));
        $condition->where->parent_id = NULL;
        $topics = $this->ForumManager->getArticles($this->forum->id, $condition);
        $this->Pager->init($topics, $condition);

        //最新の返信記事を取得
        foreach($topics as $topic){
            if(!$topic->last_replied_id) continue;
            $topic->last_article = $this->ForumManager->getArticle($this->forum->id, $topic->last_replied_id);
            $topic->last_article->page = floor($topic->reply_count / 20) + 1;
        }
        $this->topics = $topics->toArray();

        return 'success';
    }
}

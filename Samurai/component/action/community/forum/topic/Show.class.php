<?
/**
 * Action_Community_Forum_Topic_Show
 * 
 * コミュニティ / フォーラム / トピック
 * 
 * @package    SamuraiWEB
 * @subpackage Action.
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Action_Community_Forum_Topic_Show extends Web_Action_Forum
{
    public
        $topic,
        $articles = array();
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
        $this->_setTopic();

        //トピックへの書き込みを取得
        $condition = $this->ForumManager->getCondition();
        $condition->setLimit(15);
        $condition->setOffset($this->Request->get('page', 1));
        $condition->where->root_id = $this->topic->id;
        $condition->order->created_at = 'ASC';
        $articles = $this->ForumManager->getArticles($this->forum->id, $condition);

        //記事一覧の生成
        $this->articles = $articles->toArray();
        array_unshift($this->articles, $this->topic->toArray());

        return 'success';
    }
}

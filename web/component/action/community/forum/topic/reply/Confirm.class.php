<?
/**
 * Action_Community_Forum_Topic_Reply_Confirm
 * 
 * トピックへの書き込みアクション / 確認
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community.Forum
 * @copyright  Samurai Framework Project
 * @author     Satoshinosuke Kiuchi <scholar@hayabusa-lab.jp>
 */
class Action_Community_Forum_Topic_Reply_Confirm extends Web_Action_Forum
{
    public
        $article;


    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setForum();
        $this->_setTopic();

        //返信対象の記事を取得
        if($article_id = $this->Request->get('article_id')){
            $this->article = $this->ForumManager->getArticle($this->forum->id, $article_id);
            if(!$this->article) throw new Web_Exception('No such article.');
        } else {
            $this->article = $this->topic;
        }

        return 'success';
    }
}

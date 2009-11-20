<?
/**
 * Web_Action_Forum
 * 
 * フォーラムメインアクション
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Web_Action_Forum extends Web_Action
{
    public
        $forum,
        $topic;
    public
        $ForumManager;


    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * フォーラムをセットする
     * @access     protected
     */
    protected function _setForum()
    {
        $this->forum = $this->ForumManager->get($this->Request->get('forum_id'));
        //if(!$this->forum) throw new Web_Exception('No such forum.');
    }

    /**
     * トピックをセットする
     * @access     protected
     */
    protected function _setTopic()
    {
        $this->topic = $this->ForumManager->getArticle($this->forum->id, $this->Request->get('topic_id'));
        //if(!$this->topic) throw new Web_Exception('No such topic.');
    }
}

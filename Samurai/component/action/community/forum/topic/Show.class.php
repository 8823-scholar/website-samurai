<?
/**
 * Action_Community_Forum_Topic_Show
 * 
 * コミュニティ / フォーラム / トピック
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community.Reply
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Action_Community_Forum_Topic_Show extends Web_Action_Forum
{
    public
        $topic,
        $articles = array(),
        $default = array();
    public
        $Pager,
        $Cookie;


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
        $condition->setLimit(20);
        $condition->setOffset($this->Request->get('page', 1));
        $condition->where->root_id = $this->topic->id;
        $condition->order->created_at = 'ASC';
        $articles = $this->ForumManager->getArticles($this->forum->id, $condition);
        $this->Pager->init($articles, $condition);

        //記事一覧の生成
        $this->articles = $articles->toArray();
        array_unshift($this->articles, $this->topic->toArray());

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
        //件名はRe:をつけたもの
        $this->default['subject'] = preg_match('/^Re:/i', $this->topic->subject) ? $this->topic->subject : sprintf('Re: %s', $this->topic->subject) ;
        //cookieから情報をさぐる
        if(!$this->User->logined){
            $this->default['name'] = $this->Cookie->get('name');
            $this->default['mail'] = $this->Cookie->get('mail');
        }
    }
}

<?
/**
 * Action_Community_Forum_Topic_Reply
 * 
 * コミュニティ / フォーラム / トピック / 返信
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community.Forum
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Action_Community_Forum_Topic_Reply extends Web_Action_Forum
{
    public
        $topic,
        $article,
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
        $this->_setTopic();

        //返信対象の記事を取得
        if($article_id = $this->Request->get('article_id')){
            $this->article = $this->ForumManager->getArticle($this->forum->id, $article_id);
            if(!$this->article) throw new Web_Exception('No such article.');
        } else {
            $this->article = $this->topic;
        }

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
        $this->default['subject'] = preg_match('/^Re:/i', $this->article->subject) ? $this->article->subject : sprintf('Re: %s', $this->article->subject) ;
        //cookieから情報をさぐる
        if(!$this->User->logined){
            $this->default['name'] = $this->Cookie->get('name');
            $this->default['mail'] = $this->Cookie->get('mail');
        }
    }
}

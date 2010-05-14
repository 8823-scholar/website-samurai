<?
/**
 * Action_Community_Forum_Topic_Reply_Done
 * 
 * トピックへの書き込みアクション / 完了
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community.Forum
 * @copyright  Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Community_Forum_Topic_Reply_Done extends Web_Action_Forum
{
    public
        $article;
    public
        $Mail,
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

        //返信
        $dto = $this->Request->get('dto');
        $dto->name = $this->Request->get('name');
        $dto->mail = $this->Request->get('mail');
        $dto->mail_display = $this->Request->get('mail_display', '0');
        $this->ForumManager->reply($this->article, $dto);

        //解決
        if($this->Request->get('resolved')){
            $this->topic->resolved = '1';
            $this->ForumManager->saveArticle($this->topic);
        }

        //cookieに情報を保存
        if(!$this->User->logined){
            $this->Cookie->set('name', $dto->name, time() + 60*60*24*30, '/');
            $this->Cookie->set('mail', $dto->mail, time() + 60*60*24*30, '/');
        }

        //メール通知
        $this->_inform();

        return 'success';
    }


    /**
     * メール通知してほしい人に通知
     * @access     private
     */
    private function _inform()
    {
        $users = $this->ForumManager->getUsersWannaInform($this->forum->id, $this->topic->id);
        foreach($users as $user){
            $this->Mail->clear();
            $this->Mail->addTo($user->mail);
            $this->Mail->setFrom('inform@samurai-fw.org', 'SamuraiFW フォーラム');
            $this->Mail->setSubject('トピック「' . $this->topic->subject . '」に書き込みがありました。');
            $body = $this->Mail->createBody();
            $body->addLine('こんにちわ、%sさん。', $user->name);
            $body->addLine('Samurai Framework Projectです。');
            $body->addLine('以下のトピックに書き込みがありましたのでお知らせいたします。');
            $body->addLine('--------------------------------------------------');
            $body->addLine('フォーラム：%s', $this->forum->title);
            $body->addLine('トピック：%s', $this->topic->subject);
            if($this->topic->id != $this->article->id){
                $body->addLine('記事：%s', $this->article->subject);
            }
            $body->addLine('');
            $body->addLine('%s/community/forum/%d/topic/%d', BASE_URL, $this->forum->id, $this->topic->id);
            $this->Mail->setBody($body);
            $this->Mail->send();
        }
    }
}

<?
/**
 * Action_Community_Forum_Topic_Add_Done
 * 
 * トピックへの書き込みアクション / 完了
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community.Forum
 * @copyright  Samurai Framework Project
 * @author     Satoshinosuke Kiuchi <scholar@hayabusa-lab.jp>
 */
class Action_Community_Forum_Topic_Add_Done extends Web_Action_Forum
{
    public
        $topic;
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

        //作成
        $dto = $this->Request->get('dto');
        $dto->name = $this->Request->get('name');
        $dto->mail = $this->Request->get('mail');
        $dto->mail_inform = $this->Request->get('mail_inform', '0');
        $dto->mail_display = $this->Request->get('mail_display', '0');
        $this->topic = $this->ForumManager->addArticle($this->forum->id, $dto);

        //cookieに情報を保存
        if(!$this->User->logined){
            $this->Cookie->set('name', $dto->name, time() + 60*60*24*30, '/');
            $this->Cookie->set('mail', $dto->mail, time() + 60*60*24*30, '/');
        }

        return 'success';
    }
}

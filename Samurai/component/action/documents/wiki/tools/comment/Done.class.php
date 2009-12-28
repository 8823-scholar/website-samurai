<?php
/**
 * ドキュメント / WIKI / コメント(完了)
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2009 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Comment_Done extends Web_Action_Wiki
{
    public
        $Cookie;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();

        $dto = new stdClass();
        $dto->name = $this->Request->get('cname');
        $dto->comment = $this->Request->get('comment');

        $this->WikiManager->addComment($this->wiki->id, $dto, $this->User);

        if(!$this->User->logined){
            $this->Cookie->set('name', $dto->name, time() + 60*60*24*30, '/');
        }

        return 'success';
    }
}

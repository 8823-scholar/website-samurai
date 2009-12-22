<?php
/**
 * ドキュメント / WIKI / 添付ファイル / 削除
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Documents.Wiki
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Attach_Delete extends Web_Action_Wiki
{
    public
        $attach;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();

        $this->WikiManager->setAttachDir(BASE_DIR . '/data/attach/wiki');
        $this->attach = $this->WikiManager->getAttach($this->wiki->id, $this->Request->get('attach'));
        if(!$this->attach) throw new Web_Exception('No such attach.');
        $this->WikiManager->deleteAttach($this->wiki->id, $this->Request->get('attach'));

        return 'success';
    }
}

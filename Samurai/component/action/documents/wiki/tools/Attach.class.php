<?php
/**
 * ドキュメント / WIKI / 添付ファイル
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Documents.Wiki
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Attach extends Web_Action_Wiki
{
    public
        $attaches = array();


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();

        //添付ファイル一覧の取得
        $this->WikiManager->setAttachDir(BASE_DIR . '/data/attach/wiki/' . $this->wiki->id);
        $this->attaches = $this->WikiManager->getAttaches();

        return 'success';
    }
}

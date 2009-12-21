<?php
/**
 * ドキュメント / WIKI / 添付ファイル / 表示
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Documents.Wiki
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Attach_View extends Web_Action_Wiki
{
    public
        $Response;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();

        //添付ファイルの取得
        $this->WikiManager->setAttachDir(BASE_DIR . '/data/attach/wiki/' . $this->wiki->id);
        $attach = $this->WikiManager->getAttach($this->Request->get('attach'));
        if(!$attach) throw new Web_Exception('No such attach.');

        //出力へセット
        $this->Response->setBody(file_get_contents($attach['path']));
        $this->Response->setHeader('content-type', $attach['content_type']);
        $this->Response->setHeader('content-length', filesize($attach['path']));
    }
}

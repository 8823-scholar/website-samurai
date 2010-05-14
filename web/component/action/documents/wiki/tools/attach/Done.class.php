<?php
/**
 * ドキュメント / WIKI / 添付ファイル / 完了
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Documents.Wiki
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Attach_Done extends Web_Action_Wiki
{
    public
        $attach;
    public
        $Upload,
        $ActionChain;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();

        $file = $this->Upload->getFile('attach');
        $this->WikiManager->setAttachDir(BASE_DIR . '/data/attach/wiki');
        if($this->WikiManager->isAlreadyAttached($this->wiki->id, $file->name)){
            $ErrorList = $this->ActionChain->getCurrentErrorList();
            $ErrorList->add('attach', '同名のファイルが既にアップロードされています');
            return 'already';
        }
        $attach = $this->WikiManager->addAttachByUploadedFile($this->wiki->id, $file);
        $this->attach = $attach;

        return 'success';
    }
}

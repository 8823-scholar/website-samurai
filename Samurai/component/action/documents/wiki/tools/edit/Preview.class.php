<?php
/**
 * ドキュメント / WIKI / 編集(確認)
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Edit_Preview extends Web_Action_Wiki
{
    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();
        $this->Wickey->addTag('h3');

        return 'success';
    }
}

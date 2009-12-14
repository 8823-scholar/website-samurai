<?php
/**
 * ドキュメント / WIKI
 * 
 * @package    SamuraiWEB
 * @subpackage action.documents.wiki
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Show extends Web_Action_Wiki
{
    public
        $Wickey;


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

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
        $wiki_content = '';
    public
        $Wickey;


    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();

        $this->Wickey->addTag('h3');
        $this->wiki->content = file_get_contents(dirname(__FILE__) . '/test.txt');
        $this->wiki_content = $this->Wickey->render($this->wiki->content);

        return 'success';
    }
}

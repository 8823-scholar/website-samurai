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
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();

        $text = file_get_contents(dirname(__FILE__) . '/test.txt');
        $text = $this->Wickey->render($text);
        echo nl2br(htmlspecialchars($text));
        exit;

        return 'success';
    }
}

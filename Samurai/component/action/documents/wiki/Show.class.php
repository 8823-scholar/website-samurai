<?php
/**
 * ドキュメント / WIKI
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Documents.Wiki
 * @copyright  2007-2009 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Show extends Web_Action_Wiki
{
    public
        $comments = array();
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
        $this->_setWiki(false);
        $this->Wickey->addTag('h3', array('inputable' => false));
        $this->Wickey->addTag('attach');

        if(!$this->wiki->is_newpage){
            $condition = $this->WikiManager->getCondition();
            $comments = $this->WikiManager->getComments($this->wiki->id, $condition);
            $this->comments = $comments->toArray();
        }

        return $this->wiki->is_newpage ? 'newpage' : 'success';
    }
}

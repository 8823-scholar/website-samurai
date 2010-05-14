<?php
/**
 * ドキュメント / WIKI / 編集
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Edit extends Web_Action_Wiki
{
    public
        $checksum = '';


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki(false);

        if(!$this->wiki->is_newpage){
            //同時編集への配慮としてチェックサムを保持
            $this->checksum = md5($this->wiki->title . $this->wiki->content);
        }

        return 'success';
    }
}

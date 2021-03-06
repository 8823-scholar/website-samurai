<?php
/**
 * ドキュメント / WIKI / コメント(確認)
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2009 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Comment_Confirm extends Web_Action_Wiki
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
        
        return 'success';
    }
}

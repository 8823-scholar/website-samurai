<?
/**
 * Action_Index
 * 
 * [[機能説明]]
 * 
 * @package    Package
 * @subpackage Action.
 * @copyright  Foo Project
 * @author     Foo Bar <foo@bar.jp>
 */
class Action_Index extends Samurai_Action
{
    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        return 'success';
    }
}

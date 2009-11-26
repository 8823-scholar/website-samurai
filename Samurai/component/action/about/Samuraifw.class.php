<?
/**
 * Action_About_Samuraifw
 * 
 * [[機能説明]]
 * 
 * @package    SamuraiWEB
 * @subpackage Action.
 * @copyright  Samurai Framework Project
 * @author     Satoshinosuke Kiuchi <scholar@hayabusa-lab.jp>
 */
class Action_About_Samuraifw extends Web_Action
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

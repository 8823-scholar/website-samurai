<?php
/**
 * [[機能説明]]
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 */
class Action_Request_Display extends Samurai_Action
{
    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        return 'success';
    }
}


<?php
/**
 * [[機能説明]]
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 */
class Action_Db_Activegateway_List extends Samurai_Action
{
    public
        $pear_db;
    public
        $footstamps = array();


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        $AG = ActiveGatewayManager::getActiveGateway('base');
        $condition = $AG->getCondition();
        $condition->setLimit(10);
        $condition->order->created_at = 'DESC';
        $footstamps = $AG->findAllDetail('tutorial_footstamp', $condition);
        $this->footstamps = $footstamps->toArray();

        return 'success';
    }
}


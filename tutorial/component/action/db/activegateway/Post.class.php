<?php
/**
 * [[機能説明]]
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 */
class Action_Db_Activegateway_Post extends Samurai_Action
{
    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        $AG = ActiveGatewayManager::getActiveGateway('base');
        $dto = new stdClass();
        $dto->name = $this->Request->get('name');
        $AG->create('tutorial_footstamp', $dto);

        return 'success';
    }
}


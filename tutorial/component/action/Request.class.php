<?php
/**
 * [[機能説明]]
 * 
 * @package    Package
 * @subpackage Action
 * @copyright  Foo Project
 * @author     Foo Bar <foo@bar.jp>
 */
class Action_Request extends Samurai_Action
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


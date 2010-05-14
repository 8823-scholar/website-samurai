<?php
/**
 * AJAXベースアクション
 *
 * すべてのAJAXアクションはこれを継承してください
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Web_Action_Ajax extends Web_Action
{
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        parent::__construct();
    }
}

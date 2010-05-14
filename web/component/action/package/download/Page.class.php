<?php
/**
 * パッケージ / ダウンロード
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Package
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Package_Download_Page extends Web_Action_Package
{
    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setPackage();
        $this->_setRelease();
        $this->_setFile();

        return 'success';
    }
}

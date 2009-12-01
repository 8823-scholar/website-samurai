<?
/**
 * Action_Package_Download_Page
 * 
 * パッケージ / ダウンロード
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Package
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Package_Download_Page extends Web_Action_Package
{
    /**
     * 実行トリガー。
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

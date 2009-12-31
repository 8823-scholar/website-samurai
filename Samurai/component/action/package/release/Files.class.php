<?php
/**
 * パッケージ / リリース / ファイル一覧
 *
 * 指定パッケージの指定リリースのファイル一覧を表示します
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Package
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Package_Release_Files extends Web_Action_Package
{
    public
        $release,
        $files = array();


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

        $files = $this->PackageManager->getReleaseFiles($this->package->id, $this->release->id);
        $this->files = $files->toArray();

        return 'success';
    }
}

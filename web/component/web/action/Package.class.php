<?php
/**
 * パッケージメインアクション
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Web_Action_Package extends Web_Action
{
    public
        $package,
        $release,
        $file;
    public
        $PackageManager;


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * パッケージをセットする
     *
     * @access     protected
     */
    protected function _setPackage()
    {
        $this->package = $this->PackageManager->getByAlias($this->Request->get('package_alias'));
        if(!$this->package) throw new Web_Exception('No such package.');
    }

    /**
     * リリースをセットする
     *
     * @access     protected
     */
    protected function _setRelease()
    {
        if($release_name = $this->Request->get('release_name')){
            list($version, $stability) = explode('-', $release_name);
            $condition = $this->PackageManager->getCondition();
            $condition->where->version = $version;
            $condition->where->stability = $stability;
            $this->release = $this->PackageManager->getRelease($this->package->id, $condition);
        } else {
            $this->release = $this->PackageManager->getRelease($this->package->id, $this->Request->get('release_id'));
        }
        if(!$this->release) throw new Web_Exception('No such release.');
    }

    /**
     * リリースファイルをセットする
     *
     * @access     protected
     */
    protected function _setFile()
    {
        if($filename = $this->Request->get('file_name')){
            $condition = $this->PackageManager->getCondition();
            $condition->where->filename = $filename;
            $this->file = $this->PackageManager->getReleaseFile($this->package->id, $this->release->id, $condition);
        } else {
            $this->file = $this->PackageManager->getReleaseFile($this->package->id, $this->release->id, $this->Request->get('file_id'));
        }
        if(!$this->file) throw new Web_Exception('No such file.');
    }
}

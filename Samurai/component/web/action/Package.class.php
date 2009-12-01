<?
/**
 * Web_Action_Package
 * 
 * パッケージメインアクション
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
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
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * パッケージをセットする
     * @access     protected
     */
    protected function _setPackage()
    {
        $this->package = $this->PackageManager->getByAlias($this->Request->get('package_alias'));
        if(!$this->package) throw new Web_Exception('No such package.');
    }

    /**
     * リリースをセットする
     * @access     protected
     */
    protected function _setRelease()
    {
        $this->release = $this->PackageManager->getRelease($this->package->id, $this->Request->get('release_id'));
        if(!$this->release) throw new Web_Exception('No such release.');
    }

    /**
     * リリースファイルをセットする
     * @access     protected
     */
    protected function _setFile()
    {
        $this->file = $this->PackageManager->getReleaseFile($this->package->id, $this->release->id, $this->Request->get('file_id'));
        if(!$this->file) throw new Web_Exception('No such file.');
    }
}

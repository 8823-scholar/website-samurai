<?php
/**
 * パッケージ / ダウンロード
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Package
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Package_Download_Do extends Web_Action_Package
{
    public
        $Session,
        $Response;


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

        $info = pathinfo($this->file->filename);
        $filepath = BASE_DIR . '/www/archives/' . $this->package->alias . '/' . $this->file->filename;
        if(!file_exists($filepath)) return 'error_404';

        switch($info['extension']){
            case 'zip':
                $this->Response->setHeader('content-type', 'application/zip');
                break;
            case 'tgz':
                $this->Response->setHeader('content-type', 'application/x-compressed');
                break;
        }
        $this->Response->setHeader('content-length', filesize($filepath));
        $this->Response->setBody(file_get_contents($filepath));

        //カウントアップ
        if(!$this->Session->get('package.downloaded.' . $this->file->id)){
            $this->PackageManager->downloaded($this->file);
            $this->Session->set('package.downloaded.' . $this->file->id, true);
        }
    }
}

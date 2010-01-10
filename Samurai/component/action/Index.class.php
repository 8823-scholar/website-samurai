<?php
/**
 * インデックス
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Index extends Web_Action
{
    public
        $release,
        $release_dev,
        $articles = array();
    public
        $ForumManager,
        $PackageManager;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        //最新のフォーラム投稿を取得
        $condition = $this->ForumManager->getCondition();
        $condition->setLimit(10);
        $condition->total_rows = false;
        $condition->order->created_at = 'DESC';
        $articles = $this->ForumManager->getArticles(NULL, $condition);
        $this->articles = $articles->toArray();

        //Samuraiのリリースを取得
        $package = $this->PackageManager->getByAlias('samurai');
        if($package){
            $this->_setRelease($package);
            $this->_setDevRelease($package);
        }

        return 'success';
    }


    /**
     * 最新のstableリリースを取得
     *
     * @access     private
     */
    private function _setRelease($package)
    {
        $condition = $this->PackageManager->getCondition();
        $condition->where->stability = 'stable';
        $condition->order->version = 'DESC';
        $this->release = $this->PackageManager->getRelease($package->id, $condition);
    }

    /**
     * 最新の開発版リリースを取得
     *
     * @access     private
     */
    private function _setDevRelease($package)
    {
        $condition = $this->PackageManager->getCondition();
        $condition->where->stability = array('alpha', 'beta');
        $condition->order->version = 'DESC';
        $this->release_dev = $this->PackageManager->getRelease($package->id, $condition);
    }
}

<?php
/**
 * パッケージ / リリース一覧
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Package
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Package_Releases extends Web_Action_Package
{
    public
        $packages = array();


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        //パッケージ一覧の取得
        $packages = $this->PackageManager->gets();
        foreach($packages as $package){
            //stableの最新版
            $condition = $this->PackageManager->getCondition();
            $condition->where->stability = 'stable';
            $condition->order->version = 'DESC';
            $condition->order->datetime = 'DESC';
            $package->stable = $this->PackageManager->getRelease($package->id, $condition);
            if($package->stable){
                $package->stable->files = $this->PackageManager->getReleaseFiles($package->id, $package->stable->id);
            }
            //unstableな最新版
            $condition = $this->PackageManager->getCondition();
            $condition->where->stability = $condition->isNotEqual('stable');
            $condition->order->version = 'DESC';
            $condition->order->datetime = 'DESC';
            if($package->stable) $condition->where->version = $condition->isGreaterThan($package->stable->version, false);
            $package->unstable = $this->PackageManager->getRelease($package->id, $condition);
            if($package->unstable){
                $package->unstable->files = $this->PackageManager->getReleaseFiles($package->id, $package->unstable->id);
            }
        }
        $this->packages = $packages->toArray();

        return 'success';
    }
}

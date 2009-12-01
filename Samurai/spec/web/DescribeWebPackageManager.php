<?
/**
 * DescribeWebPackageManager
 *
 * @package    SamuraiWEB
 * @subpackage Spec
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class DescribeWebPackageManager extends PHPSpec_Context
{
    private
        $PackageManager;


    // list methods
    public function itListMethods()
    {
        /**
         * $PackageManager->get($id | $condition);
         * $PackageManager->gets($condition);
         * $PackageManager->getRelease($package_id, $id | $condition);
         * $PackageManager->getReleases($package_id | NULL, $condition);
         * $PackageManager->getReleaseFile($package_id, $release_id, $id | $condition);
         * $PackageManager->getReleaseFiles($package_id, $release_id, $condition);
         * $PackageManager->getMaintener($package_id, $maintener_id | $condition);
         * $PackageManager->getMainteners($package_id | NULL, $condition);
         * $PackageManager->add($dto);
         * $PackageManager->addRelease($package_id, $dto, $maintener);
         * $PackageManager->addReleaseFile($package_id, $release_id, $dto, $maintener);
         * $PackageManager->addMaintener($package_id, $dto);
         * $PackageManager->save($package);
         * $PackageManager->saveRelease($release);
         * $PackageManager->saveReleaseFile($file);
         * $PackageManager->saveMaintener($maintener);
         * $PackageManager->edit($id, $attributes);
         * $PackageManager->editRelease($package_id, $release_id, $attributes);
         * $PackageManager->editReleaseFile($package_id, $release_id, $file_id, $attributes);
         * $PackageManager->editMaintener($package_id, $maintener_id, $attributes);
         * $PackageManager->destroy($package);
         * $PackageManager->destroyRelease($release);
         * $PackageManager->destroyReleaseFile($file);
         * $PackageManager->destroyMaintener($maintener);
         * $PackageManager->delete($id);
         * $PackageManager->deleteRelease($package_id, $release_id);
         * $PackageManager->deleteReleaseFile($package_id, $release_id, $file_id);
         * $PackageManager->deleteMaintener($package_id, $maintener_id);
         * $PackageManager->downloaded($file);
         */
    }


    //取得系
    public function it取得()
    {
        $package = $this->PackageManager->get(1);
        $this->spec($package)->shouldNot->beNull();
        $this->spec($package->id)->should->be(1);
        //引数には$conditionも可能
        $condition = $this->PackageManager->getCondition();
        $condition->where->id = 3;
        $package = $this->PackageManager->get($condition);
        $this->spec($package)->should->beNull();
    }
    public function it取得：複数()
    {
        $condition = $this->PackageManager->getCondition();
        $condition->setLimit(1);
        $packages = $this->PackageManager->gets($condition);
        $this->spec($packages->getSize())->should->be(1);
    }

    public function itリリースの取得()
    {
        $release = $this->PackageManager->getRelease(1, 1);
        $this->spec($release)->shouldNot->beNull();
        $this->spec($release->id)->should->be(1);
        $this->spec($release->package_id)->should->be(1);
        //第二引数はconditionも可能
        $condition = $this->PackageManager->getCondition();
        $condition->where->version = '3.0.0';
        $release = $this->PackageManager->getRelease(1, $condition);
        $this->spec($release)->should->beNull();
    }
    public function itリリースの取得：複数()
    {
        $condition = $this->PackageManager->getCondition();
        $condition->setLimit(1);
        $releases = $this->PackageManager->getReleases(1, $condition);
        $this->spec($releases->getSize())->should->be(1);
    }
    public function itリリースファイルの取得()
    {
        $file = $this->PackageManager->getReleaseFile(1, 1, 2);
        $this->spec($file)->shouldNot->beNull();
        $this->spec($file->id)->should->be(2);
        $this->spec($file->package_id)->should->be(1);
        $this->spec($file->release_id)->should->be(1);
    }
    public function itリリースファイルの取得：複数()
    {
        $condition = $this->PackageManager->getCondition();
        $condition->setLimit(1);
        $files = $this->PackageManager->getReleaseFiles(1, 1, $condition);
        $this->spec($files->getSize())->should->be(1);
    }

    public function itメンテナーの取得()
    {
        $maintener = $this->PackageManager->getMaintener(1, 2);
        $this->spec($maintener)->shouldNot->beNull();
        $this->spec($maintener->id)->should->be(2);
        $this->spec($maintener->package_id)->should->be(1);
        //第二引数はconditionも可能
        $condition = $this->PackageManager->getCondition();
        $condition->where->id = 3;
        $maintener = $this->PackageManager->getMaintener(1, $condition);
        $this->spec($maintener->id)->should->be(3);
    }
    public function itメンテナーの取得：複数()
    {
        $condition = $this->PackageManager->getCondition();
        $condition->setLimit(2);
        $mainteners = $this->PackageManager->getMainteners(1, $condition);
        $this->spec($mainteners->getSize())->should->be(2);
    }

    //操作系
    public function it追加()
    {
        $dto = new stdClass();
        $dto->name = 'Bushi Framework';
        $dto->description = '腹を切らせていただく！';
        $package = $this->PackageManager->add($dto);
        $this->spec($package->name)->should->be('Bushi Framework');
        $this->spec($package->description)->should->be('腹を切らせていただく！');
        $this->PackageManager->add($dto);
    }
    public function it保存()
    {
        $package = $this->PackageManager->get(2);
        $package->name = 'Nobushi Framework';
        $package->description = '落ちますた。';
        $this->PackageManager->save($package);
        $package = $this->PackageManager->get(2);
        $this->spec($package->name)->should->be('Nobushi Framework');
        $this->spec($package->description)->should->be('落ちますた。');
    }
    public function it編集()
    {
        $this->PackageManager->edit(2, array('name' => 'Ochimusya'));
        $package = $this->PackageManager->get(2);
        $this->spec($package->name)->should->be('Ochimusya');
    }
    public function it破壊()
    {
        $package = $this->PackageManager->get(2);
        $this->spec($package)->shouldNot->beNull();
        $this->PackageManager->destroy($package);
        $package = $this->PackageManager->get(2);
        $this->spec($package)->should->beNull();
    }
    public function it削除()
    {
        $package = $this->PackageManager->get(3);
        $this->spec($package)->shouldNot->beNull();
        $this->PackageManager->delete($package->id);
        $package = $this->PackageManager->get(3);
        $this->spec($package)->should->beNull();
    }

    public function itリリースの追加()
    {
        $dto = new stdClass();
        $dto->version = '2.0.1';
        $dto->stability = 'stable';
        $dto->datetime = '2009-12-11 12:34:56';
        $release = $this->PackageManager->addRelease(1, $dto);
        $this->spec($release->package_id)->should->be(1);
        $this->spec($release->version)->should->be('2.0.1');
        $this->spec($release->stability)->should->be('stable');
        $this->spec($release->datetime)->should->be('2009-12-11 12:34:56');
        $release = $this->PackageManager->addRelease(1, $dto);
    }
    public function itリリースの保存()
    {
        $release = $this->PackageManager->getRelease(1, 2);
        $release->stability = 'alpha';
        $this->PackageManager->saveRelease($release);
        $release = $this->PackageManager->getRelease(1, 2);
        $this->spec($release->stability)->should->be('alpha');

    }
    public function itリリースの編集()
    {
        $this->PackageManager->editRelease(1, 2, array('version' => '2.0.2', 'stability' => 'beta'));
        $release = $this->PackageManager->getRelease(1, 2);
        $this->spec($release->version)->should->be('2.0.2');
        $this->spec($release->stability)->should->be('beta');
    }
    public function itリリースの破壊()
    {
        $release = $this->PackageManager->getRelease(1, 2);
        $this->spec($release)->shouldNot->beNull();
        $this->PackageManager->destroyRelease($release);
        $release = $this->PackageManager->getRelease(1, 2);
        $this->spec($release)->should->beNull();
    }
    public function itリリースの削除()
    {
        $release = $this->PackageManager->getRelease(1, 3);
        $this->spec($release)->shouldNot->beNull();
        $this->PackageManager->deleteRelease($release->package_id, $release->id);
        $release = $this->PackageManager->getRelease(1, 3);
        $this->spec($release)->should->beNull();
    }

    public function itリリースファイルの追加()
    {
        $dto = new stdClass();
        $dto->filename = 'Samurai-2.0.2-stable.tgz';
        $dto->size = 123456;
        $file = $this->PackageManager->addReleaseiFile(1, 1, $dto);
        $this->spec($file->package_id)->should->be(1);
        $this->spec($file->release_id)->should->be(1);
        $this->spec($file->filename)->should->be('Samurai-2.0.2-stable.tgz');
        $this->spec($file->size)->should->be(123456);
        $file = $this->PackageManager->addReleaseiFile(1, 1, $dto);
    }
    public function itリリースファイルの保存()
    {
        $file = $this->PackageManager->getReleaseFile(1, 1, 1);
        $file->size = 200000;
        $this->PackageManager->saveReleaseFile($file);
        $file = $this->PackageManager->getReleaseFile(1, 1, 1);
        $this->spec($file->size)->should->be(200000);
    }
    public function itリリースファイルの編集()
    {
        $this->PackageManager->editReleaseFile(1, 1, 1, array('size' => 987654));
        $file = $this->PackageManager->getReleaseFile(1, 1, 1);
        $this->spec($file->size)->should->be(987654);
    }
    public function itリリースファイルの破壊()
    {
        $file = $this->PackageManager->getReleaseFile(1, 1, 1);
        $this->spec($file)->shouldNot->beNull();
        $this->PackageManager->destroyReleaseFile($file);
        $file = $this->PackageManager->getReleaseFile(1, 1, 1);
        $this->spec($file)->should->beNull();
    }
    public function itリリースファイルの削除()
    {
        $file = $this->PackageManager->getReleaseFile(1, 1, 2);
        $this->spec($file)->shouldNot->beNull();
        $this->PackageManager->deleteReleaseFile($file->package_id, $file->release_id, $file->id);
        $file = $this->PackageManager->getReleaseFile(1, 1, 2);
        $this->spec($file)->should->beNull();
    }

    public function itメンテナーの追加()
    {
        $dto = new stdClass();
        $dto->name = 'falcon';
        $dto->mail = 'falcon@samurai-fw.org';
        $dto->role = 'developer';
        $maintener = $this->PackageManager->addMaintener(1, $dto);
        $this->spec($maintener->package_id)->should->be(1);
        $this->spec($maintener->name)->should->be('falcon');
        $this->spec($maintener->mail)->should->be('falcon@samurai-fw.org');
        $this->spec($maintener->role)->should->be('developer');
        $maintener = $this->PackageManager->addMaintener(1, $dto);
    }
    public function itメンテナーの保存()
    {
        $maintener = $this->PackageManager->getMaintener(1, 3);
        $maintener->name = 'kiuchi';
        $this->PackageManager->saveMaintener($maintener);
        $maintener = $this->PackageManager->getMaintener(1, 3);
        $this->spec($maintener->name)->should->be('kiuchi');

    }
    public function itメンテナーの編集()
    {
        $this->PackageManager->editMaintener(1, 3, array('name' => 'satoshi', 'mail' => 'satoshi@kiuchi.jp'));
        $maintener = $this->PackageManager->getMaintener(1, 3);
        $this->spec($maintener->name)->should->be('satoshi');
        $this->spec($maintener->mail)->should->be('satoshi@kiuchi.jp');
    }
    public function itメンテナーの破壊()
    {
        $maintener = $this->PackageManager->getMaintener(1, 3);
        $this->spec($maintener)->shouldNot->beNull();
        $this->PackageManager->destroyMaintener($maintener);
        $maintener = $this->PackageManager->getMaintener(1, 3);
        $this->spec($maintener)->should->beNull();
    }
    public function itメンテナーの削除()
    {
        $maintener = $this->PackageManager->getMaintener(1, 4);
        $this->spec($maintener)->shouldNot->beNull();
        $this->PackageManager->deleteMaintener($maintener->package_id, $maintener->id);
        $maintener = $this->PackageManager->getMaintener(1, 4);
        $this->spec($maintener)->should->beNull();
    }

    //その他
    public function itダウンロードされた()
    {
        $file = $this->PackageManager->getReleaseFile(1, 1, 3);
        $this->PackageManager->downloaded($file);
        $file = $this->PackageManager->getReleaseFile(1, 1, 3);
        $this->spec($file->downloaded_count)->should->be(1);
    }




    //準備
    public function beforeAll()
    {
        //コンポーネント準備
        $this->PackageManager = new Web_Package_Manager();
        $this->PackageManager->AG = ActiveGatewayManager::getActiveGateway('sandbox');
        //DB作成
        $this->PackageManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `package` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '名前',
                `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT '説明文',
                `natural_locale` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ja' COMMENT 'メインの言語',
                `required_os` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'independent' COMMENT '依存OS',
                `downloaded_count` int(11) NOT NULL DEFAULT '0' COMMENT 'ダウンロード数',
                `created_at` int(11) NOT NULL DEFAULT '0',
                `updated_at` int(11) NOT NULL DEFAULT '0',
                `deleted_at` int(11) NOT NULL DEFAULT '0',
                `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='パッケージ';            
        ");
        $this->PackageManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `package_mainteners` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `package_id` int(11) NOT NULL DEFAULT '0' COMMENT '=package.id',
                `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '名前',
                `mail` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'メール',
                `role` enum('lead','developer','contributor','helper','other') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'other' COMMENT '役割',
                `created_at` int(11) NOT NULL DEFAULT '0',
                `updated_at` int(11) NOT NULL DEFAULT '0',
                `deleted_at` int(11) NOT NULL DEFAULT '0',
                `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='パッケージ：メンテナー';
        ");
        $this->PackageManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `package_releases` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `package_id` int(11) NOT NULL DEFAULT '0' COMMENT '=package.id',
                `version` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0' COMMENT 'バージョン',
                `stability` enum('stable','beta','alpha') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'alpha' COMMENT '状態',
                `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'リリース日',
                `downloaded_count` int(11) NOT NULL DEFAULT '0' COMMENT 'ダウンロード数',
                `created_at` int(11) NOT NULL DEFAULT '0',
                `updated_at` int(11) NOT NULL DEFAULT '0',
                `deleted_at` int(11) NOT NULL DEFAULT '0',
                `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='パッケージのリリース';
        ");
        $this->PackageManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `package_releases_files` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `package_id` int(11) NOT NULL DEFAULT '0' COMMENT '=package.id',
                `release_id` int(11) NOT NULL DEFAULT '0' COMMENT '=package_releases.id',
                `filename` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ファイル名',
                `size` int(11) NOT NULL DEFAULT '0' COMMENT 'ファイルサイズ',
                `downloaded_count` int(11) NOT NULL DEFAULT '0' COMMENT 'ダウンロード数',
                `sort` int(2) NOT NULL DEFAULT '99' COMMENT '並び順',
                `created_at` int(11) NOT NULL DEFAULT '0',
                `updated_at` int(11) NOT NULL DEFAULT '0',
                `deleted_at` int(11) NOT NULL DEFAULT '0',
                `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='パッケージ：リリース：ファイル';
        ");
        //データ挿入
        $datas = array(
            array('name' => 'Samurai Framework', 'description' => 'SamuraiFWはうんたら。'),
        );
        foreach($datas as $data){
            $this->PackageManager->AG->create('package', $data);
        }

        $datas = array(
            array('package_id' => 1, 'name' => 'メンテナー１', 'mail' => 'maintener1@samurai-fw.org', 'role' => 'lead'),
            array('package_id' => 1, 'name' => 'メンテナー２', 'mail' => 'maintener2@samurai-fw.org', 'role' => 'developer'),
            array('package_id' => 1, 'name' => 'メンテナー３', 'mail' => 'maintener3@samurai-fw.org', 'role' => 'contributor'),
        );
        foreach($datas as $data){
            $this->PackageManager->AG->create('package_mainteners', $data);
        }

        $datas = array(
            array('package_id' => 1, 'version' => '2.0.0', 'stability' => 'alpha', 'datetime' => '2009-11-30 12:00:00'),
        );
        foreach($datas as $data){
            $this->PackageManager->AG->create('package_releases', $data);
        }

        $datas = array(
            array('package_id' => 1, 'release_id' => 1, 'filename' => 'Samurai-2.0.0-stable.tgz', 'size' => 1234),
            array('package_id' => 1, 'release_id' => 1, 'filename' => 'Samurai-2.0.0-stable.zip', 'size' => 5678),
        );
        foreach($datas as $data){
            $this->PackageManager->AG->create('package_releases_files', $data);
        }

    }
}

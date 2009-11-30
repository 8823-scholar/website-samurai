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
         * $PackageManager->downloaded($package_id, $release_id, $file_id);
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
    /*

    //操作系
    public function it追加()
    {
        $dto = new stdClass();
        $dto->title = '追加しますたよ';
        $dto->description = 'うっほうっほうほほほほほ。';
        $package = $this->PackageManager->add($dto);
        $this->spec($package->title)->should->be('追加しますたよ');
        $this->spec($package->description)->should->be('うっほうっほうほほほほほ。');
    }
    public function it保存()
    {
        $package = $this->PackageManager->get(2);
        $package->title = 'このフォーラムはすでに編集されている。';
        $package->description = 'ID:2のフォーラムを編集しましたが、なにか？';
        $this->PackageManager->save($package);
        $package = $this->PackageManager->get(2);
        $this->spec($package->title)->should->be('このフォーラムはすでに編集されている。');
        $this->spec($package->description)->should->be('ID:2のフォーラムを編集しましたが、なにか？');
    }
    public function it編集()
    {
        $this->PackageManager->edit(2, array('title' => 'editしますた'));
        $package = $this->PackageManager->get(2);
        $this->spec($package->title)->should->be('editしますた');
    }
    public function it破壊()
    {
        $package = $this->PackageManager->get(4);
        $this->spec($package)->shouldNot->beNull();
        $this->PackageManager->destroy($package);
        $package = $this->PackageManager->get(4);
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

    public function it記事の追加()
    {
        $dto = new stdClass();
        $dto->name = 'hayabusa';
        $dto->mail = 'hayabusa@samurai-fw.org';
        $dto->subject = '記事の追加です';
        $dto->body = '記事の追加なんてほんとにできるの？';
        $article = $this->PackageManager->addArticle(4, $dto);
        $this->spec($article->package_id)->should->be(4);
        $this->spec($article->name)->should->be('hayabusa');
        $this->spec($article->mail)->should->be('hayabusa@samurai-fw.org');
        $this->spec($article->subject)->should->be('記事の追加です');
        $this->spec($article->body)->should->be('記事の追加なんてほんとにできるの？');
    }
    public function it記事の保存()
    {
        $article = $this->PackageManager->getArticle(1, 2);
        $article->subject = '編集しますた';
        $article->body = 'package:1, id:2 の記事を編集しましたが、なにか？';
        $this->PackageManager->saveArticle($article);
        $article = $this->PackageManager->getArticle(1, 2);
        $this->spec($article->subject)->should->be('編集しますた');
        $this->spec($article->body)->should->be('package:1, id:2 の記事を編集しましたが、なにか？');

    }
    public function it記事の編集()
    {
        $this->PackageManager->editArticle(1, 3, array('subject'=>'1:3,edited', 'body'=>'1:3,edited'));
        $article = $this->PackageManager->getArticle(1, 3);
        $this->spec($article->subject)->should->be('1:3,edited');
        $this->spec($article->body)->should->be('1:3,edited');
    }
    public function it記事の破壊()
    {
        $article = $this->PackageManager->getArticle(4, 8);
        $this->spec($article)->shouldNot->beNull();
        $this->PackageManager->destroyArticle($article);
        $article = $this->PackageManager->getArticle(4, 8);
        $this->spec($article)->should->beNull();
    }
    public function it記事の削除()
    {
        $article = $this->PackageManager->getArticle(1, 3);
        $this->spec($article)->shouldNot->beNull();
        $this->PackageManager->deleteArticle($article->package_id, $article->id);
        $article = $this->PackageManager->getArticle(1, 3);
        $this->spec($article)->should->beNull();
    }
    */





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
                `downloaded_counted` int(11) NOT NULL DEFAULT '0' COMMENT 'ダウンロード数',
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
                `downloaded_counted` int(11) NOT NULL DEFAULT '0' COMMENT 'ダウンロード数',
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
                `downloaded_counted` int(11) NOT NULL DEFAULT '0' COMMENT 'ダウンロード数',
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

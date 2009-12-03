<?php
/**
 * DescribeWebWikiManager
 *
 * @package    SamuraiWEB
 * @subpackage spec
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class DescribeWebWikiManager extends PHPSpec_Context
{
    private
        $WikiManager;


    // list methods
    public function itListMethods()
    {
        /**
         * $WikiManager->setLocale($locale);
         * $WikiManager->setDefaultLocale($locale);
         * $WikiManager->get($id | $condition);
         * $WikiManager->gets($condition);
         * $WikiManager->getHistory($wiki_id, $id | $condition);
         * $WikiManager->getHistories($wiki_id, $condition);
         * $WikiManager->getComment($wiki_id, $id | $condition);
         * $WikiManager->getComments($wiki_id, $condition);
         * $WikiManager->add($dto);
         * $WikiManager->addHistory($wiki_id, $dto);
         * $WikiManager->addComment($wiki_id, $dto, $User);
         * $WikiManager->save($wiki);
         * $WikiManager->saveHistory($history);
         * $WikiManager->saveComment($comment);
         * $WikiManager->edit($id, $attributes);
         * $WikiManager->editHistory($wiki_id, $id, $attributes);
         * $WikiManager->editComment($wiki_id, $id, $attributes);
         * $WikiManager->destroy($wiki);
         * $WikiManager->destroyHistory($history);
         * $WikiManager->destroyComment($comment);
         * $WikiManager->delete($id);
         * $WikiManager->deleteHistory($wiki_id, $id);
         * $WikiManager->deleteComment($wiki_id, $id);
         */
    }


    //設定
    public function it言語設定()
    {
        $this->spec($this->WikiManager->locale)->should->be('ja');
        $this->WikiManager->setLocale('en');
        $this->spec($this->WikiManager->locale)->should->be('en');
    }
    public function itデフォルトの言語を設定する()
    {
        $this->spec($this->WikiManager->default_locale)->should->be('ja');
        $this->WikiManager->setDefaultLocale('en');
        $this->spec($this->WikiManager->default_locale)->should->be('en');
    }


    //取得系
    public function it取得()
    {
        $wiki = $this->WikiManager->get(1);
        $this->spec($wiki)->shouldNot->beNull();
        $this->spec($wiki->id)->should->be(1);
        //引数には$conditionも可能
        $condition = $this->WikiManager->getCondition();
        $condition->where->id = 3;
        $wiki = $this->WikiManager->get($condition);
        $this->spec($wiki)->should->beNull();
    }
    public function it取得：複数()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->setLimit(1);
        $wikis = $this->WikiManager->gets($condition);
        $this->spec($wikis->getSize())->should->be(1);
    }

    public function itリリースの取得()
    {
        $release = $this->WikiManager->getRelease(1, 1);
        $this->spec($release)->shouldNot->beNull();
        $this->spec($release->id)->should->be(1);
        $this->spec($release->wiki_id)->should->be(1);
        //第二引数はconditionも可能
        $condition = $this->WikiManager->getCondition();
        $condition->where->version = '3.0.0';
        $release = $this->WikiManager->getRelease(1, $condition);
        $this->spec($release)->should->beNull();
    }
    public function itリリースの取得：複数()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->setLimit(1);
        $releases = $this->WikiManager->getReleases(1, $condition);
        $this->spec($releases->getSize())->should->be(1);
    }
    public function itリリースファイルの取得()
    {
        $file = $this->WikiManager->getReleaseFile(1, 1, 2);
        $this->spec($file)->shouldNot->beNull();
        $this->spec($file->id)->should->be(2);
        $this->spec($file->wiki_id)->should->be(1);
        $this->spec($file->release_id)->should->be(1);
    }
    public function itリリースファイルの取得：複数()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->setLimit(1);
        $files = $this->WikiManager->getReleaseFiles(1, 1, $condition);
        $this->spec($files->getSize())->should->be(1);
    }

    public function itメンテナーの取得()
    {
        $maintener = $this->WikiManager->getMaintener(1, 2);
        $this->spec($maintener)->shouldNot->beNull();
        $this->spec($maintener->id)->should->be(2);
        $this->spec($maintener->wiki_id)->should->be(1);
        //第二引数はconditionも可能
        $condition = $this->WikiManager->getCondition();
        $condition->where->id = 3;
        $maintener = $this->WikiManager->getMaintener(1, $condition);
        $this->spec($maintener->id)->should->be(3);
    }
    public function itメンテナーの取得：複数()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->setLimit(2);
        $mainteners = $this->WikiManager->getMainteners(1, $condition);
        $this->spec($mainteners->getSize())->should->be(2);
    }

    //操作系
    public function it追加()
    {
        $dto = new stdClass();
        $dto->name = 'Bushi Framework';
        $dto->description = '腹を切らせていただく！';
        $wiki = $this->WikiManager->add($dto);
        $this->spec($wiki->name)->should->be('Bushi Framework');
        $this->spec($wiki->description)->should->be('腹を切らせていただく！');
        $this->WikiManager->add($dto);
    }
    public function it保存()
    {
        $wiki = $this->WikiManager->get(2);
        $wiki->name = 'Nobushi Framework';
        $wiki->description = '落ちますた。';
        $this->WikiManager->save($wiki);
        $wiki = $this->WikiManager->get(2);
        $this->spec($wiki->name)->should->be('Nobushi Framework');
        $this->spec($wiki->description)->should->be('落ちますた。');
    }
    public function it編集()
    {
        $this->WikiManager->edit(2, array('name' => 'Ochimusya'));
        $wiki = $this->WikiManager->get(2);
        $this->spec($wiki->name)->should->be('Ochimusya');
    }
    public function it破壊()
    {
        $wiki = $this->WikiManager->get(2);
        $this->spec($wiki)->shouldNot->beNull();
        $this->WikiManager->destroy($wiki);
        $wiki = $this->WikiManager->get(2);
        $this->spec($wiki)->should->beNull();
    }
    public function it削除()
    {
        $wiki = $this->WikiManager->get(3);
        $this->spec($wiki)->shouldNot->beNull();
        $this->WikiManager->delete($wiki->id);
        $wiki = $this->WikiManager->get(3);
        $this->spec($wiki)->should->beNull();
    }

    public function itリリースの追加()
    {
        $dto = new stdClass();
        $dto->version = '2.0.1';
        $dto->stability = 'stable';
        $dto->datetime = '2009-12-11 12:34:56';
        $release = $this->WikiManager->addRelease(1, $dto);
        $this->spec($release->wiki_id)->should->be(1);
        $this->spec($release->version)->should->be('2.0.1');
        $this->spec($release->stability)->should->be('stable');
        $this->spec($release->datetime)->should->be('2009-12-11 12:34:56');
        $release = $this->WikiManager->addRelease(1, $dto);
    }
    public function itリリースの保存()
    {
        $release = $this->WikiManager->getRelease(1, 2);
        $release->stability = 'alpha';
        $this->WikiManager->saveRelease($release);
        $release = $this->WikiManager->getRelease(1, 2);
        $this->spec($release->stability)->should->be('alpha');

    }
    public function itリリースの編集()
    {
        $this->WikiManager->editRelease(1, 2, array('version' => '2.0.2', 'stability' => 'beta'));
        $release = $this->WikiManager->getRelease(1, 2);
        $this->spec($release->version)->should->be('2.0.2');
        $this->spec($release->stability)->should->be('beta');
    }
    public function itリリースの破壊()
    {
        $release = $this->WikiManager->getRelease(1, 2);
        $this->spec($release)->shouldNot->beNull();
        $this->WikiManager->destroyRelease($release);
        $release = $this->WikiManager->getRelease(1, 2);
        $this->spec($release)->should->beNull();
    }
    public function itリリースの削除()
    {
        $release = $this->WikiManager->getRelease(1, 3);
        $this->spec($release)->shouldNot->beNull();
        $this->WikiManager->deleteRelease($release->wiki_id, $release->id);
        $release = $this->WikiManager->getRelease(1, 3);
        $this->spec($release)->should->beNull();
    }

    public function itリリースファイルの追加()
    {
        $dto = new stdClass();
        $dto->filename = 'Samurai-2.0.2-stable.tgz';
        $dto->size = 123456;
        $file = $this->WikiManager->addReleaseiFile(1, 1, $dto);
        $this->spec($file->wiki_id)->should->be(1);
        $this->spec($file->release_id)->should->be(1);
        $this->spec($file->filename)->should->be('Samurai-2.0.2-stable.tgz');
        $this->spec($file->size)->should->be(123456);
        $file = $this->WikiManager->addReleaseiFile(1, 1, $dto);
    }
    public function itリリースファイルの保存()
    {
        $file = $this->WikiManager->getReleaseFile(1, 1, 1);
        $file->size = 200000;
        $this->WikiManager->saveReleaseFile($file);
        $file = $this->WikiManager->getReleaseFile(1, 1, 1);
        $this->spec($file->size)->should->be(200000);
    }
    public function itリリースファイルの編集()
    {
        $this->WikiManager->editReleaseFile(1, 1, 1, array('size' => 987654));
        $file = $this->WikiManager->getReleaseFile(1, 1, 1);
        $this->spec($file->size)->should->be(987654);
    }
    public function itリリースファイルの破壊()
    {
        $file = $this->WikiManager->getReleaseFile(1, 1, 1);
        $this->spec($file)->shouldNot->beNull();
        $this->WikiManager->destroyReleaseFile($file);
        $file = $this->WikiManager->getReleaseFile(1, 1, 1);
        $this->spec($file)->should->beNull();
    }
    public function itリリースファイルの削除()
    {
        $file = $this->WikiManager->getReleaseFile(1, 1, 2);
        $this->spec($file)->shouldNot->beNull();
        $this->WikiManager->deleteReleaseFile($file->wiki_id, $file->release_id, $file->id);
        $file = $this->WikiManager->getReleaseFile(1, 1, 2);
        $this->spec($file)->should->beNull();
    }

    public function itメンテナーの追加()
    {
        $dto = new stdClass();
        $dto->name = 'falcon';
        $dto->mail = 'falcon@samurai-fw.org';
        $dto->role = 'developer';
        $maintener = $this->WikiManager->addMaintener(1, $dto);
        $this->spec($maintener->wiki_id)->should->be(1);
        $this->spec($maintener->name)->should->be('falcon');
        $this->spec($maintener->mail)->should->be('falcon@samurai-fw.org');
        $this->spec($maintener->role)->should->be('developer');
        $maintener = $this->WikiManager->addMaintener(1, $dto);
    }
    public function itメンテナーの保存()
    {
        $maintener = $this->WikiManager->getMaintener(1, 3);
        $maintener->name = 'kiuchi';
        $this->WikiManager->saveMaintener($maintener);
        $maintener = $this->WikiManager->getMaintener(1, 3);
        $this->spec($maintener->name)->should->be('kiuchi');

    }
    public function itメンテナーの編集()
    {
        $this->WikiManager->editMaintener(1, 3, array('name' => 'satoshi', 'mail' => 'satoshi@kiuchi.jp'));
        $maintener = $this->WikiManager->getMaintener(1, 3);
        $this->spec($maintener->name)->should->be('satoshi');
        $this->spec($maintener->mail)->should->be('satoshi@kiuchi.jp');
    }
    public function itメンテナーの破壊()
    {
        $maintener = $this->WikiManager->getMaintener(1, 3);
        $this->spec($maintener)->shouldNot->beNull();
        $this->WikiManager->destroyMaintener($maintener);
        $maintener = $this->WikiManager->getMaintener(1, 3);
        $this->spec($maintener)->should->beNull();
    }
    public function itメンテナーの削除()
    {
        $maintener = $this->WikiManager->getMaintener(1, 4);
        $this->spec($maintener)->shouldNot->beNull();
        $this->WikiManager->deleteMaintener($maintener->wiki_id, $maintener->id);
        $maintener = $this->WikiManager->getMaintener(1, 4);
        $this->spec($maintener)->should->beNull();
    }





    //準備
    public function beforeAll()
    {
        //コンポーネント準備
        $this->WikiManager = new Web_Package_Manager();
        $this->WikiManager->AG = ActiveGatewayManager::getActiveGateway('sandbox');
        //DB作成
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki` (
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
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki_mainteners` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `wiki_id` int(11) NOT NULL DEFAULT '0' COMMENT '=wiki.id',
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
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki_releases` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `wiki_id` int(11) NOT NULL DEFAULT '0' COMMENT '=wiki.id',
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
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki_releases_files` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `wiki_id` int(11) NOT NULL DEFAULT '0' COMMENT '=wiki.id',
                `release_id` int(11) NOT NULL DEFAULT '0' COMMENT '=wiki_releases.id',
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
            $this->WikiManager->AG->create('wiki', $data);
        }

        $datas = array(
            array('wiki_id' => 1, 'name' => 'メンテナー１', 'mail' => 'maintener1@samurai-fw.org', 'role' => 'lead'),
            array('wiki_id' => 1, 'name' => 'メンテナー２', 'mail' => 'maintener2@samurai-fw.org', 'role' => 'developer'),
            array('wiki_id' => 1, 'name' => 'メンテナー３', 'mail' => 'maintener3@samurai-fw.org', 'role' => 'contributor'),
        );
        foreach($datas as $data){
            $this->WikiManager->AG->create('wiki_mainteners', $data);
        }

        $datas = array(
            array('wiki_id' => 1, 'version' => '2.0.0', 'stability' => 'alpha', 'datetime' => '2009-11-30 12:00:00'),
        );
        foreach($datas as $data){
            $this->WikiManager->AG->create('wiki_releases', $data);
        }

        $datas = array(
            array('wiki_id' => 1, 'release_id' => 1, 'filename' => 'Samurai-2.0.0-stable.tgz', 'size' => 1234),
            array('wiki_id' => 1, 'release_id' => 1, 'filename' => 'Samurai-2.0.0-stable.zip', 'size' => 5678),
        );
        foreach($datas as $data){
            $this->WikiManager->AG->create('wiki_releases_files', $data);
        }

    }
}

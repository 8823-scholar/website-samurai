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
        $this->WikiManager->setLocale('ja');
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
        $condition->where->id = 10;
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

    public function itコメントの取得()
    {
        $comment = $this->WikiManager->getComment(1, 1);
        $this->spec($comment)->shouldNot->beNull();
        $this->spec($comment->id)->should->be(1);
        $this->spec($comment->wiki_id)->should->be(1);
        //第二引数はconditionも可能
        $condition = $this->WikiManager->getCondition();
        $condition->where->id = 2;
        $comment = $this->WikiManager->getComment(1, $condition);
        $this->spec($comment)->shouldNot->beNull();
        $this->spec($comment->id)->should->be(2);
    }
    public function itコメントの取得：複数()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->setLimit(1);
        $comments = $this->WikiManager->getComments(1, $condition);
        $this->spec($comments->getSize())->should->be(1);
    }


    //操作系
    public function it追加()
    {
        $dto = new stdClass();
        $dto->name = 'spec/example1';
        $dto->content = 'うんたらかんたら';
        $wiki = $this->WikiManager->add($dto);
        $this->spec($wiki->name)->should->be('spec/example1');
        $this->spec($wiki->content)->should->be('うんたらかんたら');
        $this->WikiManager->add($dto);
    }
    public function it保存()
    {
        $wiki = $this->WikiManager->get(3);
        $wiki->name = 'spec/example2';
        $wiki->content = '編集しますた。';
        $this->WikiManager->save($wiki);
        $wiki = $this->WikiManager->get(3);
        $this->spec($wiki->name)->should->be('spec/example2');
        $this->spec($wiki->content)->should->be('編集しますた。');
    }
    public function it編集()
    {
        $this->WikiManager->edit(3, array('name' => 'spec/example2:edited'));
        $wiki = $this->WikiManager->get(3);
        $this->spec($wiki->name)->should->be('spec/example2:edited');
    }
    /*
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
     */
    /* }}} */





    //準備
    public function beforeAll()
    {
        //コンポーネント準備
        $this->WikiManager = new Web_Wiki_Manager();
        $this->WikiManager->AG = ActiveGatewayManager::getActiveGateway('sandbox');
        //DB作成
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki` (
                `id` int(11) NOT NULL auto_increment,
                `name` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'ページ名',
                `content` text collate utf8_unicode_ci NOT NULL COMMENT '内容',
                `locale` varchar(3) collate utf8_unicode_ci NOT NULL default 'ja' COMMENT '言語',
                `localized_for` int(11) default NULL COMMENT 'あるWIKI翻訳の場合(=wiki.id)',
                `revision` int(11) NOT NULL default '1' COMMENT 'リビジョン番号',
                `created_by` int(11) NOT NULL default '0' COMMENT '=user.id',
                `updated_by` int(11) NOT NULL default '0' COMMENT '=user.id',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`),
                KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WIKI';
        ");
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki_comments` (
                `id` int(11) NOT NULL auto_increment,
                `wiki_id` int(11) NOT NULL default '0' COMMENT '=wiki.id',
                `user_id` int(11) default NULL COMMENT '=user.id',
                `name` varchar(128) collate utf8_unicode_ci default NULL COMMENT '名前（未ログインの場合に限る）',
                `comment` text collate utf8_unicode_ci NOT NULL COMMENT 'コメント',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WIKIへのコメント';
        ");
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki_histories` (
                `id` int(11) NOT NULL auto_increment,
                `wiki_id` int(11) NOT NULL default '0' COMMENT '=wiki.id',
                `name` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '名前',
                `content` text collate utf8_unicode_ci NOT NULL COMMENT '内容',
                `revision` int(11) NOT NULL default '1' COMMENT 'リビジョン番号',
                `updated_by` int(11) NOT NULL default '0' COMMENT '=user.id(このバージョンにおける更新者)',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WIKIの編集履歴';
        ");
        //データ挿入
        $datas = array(
            array('name' => 'FrontPage', 'content' => '[ja] FrontPageのcontentです。', 'locale' => 'ja', 'revision' => 3),
            array('name' => 'FrontPage', 'content' => '[en] This is content of FrontPage.', 'locale' => 'en', 'localized_for' => 1),
            array('name' => 'directory/page', 'content' => 'このページにはまだ翻訳版がありません。', 'locale' => 'ja')
        );
        foreach($datas as $data){
            $this->WikiManager->AG->create('wiki', $data);
        }

        $datas = array(
            array('wiki_id' => 1, 'user_id' => 1, 'name' => NULL, 'comment' => 'comment1'),
            array('wiki_id' => 1, 'user_id' => NULL, 'name' => 'falcon', 'comment' => 'comment2'),
            array('wiki_id' => 2, 'user_id' => 1, 'name' => 'falcon', 'comment' => 'comment3'),
        );
        foreach($datas as $data){
            $this->WikiManager->AG->create('wiki_comments', $data);
        }
    }
}
